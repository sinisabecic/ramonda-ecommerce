<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $admin = 'App\Http\Controllers\Admin';
    protected $blog = 'App\Http\Controllers\Blog';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapUsersRoutes();

        $this->mapPostsRoutes();

        $this->mapRolesRoutes();

        $this->mapPermissionsRoutes();

        $this->mapTagsRoutes();

        $this->mapCategoriesRoutes();
        $this->mapPhotosRoutes();
        $this->mapBlogRoutes();
        $this->mapCommentsRoutes();

        $this->mapProductsRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/web.php'));
    }

    protected function mapBlogRoutes()
    {
        Route::prefix('blog')
            ->middleware('web')
            ->namespace($this->blog)
            ->group(base_path('routes/web/blog.php'));
    }

    protected function mapPostsRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->admin)
            ->group(base_path('routes/web/posts.php'));
    }

    protected function mapProductsRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/products.php'));
    }

    protected function mapUsersRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->namespace) //? in users.php everything is set
            ->group(base_path('routes/web/users.php'));
    }

    protected function mapRolesRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth', 'admin']) // Also can 'role:Admin'
            ->namespace($this->admin)
            ->group(base_path('routes/web/roles.php'));
    }

    protected function mapPermissionsRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth', 'role:admin'])
            ->namespace($this->admin)
            ->group(base_path('routes/web/permissions.php'));
    }

    protected function mapTagsRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web'])
            ->namespace($this->admin)
            ->group(base_path('routes/web/tags.php'));
    }

    protected function mapCommentsRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->admin)
            ->group(base_path('routes/web/comments.php'));
    }

    protected function mapCategoriesRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/categories.php'));
    }

    protected function mapPhotosRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web'])
            ->namespace($this->admin)
            ->group(base_path('routes/web/photos.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
