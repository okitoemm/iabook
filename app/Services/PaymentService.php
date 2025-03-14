<?php

namespace App\Services;

use App\Models\Payment;
use Exception;

class PaymentService
{
    public function processPayment(array $data)
    {
        try {
            // Here you would integrate with your payment provider (Stripe, PayPal, etc.)
            
            $payment = Payment::create([
                'project_id' => $data['project_id'],
                'client_id' => auth()->id(),
                'artisan_id' => $data['artisan_id'],
                'amount' => $data['amount'],
                'status' => 'completed',
                'payment_method' => $data['payment_method'],
                'transaction_id' => uniqid('trans_')
            ]);

            return $payment;
        } catch (Exception $e) {
            throw new Exception('Payment processing failed: ' . $e->getMessage());
        }
    }
}
