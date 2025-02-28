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
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected array $policies = [
        Video::class => VideoPolicy::class, // Registrem la política del model Video
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->register(); // Registrem les polítiques correctament

        // Definir un Gate per a Super Admin
        Gate::define('manage-everything', function ($user) {
            return $user->hasRole('super_admin');
        });

        Gate::define('manage-videos', function ($user) {
            return $user->hasRole('video_manager') || $user->hasRole('super_admin');
        });

        Gate::define('view-dashboard', function ($user) {
            return $user->hasRole('video_manager') || $user->hasRole('super_admin');
        });

        Gate::define('edit-videos', [VideoPolicy::class, 'update']);
    }
}
