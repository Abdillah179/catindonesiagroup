<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

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

        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::define('ppicplant1gate', function (User $user) {
            return $user->role === 2 && $user->departemen === 'PPIC' && $user->plant === 'Plant 1';
        });

        Gate::define('ppicplant2gate', function (User $user) {
            return $user->role === 3 && $user->departemen === 'PPIC' && $user->plant === 'Plant 2';
        });

        Gate::define('ppicplant3gate', function (User $user) {
            return $user->role === 4 && $user->departemen === 'PPIC' && $user->plant === 'Plant 3';
        });

        Paginator::useBootstrapFive();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email')
                ->line('Silahkan Klik Tombol Button Dibawah Ini, Untuk Proses Verifikasi Email.')
                ->action('Verifikasi Email', $url);
        });
    }
}
