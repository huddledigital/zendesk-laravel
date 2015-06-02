<?php namespace Huddle\Zendesk\Providers;

use Zendesk;
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
	public function register() {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/zendesk-laravel.php', 'zendesk-laravel'
        );
	}

	/**
	 * Bind service to 'zendesk' for use with Facade
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->app->bind('zendesk','Huddle\Zendesk\Services\ZendeskService');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}