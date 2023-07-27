<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    const STATUS_WAITING_FOR_PAYMENT = 1;    // Default
    const STATUS_PAYMENT_ERROR = 2;
    const STATUS_CONFIRMED = 3;
    const STATUS_FULFILLED = 4;   // All status value less than this consider as unfulfilled
    const STATUS_AWAITING_DELIVERY = 5;
    const STATUS_DELIVERED = 6;
    const STATUS_RETURNED = 7;
    const STATUS_CANCELED = 8;
    const STATUS_DISPUTED = 9;

    const PAYMENT_STATUS_UNPAID = 1;       // Default
    const PAYMENT_STATUS_PENDING = 2;
    const PAYMENT_STATUS_PAID = 3;      // All status before paid value consider as unpaid
    const PAYMENT_STATUS_INITIATED_REFUND = 4;
    const PAYMENT_STATUS_PARTIALLY_REFUNDED = 5;
    const PAYMENT_STATUS_REFUNDED = 6;

    const FULFILMENT_TYPE_DELIVER = 'deliver';
    const FULFILMENT_TYPE_PICKUP = 'pickup';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_date',
        'subtotal',
        'taxes',
        'total',
        'order_number',
        'shop_id',
        'customer_id',
        'ship_to',
        'shipping_zone_id',
        'shipping_rate_id',
        'packaging_id',
        'item_count',
        'quantity',
        'shipping_weight',
        'taxrate',
        'total',
        'discount',
        'shipping',
        'packaging',
        'handling',
        'taxes',
        'grand_total',


    ];

    protected $casts = [
        'order_date'     => 'date:m/d/Y',
        'shipping_date'  => 'datetime',
        'payment_date'   => 'datetime',
        'goods_received' => 'boolean',
    ];

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'quantity');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name' => trans('app.guest_customer')
        ]);
    }
}
