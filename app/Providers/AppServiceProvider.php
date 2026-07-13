<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // ១. ត្រូវថែមបន្ទាត់នេះនៅខាងលើ

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind(); // ២. ត្រូវថែមបន្ទាត់នេះនៅក្នុង block boot()
        if (env('APP_ENV') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}