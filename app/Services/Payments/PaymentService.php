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
    public string $receiver;
    public string $status;
    public $payer;
    public $order;
    public $fee;
    public $amount;
    public mixed $currency_code;
    public $meta;
    public $description;
    public $sandbox;
    // public $success;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->receiver = 'platform';
        $this->currency_code = getCurrencyCode();

        $this->status = self::STATUS_INITIATED;

        // Get payee model
        if ($this->request->has('payer')) {
            $this->setPayer($this->request->payer);
        } elseif (Auth::guard('customer')->check()) {
            $this->setPayer(Auth::guard('customer')->user());
        } elseif (Auth::guard('api')->check()) {
            $this->setPayer(Auth::guard('api')->user());
        } elseif (Auth::guard('web')->check() && Auth::user()->isMerchant()) {
            $this->setPayer(Auth::user()->owns);
        }
    }

    /**
     * The payment will execute here, overwite on child class
     */
    public function charge(): PaymentService
    {
        // Set the status as awaiting to process the payment later
        $this->status = self::STATUS_PENDING;

        return $this;
    }

    /**
     * Set the payee
     * return $this
     */
    public function setPayer($payer): PaymentService
    {
        $this->payer = $payer;

        return $this;
    }

    public function setReceiver($receiver = 'platform'): PaymentService
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function setAmount($amount): PaymentService
    {
        $this->amount = $amount;

        return $this;
    }

    public function setDescription($description = ''): PaymentService
    {
        $this->description = $description;

        return $this;
    }

    public function setConfig(): PaymentService
    {
        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrderInfo(Order $order): PaymentService
    {
        $this->order = $order;

        return $this;
    }

    public function getOrderId()
    {
        if ($this->order) {
            if (is_array($this->order)) {
                return implode('-', array_column($this->order, 'id'));
            }

            if (! $this->order instanceof Order) {
                $this->order = Order::findOrFail($this->order);
            }

            return $this->order->id;
        }

        return NULL;
    }



}
