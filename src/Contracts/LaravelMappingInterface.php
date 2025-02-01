<?php

namespace VertexPortus\AutoMapper\Contracts;

use AutoMapperPlus\NameResolver\NameResolverInterface;
use AutoMapperPlus\MappingOperation\MappingOperationInterface;
use AutoMapperPlus\NameConverter\NamingConvention\NamingConventionInterface;
use AutoMapperPlus\Configuration\MappingInterface as AutoMapperPlusMappingInterface;

interface LaravelMappingInterface extends AutoMapperPlusMappingInterface
{
    public function getSourceClassName(): string;
    public function getDestinationClassName(): string;

    public function forMember(string $targetPropertyName, $operation): LaravelMappingInterface;
    public function reverseMap(): LaravelMappingInterface;
    public function copyFrom(string $sourceClass, string $destinationClass): LaravelMappingInterface;
    public function copyFromMapping(AutoMapperPlusMappingInterface $mapping): LaravelMappingInterface;
    public function beConstructedUsing(callable $factoryCallback): LaravelMappingInterface;
    public function skipConstructor(): LaravelMappingInterface;
    public function dontSkipConstructor(): LaravelMappingInterface;
    public function withNamingConventions(
        NamingConventionInterface $sourceNamingConvention,
        NamingConventionInterface $destinationNamingConvention
    ): LaravelMappingInterface;
    public function withDefaultOperation(MappingOperationInterface $mappingOperation): LaravelMappingInterface;
    public function withNameResolver(NameResolverInterface $nameResolver): LaravelMappingInterface;
}
