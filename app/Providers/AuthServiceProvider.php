<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

// use App\Models\Passport\AuthCode;
// use App\Models\Passport\Client;
// use App\Models\Passport\PersonalAccessClient;
// use App\Models\Passport\Token;

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
    public function boot()
    {
        $this->registerPolicies();

        //
        Passport::routes();

        //? If we want to use our manual models
        // Passport::useTokenModel(Token::class);      
        // Passport::useClientModel(Client::class);
        // Passport::useAuthCodeModel(AuthCode::class);
        // Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

    }
}
