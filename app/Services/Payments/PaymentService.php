<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Contracts\PaymentServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentService implements PaymentServiceContract
{
    const STATUS_INITIATED = 'initiated';        // Default
    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_VALIDATING = 'validating';
    const STATUS_ERROR = 'error';

    public Request $request;
    public $paymentReceiver;
    public $receiver;
    public $order;
    public $fee;
    public $amount;
    public $currency_code;
    public $meta;
    public $description;
    public $sandbox;
    // public $success;
    public $status;

    public function __construct(Request $request) {}

    public function charge()
    {
        // TODO: Implement charge() method.
    }

    public function setPayee($payee)
    {
        // TODO: Implement setPayee() method.
    }

    public function setReceiver($receiver)
    {
        // TODO: Implement setReceiver() method.
    }

    public function setAmount($amount)
    {
        // TODO: Implement setAmount() method.
    }

    public function setDescription($description)
    {
        // TODO: Implement setDescription() method.
    }

    public function setConfig()
    {
        // TODO: Implement setConfig() method.
    }

    public function setOrderInfo(Order $order)
    {
        // TODO: Implement setOrderInfo() method.
    }

    public function getOrderId()
    {
        // TODO: Implement getOrderId() method.
    }
}
