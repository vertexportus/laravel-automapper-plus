<?php

use Illuminate\Support\Collection;
use VertexPortus\AutoMapper\Support\Facades\AutoMapper;
use VertexPortus\AutoMapper\Contracts\LaravelMappingInterface;

if (!function_exists('auto_map')) {
	/**
	 * Maps from source to targetClass
	 *
	 * @param mixed $source
	 * @param string $dest
	 * @param array $context
	 * @return mixed
	 */
	function auto_map(mixed $source, string $dest, array $context = []): mixed {
		return AutoMapper::map($source, $dest, $context);
	}
}

if (!function_exists('auto_map_multiple')) {
	/**
	 *  Maps from array of sources to targetClass
	 *
	 * @param array|Collection $source
	 * @param string $dest
	 * @param array $context
	 * @return mixed
	 */
	function auto_map_multiple(array|Collection $source, string $dest, array $context = []): mixed
	{
		return AutoMapper::mapMultiple($source, $dest, $context);
	}
}


if (!function_exists('auto_map_register')) {
    /**
     * Registers a mapping from $source class to $dest class
     *
     * @param string $source
     * @param string $dest
     * @return LaravelMappingInterface
     */
	function auto_map_register(string $source, string $dest): LaravelMappingInterface {
		return AutoMapper::registerMapping($source, $dest);
	}
}
