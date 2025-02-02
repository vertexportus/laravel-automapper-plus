<?php
/** @noinspection PhpRedundantMethodOverrideInspection */

namespace VertexPortus\AutoMapper\Configuration;

use AutoMapperPlus\Configuration\Mapping;
use VertexPortus\AutoMapper\Enums\NamingConvention;
use AutoMapperPlus\NameResolver\NameResolverInterface;
use VertexPortus\AutoMapper\Contracts\LaravelMappingInterface;
use AutoMapperPlus\MappingOperation\MappingOperationInterface;
use VertexPortus\AutoMapper\Contracts\LaravelMapperConfigInterface;
use AutoMapperPlus\NameConverter\NamingConvention\NamingConventionInterface;
use AutoMapperPlus\NameConverter\NamingConvention\CamelCaseNamingConvention;
use AutoMapperPlus\NameConverter\NamingConvention\SnakeCaseNamingConvention;
use AutoMapperPlus\NameConverter\NamingConvention\PascalCaseNamingConvention;
use AutoMapperPlus\Configuration\MappingInterface as AutoMapperPlusMappingInterface;

class LaravelMapping extends Mapping implements LaravelMappingInterface
{
    public function __construct(
        string $sourceClassName,
        string $destinationClassName,
        LaravelMapperConfigInterface $autoMapperConfig
    ) {
        parent::__construct($sourceClassName, $destinationClassName, $autoMapperConfig);
    }

    public function forMember(string $targetPropertyName, $operation): LaravelMappingInterface
    {
        return parent::forMember($targetPropertyName, $operation);
    }
    public function copyFrom(string $sourceClass, string $destinationClass): LaravelMappingInterface
    {
        return parent::copyFrom($sourceClass, $destinationClass);
    }
    public function skipConstructor(): LaravelMappingInterface
    {
        return parent::skipConstructor();
    }
    public function dontSkipConstructor(): LaravelMappingInterface
    {
        return parent::dontSkipConstructor();
    }
    public function withDefaultOperation(MappingOperationInterface $mappingOperation): LaravelMappingInterface
    {
        return parent::withDefaultOperation($mappingOperation);
    }
    public function withNameResolver(NameResolverInterface $nameResolver): LaravelMappingInterface
    {
        return parent::withNameResolver($nameResolver);
    }
    public function reverseMap(array $options = []): LaravelMappingInterface
    {
        return parent::reverseMap($options);
    }
    public function beConstructedUsing(callable $factoryCallback): LaravelMappingInterface
    {
        return parent::beConstructedUsing($factoryCallback);
    }
    public function withNamingConventions(
        NamingConventionInterface|NamingConvention $sourceNamingConvention,
        NamingConventionInterface|NamingConvention $destinationNamingConvention
    ): LaravelMappingInterface {
        return parent::withNamingConventions(
            $sourceNamingConvention instanceof NamingConvention
                ? $this->getNamingConvention($sourceNamingConvention)
                : $sourceNamingConvention,
            $destinationNamingConvention instanceof NamingConvention
                ? $this->getNamingConvention($destinationNamingConvention)
                : $destinationNamingConvention
        );
    }

    public function copyFromMapping(AutoMapperPlusMappingInterface $mapping): LaravelMappingInterface
    {
        return parent::copyFromMapping($mapping);
    }

    private function getNamingConvention(NamingConvention $convention): NamingConventionInterface
    {
        switch ($convention) {
            case NamingConvention::PascalCase: return new PascalCaseNamingConvention();
            case NamingConvention::CamelCase: return new CamelCaseNamingConvention();
            case NamingConvention::SnakeCase: return new SnakeCaseNamingConvention();
        }
    }
}
