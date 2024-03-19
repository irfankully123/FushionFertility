<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function index(Request $request): Response
    {
        $search = $request->input('search');
        return Inertia::render('Admin/Transactions/TransactionIndex', [
            'transactions' => Transaction::query()
                ->when($request, function ($query) use ($search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('patient_id', 'like', '%' . $search . '%')
                        ->orWhere('transaction_date', 'like', '%' . $search . '%')
                        ->orWhere('amount', 'like', '%' . $search . '%')
                        ->orWhere('payment_method', 'like', '%' . $search . '%')
                        ->orWhere('card_brand', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }
}
