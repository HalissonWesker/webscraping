<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CurrencyRepositoryInterface;
use App\Repositories\Eloquent\CurrencyRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
    }

    public function boot()
    {
        //
    }
}
