<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Resource;
use App\Models\Reservation;
use App\Policies\ResourcePolicy;
use App\Policies\ReservationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Resource::class => ResourcePolicy::class,
        Reservation::class => ReservationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
