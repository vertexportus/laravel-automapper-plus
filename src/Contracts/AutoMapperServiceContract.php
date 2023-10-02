<?php

namespace VertexPortus\AutoMapper\Contracts;

use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\MappingInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;

interface AutoMapperServiceContract extends AutoMapperInterface
{
	/**
	 * Registers a mapping from $source class to $dest class
	 *
	 * @param string $source
	 * @param string $destinationClass
	 * @return MappingInterface
	 */
	public function registerMapping(string $source, string $destinationClass): MappingInterface;

	/**
	 * @param string $sourceClass
	 * @param string $destinationClass
	 * @throws UnregisteredMappingException
	 * @return MappingInterface
	 */
	public function getMappingFor(string $sourceClass, string $destinationClass): MappingInterface;
}
