<?php

namespace App\Providers;

use App\Models\Koleksi;
use App\Policies\KoleksiPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Koleksi::class, KoleksiPolicy::class);
    }
}