<?php

namespace App\Providers;
//======= Models =======
use App\Invoice;
//======= end of models =======

//========= Policies =========
use App\Policies\InvoicePolicy;
//===== end of policies ======

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        // Invoice::class => InvoicePolicy::class,
        'App\User' => PagesPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(); // Added for passport api support

        // Api Gates
        Gate::define('delete', 'App\Policies\ProductPolicy@delete');
    }
}
