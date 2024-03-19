<?php

namespace App\Services;

use App\Models\CustomerInvoice;
use App\Models\StripeSession;
use Exception;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Nette\OutOfRangeException;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use App\Models\Transaction;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class StripePaymentService
{

    #[ArrayShape(['customer' => "string", 'payment_method_types' => "string[]", 'line_items' => "array[]", 'mode' => "string", 'metadata' => "bool[]", 'success_url' => "string", 'cancel_url' => "string"])]
    public function createCheckoutSessionBody(string $customerId, Appointment $appointment): array
    {
        return [
            'customer' => $customerId,
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Doctor Name: ' . $appointment->doctor->user->name,
                            'description' => 'Appointment Datetime = ' . $appointment->appointment_time . ' ' . $appointment->appointment_date,
                        ],
                        'unit_amount' => $appointment->amount * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'invoice_generated' => true,
            ],
            'success_url' => route('payment.success', ['appointment' => $appointment]) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('payment.cancel', [], true),
        ];
    }

    /**
     * @throws ApiErrorException
     */
    private function createStripeCustomer(): Customer
    {
        $user = Auth::user();
        $patient = $user->patient ?? null;

        return Customer::create([
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'description' => 'patient',
            'address' => [
                'line1' => $patient->address ?? '',
                'city' => $patient->city ?? '',
                'state' => $patient->state ?? '',
            ],
            'phone' => $user->contact ?? '',
        ]);
    }

    /**
     * @throws Exception
     */
    private function saveStripeSession(string $sessionId, Customer $customer): void
    {
        DB::beginTransaction();
        try {
            $stripeSession = new StripeSession([
                'stripe_session_id' => $sessionId,
                'stripe_customer_id' => $customer->id,
                'customer_name' => $customer->name,
            ]);
            $stripeSession->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }

    /**
     * @throws ApiErrorException
     */
    private function createStripeInvoice(string $customerId): Invoice
    {
        $invoice = Invoice::create([
            'customer' => $customerId,
            'auto_advance' => true,
        ]);

        if (!$invoice) {
            throw new OutOfRangeException();
        }

        $updatedInvoice = Invoice::retrieve($invoice->id);
        $updatedInvoice->finalizeInvoice();

        return $updatedInvoice;
    }

    /**
     * @throws Exception
     */
    private function createTransaction(string $transactionDate, float $amount, string $paymentMethodType, string $cardBrand): Transaction
    {
        $user = Auth::user();
        $patient = $user->patient ?? null;

        DB::beginTransaction();
        try {
            $transaction = new Transaction([
                'patient_id' => $patient->id,
                'transaction_date' => $transactionDate,
                'amount' => $amount,
                'payment_method' => $paymentMethodType,
                'card_brand' => $cardBrand,
            ]);
            $transaction->save();
            DB::commit();

            return $transaction;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws Exception
     */
    private function createCustomerInvoice(int $transactionId, string $invoiceNumber, string $invoicePdf, float $totalAmount): void
    {
        DB::beginTransaction();
        try {
            $customerInvoice = new CustomerInvoice([
                'transaction_id' => $transactionId,
                'invoice_number' => $invoiceNumber,
                'invoice_pdf' => $invoicePdf,
                'total_amount' => $totalAmount,
            ]);
            $customerInvoice->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws Exception
     */
    private function changeAppointmentStatus(Appointment $appointment): void
    {
        DB::beginTransaction();
        try {
            $appointment->forceFill([
                'status' => 'Paid',
            ])->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }

    /**
     * @throws ApiErrorException
     * @throws Exception
     */
    public function createCheckoutSession(Appointment $appointment): Session
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = $this->createStripeCustomer();
        $session = Session::create($this->createCheckoutSessionBody($customer->id, $appointment));
        $this->saveStripeSession($session->id, $customer);

        if (!$session) {
            throw new NotFoundHttpException();
        }

        return $session;
    }

    /**
     * @throws ApiErrorException
     */
    private function retrieveSession(string $sessionId): Session
    {
        $session = Session::retrieve($sessionId);
        if (!$session) {
            throw new NotFoundHttpException();
        }
        return $session;
    }

    /**
     * @throws ApiErrorException
     */
    private function retrieveCustomer(Session $session): Customer
    {
        $customer = Customer::retrieve($session->customer);
        if (!$customer) {
            throw new NotFoundHttpException();
        }
        return $customer;
    }

    private function validateStripeSession(Session $session, Customer $customer): void
    {
        StripeSession::where('stripe_session_id', $session->id)
            ->where('stripe_customer_id', $customer->id)
            ->where('customer_name', $customer->name)
            ->firstOrFail();

        if ($session->payment_status !== 'paid') {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @throws ApiErrorException
     */
    private function retrievePaymentIntent(Session $session): PaymentIntent
    {
        return PaymentIntent::retrieve($session->payment_intent);
    }

    /**
     * @throws ApiErrorException
     */
    private function retrievePaymentMethod(PaymentIntent $paymentIntent): PaymentMethod
    {
        return PaymentMethod::retrieve($paymentIntent->payment_method);
    }


    /**
     * @throws ApiErrorException
     * @throws Exception
     */
    public function processPayment(Appointment $appointment, Request $request): void
    {
        DB::beginTransaction();
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionId = $request->get('session_id');
            $session = $this->retrieveSession($sessionId);
            $customer = $this->retrieveCustomer($session);
            $this->validateStripeSession($session, $customer);

            $amountPaid = $session->amount_total / 100;
            $paymentIntent = $this->retrievePaymentIntent($session);
            $paymentMethod = $this->retrievePaymentMethod($paymentIntent);
            $transactionDate = date('Y-m-d', $paymentIntent->created);

            $updatedInvoice = $this->createStripeInvoice($customer->id);
            $transaction = $this->createTransaction($transactionDate, $amountPaid, $paymentMethod->type, $paymentMethod->card->brand);
            $this->createCustomerInvoice($transaction->id, $updatedInvoice->number, $updatedInvoice->invoice_pdf, $transaction->amount);
            $this->changeAppointmentStatus($appointment);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }


}

