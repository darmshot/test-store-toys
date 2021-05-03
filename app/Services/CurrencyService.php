<?php


namespace App\Services;


class CurrencyService
{
    private $currencies = array();

    public function __construct()
    {
        $this->currencies = config('catalog.currencies');
    }

    public function format($number, $currency, $value = '', $format = true)
    {
        $symbol_left   = $this->currencies[$currency]['symbol_left'];
        $symbol_right  = $this->currencies[$currency]['symbol_right'];
        $decimal_place = $this->currencies[$currency]['decimal_place'];

        if ( ! $value) {
            $value = $this->currencies[$currency]['value'];
        }

        $amount = $value ? (float) $number * $value : (float) $number;

        $amount = round($amount, (int) $decimal_place);


        if ( ! $format) {
            return $amount;
        }

        $string = '';

        if ($symbol_left) {
            $string .= $symbol_left;
        }

        $string .= number_format($amount, (int) $decimal_place, __('catalog.decimal_point'), __('catalog.thousand_point'));

        if ($symbol_right) {
            $string .= '&nbsp;' . $symbol_right;
        }

        return $string;
    }
}
