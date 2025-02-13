<?php

namespace App\Providers;

use App\Models\Video;
use App\Policies\VideoPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
    public function boot()
    {
        $this->register();

        // Definir un Gate per a Super Admin
        Gate::define('manage-everything', function ($user) {
            return $user->hasRole('super_admin');
        });

        // Registrar polítiques
        Gate::policy(Video::class, VideoPolicy::class);

        Gate::define('manage-videos', function ($user) {
            return $user->hasRole('video_manager');
        });

        Gate::define('view-dashboard', function ($user) {
            return $user->hasRole('video_manager') || $user->hasRole('super_admin');
        });

        Gate::define('edit-videos', [VideoPolicy::class, 'update']);
    }
}
