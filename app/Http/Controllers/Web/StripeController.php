<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\StripePaymentService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;


class StripeController extends Controller
{


    /**
     * @throws ApiErrorException|Exception
     */
    public function createCheckoutSession(Appointment $appointment): RedirectResponse
    {
        $session = (new StripePaymentService())->createCheckoutSession($appointment);
        return redirect($session->url);
    }

    /**
     * @throws ApiErrorException
     */
    public function paymentSuccessful(Appointment $appointment, Request $request): RedirectResponse
    {

        (new StripePaymentService())->processPayment($appointment, $request);

        return redirect()->route('patient.dashboard.schedule.appointments', [
            'user' => Auth::id()
        ])->with('success', 'Payment Successful');
    }


    public function paymentCancel(): RedirectResponse
    {
        return to_route('patient.dashboard', Auth::id())->with('error', 'Payment Canceled');
    }


}
