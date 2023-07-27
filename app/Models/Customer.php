<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class Customer extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use Billable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The guard used by the model.
     *
     * @var string
     */
    protected string $guard = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nice_name',
        'email',
        'phone',
        'phone_verified',
        'password',
        'dob',
        'sex',
        'description',
        'stripe_id',
        'card_holder_name',
        'card_brand',
        'card_last_four',
        'active',
        'remember_token',
        'verification_token',
        'accepts_marketing',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be casted to boolean types.
     *
     * @var array
     */
    protected $casts = [
        'last_visited_at' => 'datetime',
        'dob' => 'date',
        'active' => 'boolean',
        'accepts_marketing' => 'boolean',
        'phone_verified_at' => 'datetime',
    ];
}
