<?php

namespace App\Providers;
//======= Models =======
use App\Invoice;
//======= end of models =======

//========= Policies =========
use App\Policies\InvoicePolicy;
use App\Policies\PagesPolicy;
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

        // Web Gates
        Gate::define('admin', 'App\Policies\PagesPolicy@admin');
        Gate::define('admin-two', 'App\Policies\PagesPolicy@admin_two');
        Gate::define('manage-three', 'App\Policies\PagesPolicy@manage_three');
        Gate::define('empl-four', 'App\Policies\PagesPolicy@empl_four');

        // Api Gates
        Gate::define('delete', 'App\Policies\ProductPolicy@delete');
    }
}
