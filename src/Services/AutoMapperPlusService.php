<?php

namespace VertexPortus\AutoMapper\Services;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\MappingInterface;

use AutoMapperPlus\Configuration\AutoMapperConfig;
use VertexPortus\AutoMapper\Accessors\EloquentPropertyAccessor;
use VertexPortus\AutoMapper\Contracts\AutoMapperServiceContract;

class AutoMapperPlusService extends AutoMapper implements AutoMapperServiceContract
{
	/**
	 */
	public function __construct()
	{
		$config = new AutoMapperConfig();
		$config->getOptions()->setPropertyAccessor(new EloquentPropertyAccessor());
		parent::__construct($config);
	}

	/**
	 * @inheritDoc
	 */
	public function registerMapping(string $source, string $destinationClass): MappingInterface
	{
		return $this->getConfiguration()->registerMapping($source, $destinationClass);
	}

	/**
	 * @inheritDoc
	 */
	public function getMappingFor(string $sourceClass, string $destinationClass): MappingInterface
	{
		return $this
			->getMapping($sourceClass, $destinationClass);
	}
}
