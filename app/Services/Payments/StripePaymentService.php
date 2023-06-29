<?php

namespace App\Services\Payments;

use App\Models\Customer;
use Psy\Util\Str;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Token;

class StripePaymentService extends PaymentService
{
    public int $stripe_account_id;
    public $token;
    public $card;
    public $fee;
    public $meta;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * @throws ApiErrorException
     */
    public function setConfig(): static
    {
        $this->setStripeAccountId();

        if ($this->request->card_number) {
            $this->setCardInfo();
        }

        $this->setStripeToken();

        return $this;
    }

    /**
     * @throws ApiErrorException
     */
    public function charge(): static
    {
        $data = [
            'amount'      => getCentsFromDollar($this->amount),
            'currency'    => getCurrencyCode(),
            'description' => $this->description,
            'metadata'    => $this->meta
        ];

        if ($this->chargeSavedCustomer()) {
            $data['customer'] = $this->payer->stripe_id;
        } else {
            $data['source'] = $this->token;
        }

        if (
           $this->receiver == 'merchant' &&
           $this->order &&
           $this->payer instanceof Customer
        ) {
            if (! $this->fee) {
                $this->setPlatformFee(getPlatformFeeForOrder($this->order));
            }

            $data['application_fee'] = $this->fee;
        }

        $result = Charge::create($data, [
           'stripe_account' => $this->stripe_account_id,
        ]);

        if ($result->status == 'succeeded') {
            $this->status = self::STATUS_PAID;
        } else {
            $this->status = self::STATUS_ERROR;
        }

        return $this;
    }

    public function setPlatformFee($fee = 0): StripePaymentService
    {
        $this->fee = $fee > 0 ? getCentsFromDollar($fee) : 0;

        return $this;
    }

    private function setStripeAccountId()
    {
        if ($this->order && $this->receiver == 'merchant') {
            $this->stripe_account_id = $this->order->shop->config->stripe->stripe_user_id;
        } else {
            $this->stripe_account_id = config('services.stripe.account_id');
        }
    }

    private function setCardInfo()
    {
        $this->card = [
            'number'    => $this->request->card_number,
            'exp_month' => $this->request->exp_month,
            'exp_year'  => $this->request->exp_year,
            'cvc'       => $this->request->cvc,
        ];
    }

    /**
     * @throws ApiErrorException
     */
    private function setStripeToken()
    {
        if ($this->receiver == 'merchant' && $this->chargeSavedCustomer()) {
            $token = Token::create([
               'customer' => $this->payer->stripe_id,
            ], ['stripe_account' => $this->stripe_account_id]);

            $this->token = $token->id;

        } elseif ($this->card) {
            $token = Token::create([
               'card' => $this->card,
            ], ['stripe_account' => $this->stripe_account_id]);

            $this->token = $token;

        } else {
            $this->token = $this->request->cc_token;
        }
    }

    private function chargeSavedCustomer() : bool
    {
        return $this->payer &&
               $this->payer->hasBillingToken() &&
               ($this->request->has('remember_the_card') || $this->request->payment_method == 'saved_card');
    }

}
