<?php

namespace Suitcore\Currency;

use App\SuitEvent\Config\DefaultConfig;

trait ModelCurrencyTrait
{
    public function asCurrency($field)
    {
        $number = $this->{$field};

        if (method_exists($this, 'formatCurrency')) {
            return $this->formatCurrency($number);
        }

        if (function_exists('asCurrency')) {
            return asCurrency($number);
        }

        $currency = isset(DefaultConfig::getConfig()['metrics']['currency']) ? DefaultConfig::getConfig()['metrics']['currency'] : 'Rp';
        return $currency.'. '.number_format($number, 2, '.', ',');
    }
}
