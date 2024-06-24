<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function getCurrencyByCodeOrNumber($codeOrNumber)
    {
        return Currency::where('code', $codeOrNumber)
            ->orWhere('number', $codeOrNumber)
            ->first();
    }

    public function saveCurrencyData(array $currencyData)
    {
        return Currency::create($currencyData);
    }
}
