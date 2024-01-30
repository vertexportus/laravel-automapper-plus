<?php

namespace VertexPortus\AutoMapper\Accessors;

use AutoMapperPlus\PropertyAccessor\PropertyAccessor as BasePropertyAccessor;

class EloquentPropertyAccessor extends BasePropertyAccessor
{
	/**
	 * @inheritdoc
	 */
	public function hasProperty($object, string $propertyName): bool
	{
		if (method_exists($object, 'getAttribute')) {
			/** @var \Illuminate\Database\Eloquent\Model $object
			 * @noinspection PhpFullyQualifiedNameUsageInspection
			 */
			return array_key_exists($propertyName, $object->getAttributes());
		}

		if (property_exists($object, $propertyName)) {
			return true;
		}

		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function getProperty($object, string $propertyName): mixed
	{
		$getter = 'get' . ucfirst($propertyName);

		if (method_exists($object, $getter)) {
			return call_user_func([$object, $getter]);
		}

		$isGetter = 'is' . ucfirst($propertyName);

		if (method_exists($object, $isGetter)) {
			return call_user_func([$object, $isGetter]);
		}

		if (method_exists($object, 'getAttributeValue')) {
			/** @var \Illuminate\Database\Eloquent\Model $object
			 * @noinspection PhpFullyQualifiedNameUsageInspection
			 */
			return $object->getAttributeValue($propertyName);
		}

		return parent::getProperty($object, $propertyName);
	}

	/**
	 * @inheritdoc
	 */
	public function setProperty($object, string $propertyName, $value): void
	{
		$setter = 'set' . ucfirst($propertyName);

		if (method_exists($object, $setter)) {
			call_user_func([$object, $setter], $value);
			return;
		}

		if (method_exists($object, 'getFillable') && in_array($propertyName, $object->getFillable())) {
			$object->{$propertyName} = $value;
			return;
		}

		parent::setProperty($object, $propertyName, $value);
	}

	/**
	 * @inheritdoc
	 */
	public function getPropertyNames($object): array
	{
		if (method_exists($object, 'getColumns')) {
			return $object->getColumns();
		}

		if (method_exists($object, 'getFillable')) {
			return $object->getFillable();
		}

		return parent::getPropertyNames($object);
	}
}
