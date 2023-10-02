<?php

namespace VertexPortus\AutoMapper\Providers;

use Illuminate\Support\ServiceProvider;
use VertexPortus\AutoMapper\Services\AutoMapperPlusService;
use VertexPortus\AutoMapper\Contracts\AutoMapperServiceContract;

class AutoMapperServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function register(): void
	{
		$this->app->singleton(AutoMapperServiceContract::class, AutoMapperPlusService::class);
	}

	/**
	 * @return void
	 */
	public function boot(): void
	{
		// NADA
	}
}
