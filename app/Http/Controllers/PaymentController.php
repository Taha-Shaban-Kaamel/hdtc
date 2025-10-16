<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'plan'])
            ->latest()
            ->paginate(10);

        return view('payment.index', compact('payments'));
    }
}
