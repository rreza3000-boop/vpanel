<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            $settings = Schema::hasTable('settings')
                ? Setting::all()->pluck('value', 'key')
                : collect();
        } catch (\Throwable $e) {
            // Database unavailable (e.g. during image build) - boot without settings
            $settings = collect();
        }

        View::share('settings', $settings);
    }
}
