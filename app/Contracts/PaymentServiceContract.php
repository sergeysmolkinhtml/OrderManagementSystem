<?php


namespace App\Contracts;

use App\Models\Order;

interface PaymentServiceContract
{
    public function charge();

    public function setPayer($payer);

    public function setReceiver($receiver);

    public function setAmount($amount);

    public function setDescription($description);

    public function setConfig();

    public function setOrderInfo(Order $order);

    public function getOrderId();
}
