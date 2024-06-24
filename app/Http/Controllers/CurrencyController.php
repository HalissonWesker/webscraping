<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function getCurrencyData(Request $request)
    {
        $codeOrNumbers = $request->input('code') ?? $request->input('number');
        
        if (is_array($codeOrNumbers)) {
            $results = [];
            foreach ($codeOrNumbers as $codeOrNumber) {
                $results[] = $this->currencyService->getCurrencyData($codeOrNumber);
            }
            return response()->json($results);
        }

        return response()->json($this->currencyService->getCurrencyData($codeOrNumbers));
    }
}
