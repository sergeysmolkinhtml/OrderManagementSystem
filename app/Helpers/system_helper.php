<?php

use App\Models\Order;

if (!function_exists('getPlatformFeeForOrder')) {
    /**
     * return calculated application fee for the given order value
     */
    function getPlatformFeeForOrder($order) : float | int
    {
        if (!$order instanceof Order) {
            $order = Order::findOrFail($order);
        }

        $shop = $order->shop;
        $plan = null;
        $transaction_fee = 0;
        $commission = 0;

        // Return zero is on trial period
        if (is_subscription_enabled()) {
            if ($shop->onTrial()) {
                return 0;
            }

            if ($plan = $shop->plan) {
                $transaction_fee = $plan->transaction_fee;
            }
        }

        // Dynamic commission
        if (is_incevio_package_loaded('dynamicCommission')) {
            // Check if custom commission for the shop
            if ($shop->commission_rate !== null) {
                if ($shop->commission_rate > 0) {
                    $commission = ($shop->commission_rate * $order->total) / 100;
                }

                return $commission;
            }

            // Get the dynamic commission amount
            $dynamicCommissions = get_from_option_table('dynamicCommission_milestones');

            // Sort decs milestones mased on amount
            usort($dynamicCommissions, function ($a, $b) {
                return $b['milestone'] - $a['milestone'];
            });

            // Dynamic commission calculation via milestone amount:
            if ($dynamicCommissions) {
                // Get total sold amount
                $sold_amount = $shop->periodic_sold_amount;

                foreach ($dynamicCommissions as $commission) {
                    if ($sold_amount >= $commission['milestone']) {
                        $commission = ($commission['commission'] * $order->total) / 100;

                        return $commission;
                    }
                }
            }
        }

        // Get commissions from the subscription plan
        if ($plan && $plan->marketplace_commission > 0) {
            $commission = ($plan->marketplace_commission * $order->total) / 100;
        }

        return $commission + $transaction_fee;
    }
}
