<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
            $view->with('globalCategories', Category::forLocale()->where('is_active', true)->get());
            
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $enSettings = \App\Models\Setting::where('locale', 'en')->pluck('value', 'key')->toArray();
                
                if (app()->getLocale() !== 'en') {
                    $locSettings = \App\Models\Setting::forLocale()->pluck('value', 'key')->toArray();
                    $globalSettings = array_merge($enSettings, $locSettings);
                } else {
                    $globalSettings = $enSettings;
                }
                
                $view->with('globalSettings', $globalSettings);
            }
        });
    }
}
