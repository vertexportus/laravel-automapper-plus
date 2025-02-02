<?php

namespace VertexPortus\AutoMapper\Contracts;

use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

interface LaravelMapperConfigInterface extends AutoMapperConfigInterface
{
   public function registerMapping(string $sourceClassName, string $destinationClassName): LaravelMappingInterface;
   public function getMappingFor(string $sourceClassName, string $destinationClassName): ?LaravelMappingInterface;

}
