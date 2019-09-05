<?php

namespace CareSet\ZermeloBladeTreeCard;

use CareSet\Zermelo\Models\AbstractZermeloProvider;
use CareSet\ZermeloBladeTreeCard\Console\ZermeloBladeTreeCardInstallCommand;
use Illuminate\Support\Facades\Route;


Class ServiceProvider extends AbstractZermeloProvider
{

    public function onBeforeRegister()
	{

        /*
         * Register our zermelo view make command which:
         *  - Copies views
         *  - Exports configuration
         *  - Exports Assets
         */
        $this->commands([
            ZermeloBladeTreeCardInstallCommand::class
        ]);

        /*
         * Merge with main config so parameters are accessable.
         * Try to load config from the app's config directory first,
         * then load from the package.
         */
        if ( file_exists( config_path( 'zermelobladereecard.php' ) ) ) {

            $this->mergeConfigFrom(
                config_path( 'zermelobladetreecard.php' ), 'zermelobladetreecard'
            );
        } else {
            $this->mergeConfigFrom(
                __DIR__.'/../config/zermelobladetreecard.php', 'zermelobladetreecard'
            );
        }

        $this->registerWebRoutes();

        $this->loadViewsFrom( resource_path( 'views/zermelo' ), 'Zermelo');
	}

    /**
     * Load the given routes file if routes are not already cached.
     *
     * @param  string  $path
     * @return void
     */
    protected function loadRoutesFrom($path)
    {
        if (! $this->app->routesAreCached()) {
            require $path;
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerWebRoutes()
    {
        $configuration = $this->routeConfiguration();
        Route::group($configuration, function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Get the Nova route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        $middleware = config('zermelobladetreecard.MIDDLEWARE',[ 'web' ]);
        $middlewareString = implode(",",$middleware);

        return [
            'namespace' => 'CareSet\ZermeloBladeTreeCard\Http\Controllers',
            //  'domain' => config('zermelo.domain', null),
            'as' => 'zermelo.tabular.',
            'prefix' => config( 'zermelobladetreecard.URI_PREFIX' ),
            'middleware' => $middlewareString,
        ];
    }
}
