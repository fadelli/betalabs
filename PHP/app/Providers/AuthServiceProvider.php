<?php

namespace App\Providers;

use Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Acoes;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);

        

        Gate::define('auth', function ($user, $role=NULL) {
            if($role === NULL){
                $actions = Route::current()->getAction();
                
                if(! isset($actions['role']) )
                    return false;

                $role = $actions['role'];
            }

            $objetoAcoes = new Acoes();
            $roles  = $objetoAcoes->roles($user->id);
            //dd($roles);
            if(in_array($role, $roles))
                return true;

            return false;
        });

    }
}
