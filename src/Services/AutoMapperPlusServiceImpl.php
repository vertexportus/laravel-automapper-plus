<?php

namespace VertexPortus\AutoMapper\Services;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\MappingInterface;
use VertexPortus\AutoMapper\Configuration\LaravelMapperConfig;
use VertexPortus\AutoMapper\Accessors\EloquentPropertyAccessor;
use VertexPortus\AutoMapper\Contracts\AutoMapperService;
use VertexPortus\AutoMapper\Contracts\LaravelMappingInterface;
use VertexPortus\AutoMapper\Contracts\LaravelMapperConfigInterface;

class AutoMapperPlusServiceImpl extends AutoMapper implements AutoMapperService
{
	/**
	 */
	public function __construct()
	{
		$config = new LaravelMapperConfig();
		$config->getOptions()->setPropertyAccessor(new EloquentPropertyAccessor());
		parent::__construct($config);
	}

	/**
	 * @inheritDoc
	 */
	public function registerMapping(string $source, string $destinationClass): LaravelMappingInterface
    {
		return $this->getConfiguration()->registerMapping($source, $destinationClass);
	}

	/**
	 * @inheritDoc
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
	public function getMappingFor(string $sourceClass, string $destinationClass): LaravelMappingInterface
	{
		return $this->getMapping($sourceClass, $destinationClass);
	}

    /**
     * @inheritDoc
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function getConfiguration(): LaravelMapperConfigInterface
    {
        return parent::getConfiguration();
    }
}
