<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Auth::class, function ($app) {
            $factory = (new Factory)
                ->withServiceAccount(storage_path('app/firebase-credentials.json'))
                ->withDatabaseUri('https://schoolapp-counseling-default-rtdb.asia-southeast1.firebasedatabase.app');

            return $factory->createAuth();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
