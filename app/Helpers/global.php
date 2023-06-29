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

        if (in_array(get_system_currency(), config('system.non_decimal_currencies'))) {
            $decimals = 0;
        }

        $value = number_format($value, $decimals, '.', '');

        return intval($value * 100);
    }
}

if (! function_exists('get_system_currency')) {
    function get_system_currency()
    {
        return config('system_settings.currency.iso_code');
    }
}
