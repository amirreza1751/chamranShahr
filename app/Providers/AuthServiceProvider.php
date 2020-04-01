<?php

namespace App\Providers;

use App\Models\Ad;
use App\Policies\AdPolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Ad::class => AdPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('create_book_ad', AdPolicy::class . '@create_book_ad');
        Gate::define('remove_book_ad', AdPolicy::class . '@remove_book_ad');
        Gate::resource('ads', AdPolicy::class);
    }
}
