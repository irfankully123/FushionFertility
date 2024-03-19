<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerInvoice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function index(Request $request): Response
    {
        $search = $request->input('search');

        return Inertia::render('Admin/Invoices/InvoiceIndex', [
            'invoices' => CustomerInvoice::query()
                ->when($request, function ($query) use ($search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('transaction_id', 'like', '%' . $search . '%')
                        ->orWhere('invoice_number', 'like', '%' . $search . '%')
                        ->orWhere('invoice_pdf', 'like', '%' . $search . '%')
                        ->orWhere('total_amount', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

}
