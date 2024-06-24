<?php

namespace App\Repositories;

interface CurrencyRepositoryInterface
{
    public function getCurrencyByCodeOrNumber($codeOrNumber);
    public function saveCurrencyData(array $currencyData);
}
