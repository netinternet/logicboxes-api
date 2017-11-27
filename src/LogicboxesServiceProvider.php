<?php
namespace Netinternet\Logicboxes;

use Illuminate\Support\ServiceProvider;

class LogicboxesServiceProvider extends ServiceProvider
{
    /**
     * Indicates of loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['logicboxes'];
    }

    public function boot()
    {
        $this->handleConfiguration();
    }

    public function handleConfiguration()
    {
        $configPath = __DIR__.'/../config/logicboxes.php';

        $this->publishes([$configPath => config_path('logicboxes.php')], 'config');
        // Merge config files...
        $this->mergeConfigFrom($configPath, 'logicboxes');
    }
    /**
     * Register the package services.
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->singleton('logicboxes', function ($app) {
            return new Logicboxes();
        });
    }
}
