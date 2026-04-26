<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $defaults = [
                'clinicName' => 'CuraSure',
                'queueFormat' => 'Q-001',
                'defaultRole' => 'staff',
            ];

            if (!Schema::hasTable('settings')) {
                $view->with($defaults);
                return;
            }

            $view->with([
                'clinicName' => Setting::getValue('clinic_name', $defaults['clinicName']),
                'queueFormat' => Setting::getValue('queue_format', $defaults['queueFormat']),
                'defaultRole' => Setting::getValue('default_role', $defaults['defaultRole']),
            ]);
        });
    }
}
