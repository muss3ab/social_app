<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use App\Models\Friendship;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::bind('user', fn ($id) => User::findOrFail(id: $id));
        Route::bind('post', fn ($id) => Post::findOrFail(id: $id));
        Route::bind('comment', fn ($id) => Comment::findOrFail(id: $id));
        Route::bind('like', fn ($id) => Like::findOrFail(id: $id));
        Route::bind('friendship', fn ($id) => Friendship::findOrFail(id: $id));

    }
}
