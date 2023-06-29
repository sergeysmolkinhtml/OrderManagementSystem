<?php

if (! function_exists('getCentsFromDollar')) {
    /**
     * Get cent from decimal amount value.
     *
     * @param int $value
     *
     * @return int
     */
    function getCentsFromDollar(int $value = 0) : int
    {
        $decimals = 2;

        if (in_array(getSystemCurrency(), config('system.non_decimal_currencies'))) {
            $decimals = 0;
        }

        $value = number_format($value, $decimals, '.', '');

        return intval($value * 100);
    }
}

if (! function_exists('getSystemCurrency')) {
    function getSystemCurrency()
    {
        return config('system_settings.currency.iso_code');
    }
}

if (! function_exists('getCurrencyCode')) {
    function getCurrencyCode()
    {
        return config('system_settings.currency.iso_code') ?? 'USD';
    }
}
