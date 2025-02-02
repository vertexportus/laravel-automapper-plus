<?php

namespace VertexPortus\AutoMapper\Configuration;

use Exception;
use AutoMapperPlus\Configuration\Options;
use VertexPortus\AutoMapper\Contracts\LaravelMappingInterface;
use VertexPortus\AutoMapper\Contracts\LaravelMapperConfigInterface;

class LaravelMapperConfig implements LaravelMapperConfigInterface
{
    /**
     * @var LaravelMappingInterface[]
     */
    private array $mappings = [];

    /**
     * @var Options
     */
    private Options $options;

    /**
     * AutoMapperConfig constructor.
     *
     * @param callable|null $configurator
     */
    public function __construct(callable $configurator = null)
    {
        $this->options = Options::default();
        if ($configurator !== null) {
            $configurator($this->options);
        }
    }

    /**
     * @inheritdoc
     */
    public function hasMappingFor(
        string $sourceClassName,
        string $destinationClassName
    ): bool {
        $mapping = $this->getMappingFor(
            $sourceClassName,
            $destinationClassName
        );

        return $mapping !== null;
    }

    /**
     * @inheritdoc
     */
    public function getMappingFor(
        string $sourceClassName,
        string $destinationClassName
    ): ?LaravelMappingInterface {
        // Check for an exact match before we try parent classes.
        $mapping = $this->mappings["$sourceClassName|$destinationClassName"] ?? NULL;
        if ($mapping) {
            return $mapping;
        }

        if (!$this->options->shouldUseSubstitution()) {
            if (!$this->options->shouldCreateUnregisteredMappings()) {
                return null;
            }

            // We don't use substitution (BC), but we allow creation of mappings
            // on the fly.
            return $this->registerMapping(
                $sourceClassName,
                $destinationClassName
            );
        }

        // We didn't find an exact match, and substitution is allowed. We'll
        // build a list of potential candidates and retrieve the most specific
        // mapping from it.
        $candidates = array_filter(
            $this->mappings,
            function (LaravelMappingInterface $mapping) use ($sourceClassName, $destinationClassName): bool {
                return $this->isOrExtends($sourceClassName, $mapping->getSourceClassName())
                    && $this->isOrExtends($destinationClassName, $mapping->getDestinationClassName());
            }
        );

        $mapping = $this->getMostSpecificCandidate(
            $candidates,
            $sourceClassName,
            $destinationClassName
        );
        if ($mapping !== null) {
            return $mapping;
        }

        if (!$this->options->shouldCreateUnregisteredMappings()) {
            return null;
        }

        return $this->registerMapping(
            $sourceClassName,
            $destinationClassName
        );
    }

    /**
     * Searches the most specific candidate in the list. This means the mapping
     * that is closest to the given source and destination in the inheritance
     * chain.
     *
     * @param array $candidates
     * @param string $sourceClassName
     * @param string $destinationClassName
     * @return LaravelMappingInterface|null
     * @throws Exception
     */
    protected function getMostSpecificCandidate(
        array $candidates,
        string $sourceClassName,
        string $destinationClassName
    ): ?LaravelMappingInterface {
        $lowestDistance = PHP_INT_MAX;
        $selectedCandidate = null;
        /** @var LaravelMappingInterface $candidate */
        foreach($candidates as $candidate) {
            $sourceDistance = $this->getClassDistance(
                $sourceClassName,
                $candidate->getSourceClassName()
            );
            $destinationDistance = $this->getClassDistance(
                $destinationClassName,
                $candidate->getDestinationClassName()
            );
            $distance = $sourceDistance + $destinationDistance;

            if ($distance < $lowestDistance) {
                $lowestDistance = $distance;
                $selectedCandidate = $candidate;
            }
        }

        return $selectedCandidate;
    }

    /**
     * Returns the distance in the inheritance chain between 2 classes.
     *
     * @param string $childClass
     * @param string $parentClass
     * @return int
     * @throws Exception
     */
    protected function getClassDistance(
        string $childClass,
        string $parentClass
    ): int {
        if ($childClass === $parentClass) {
            return 0;
        }

        $result = 0;
        $childParents = class_parents($childClass, true);
        foreach($childParents as $childParent) {
            $result++;
            if ($childParent === $parentClass) {
                return $result;
            }
        }

        // We'll treat implementing an interface as having a greater class
        // distance. This because we want a concrete implementation to be more
        // specific than an interface. For example, suppose we have:
        // - FooInterface
        // - FooClass, implementing the above interface
        // If a mapping has been registered for both of these, we want the
        // mapper to pick the mapping registered for FooClass, since this is
        // more specific.
        $interfaces = class_implements($childClass);
        if (\in_array($parentClass, $interfaces, true)) {
            return ++$result;
        }

        // @todo: use a domain specific exception.
        throw new Exception(
            'This error should have never be thrown.
            This could only happen if given childClass is not a child of the given parentClass'
        );
    }

    /**
     * @inheritdoc
     */
    public function registerMapping(
        string $sourceClassName,
        string $destinationClassName
    ): LaravelMappingInterface {
        $mapping = new LaravelMapping(
            $sourceClassName,
            $destinationClassName,
            $this
        );
        $this->mappings["$sourceClassName|$destinationClassName"] = $mapping;

        return $mapping;
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    private function isOrExtends(string $classA, string $classB): bool
    {
        return $classA === $classB || is_a($classA, $classB, true);
    }
}
