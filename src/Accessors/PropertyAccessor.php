<?php

namespace VertexPortus\AutoMapper\Accessors;

use AutoMapperPlus\PropertyAccessor\PropertyAccessor as BasePropertyAccessor;

class PropertyAccessor extends BasePropertyAccessor
{
	/**
	 * @inheritdoc
	 */
	public function getProperty($object, string $propertyName)
	{
		$getter = 'get' . ucfirst($propertyName);

		if (method_exists($object, $getter)) {
			return call_user_func([$object, $getter]);
		}

		$isGetter = 'is' . ucfirst($propertyName);

		if (method_exists($object, $isGetter)) {
			return call_user_func([$object, $isGetter]);
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

		parent::setProperty($object, $propertyName, $value);
	}

}
