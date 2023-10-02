<?php

namespace VertexPortus\AutoMapper\Support\Facades;

use Illuminate\Support\Facades\Facade;

use VertexPortus\AutoMapper\Contracts\AutoMapperServiceContract;

/**
 * @method static registerMapping(string $source, string $dest): MappingInterface
 * @method static map(mixed $source, string $dest, array $context): mixed
 * @method static mapMultiple(array $source, string $dest, array $context): mixed
 */
class AutoMapper extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor(): string
	{
		return AutoMapperServiceContract::class;
	}
}
