<?php namespace Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Factory;

/**
 * The only difference is that the register() returns a Factory 
 * instantiated with last constructor explicitly providing '_page'
 * NOTE: you need to modify the provider's array in 
 * app/config/app.php to replace the default PaginationServiceProvider
 */
class PaginationServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('paginator', function($app)
		{
			$paginator = new Factory($app['request'], $app['view'], $app['translator'], '_page');

			$paginator->setViewName($app['config']['view.pagination']);

			$app->refresh('request', $paginator, 'setRequest');

			return $paginator;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('paginator');
	}

}
