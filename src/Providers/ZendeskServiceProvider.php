<?php namespace Huddle\Zendesk\Providers;

use Huddle\Zendesk\Services\NullService;
use Huddle\Zendesk\Services\ZendeskService;
use Illuminate\Support\ServiceProvider;

class ZendeskServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider and merge config.
     *
     * @return void
     */
    public function register()
    {
        $packageName = 'zendesk-laravel';
        $configPath = __DIR__.'/../../config/zendesk-laravel.php';

        $this->mergeConfigFrom(
            $configPath, $packageName
        );

        $this->publishes([
            $configPath => config_path(sprintf('%s.php', $packageName)),
        ]);
    }

    /**
     * Bind service to 'zendesk' for use with Facade.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('zendesk', function () {
            $driver = config('zendesk-laravel.driver', 'api');
            if (is_null($driver) || $driver === 'log') {
                return new NullService($driver === 'log');
            }

            return new ZendeskService;
        });
    }
}
