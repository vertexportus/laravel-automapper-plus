<?php

namespace VertexPortus\AutoMapper\Contracts;

use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;

interface AutoMapperService extends AutoMapperInterface
{
    /**
     * Registers a mapping from $source class to $dest class
     *
     * @param string $source
     * @param string $destinationClass
     * @return LaravelMappingInterface
     */
	public function registerMapping(string $source, string $destinationClass): LaravelMappingInterface;

    /**
     * @param string $sourceClass
     * @param string $destinationClass
     * @return LaravelMappingInterface
     * @throws UnregisteredMappingException
     */
	public function getMappingFor(string $sourceClass, string $destinationClass): LaravelMappingInterface;
}
