<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ Force HTTPS in production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // ✅ Global settings for all views
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