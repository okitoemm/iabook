<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string'
        ]);

        $payment = $this->paymentService->processPayment($validated);
        
        return redirect()->route('payments.success');
    }

    public function success()
    {
        return view('payments.success');
    }

    public function cancel()
    {
        return view('payments.cancel');
    }
}
