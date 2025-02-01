<?php

namespace VertexPortus\AutoMapper\Providers;

use Illuminate\Support\ServiceProvider;
use VertexPortus\AutoMapper\Services\AutoMapperPlusServiceImpl;
use VertexPortus\AutoMapper\Contracts\AutoMapperService;

class AutoMapperServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function register(): void
	{
		$this->app->singleton(AutoMapperService::class, AutoMapperPlusServiceImpl::class);
	}

	/**
	 * @return void
	 */
	public function boot(): void
	{
		// NADA
	}
}
