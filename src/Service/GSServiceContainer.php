<?php

namespace GS\GenericParts\Service;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class GSServiceContainer
{
	public function __construct(
	) {
	}
	
	public static function setParametersNoForce(
		ContainerBuilder $containerBuilder,
		callable|\Closure $callbackGetValue,
		array $keys,
		?string $parameterPrefix = null,
	): void {
		$parameterPrefix		??= '';
		
		foreach($keys as $key) {
			if (!$containerBuilder->hasParameter($key)) {
				$containerBuilder->setParameter($parameterPrefix.$key, $callbackGetValue($key));
			}
		}
	}
	
	public static function setParametersForce(
		ContainerBuilder $containerBuilder,
		callable|\Closure $callbackGetValue,
		/**
			pass the keys in property accessor syntax
			if you need to get value from callback with $sourceArray
			to use property accessor:
				[root][child]
				
			in callbackGetValue:
				PropertyAccess::createPropertyAccessor()->getValue($sourceArray, $key);
		*/
		array $keys,
		?string $parameterPrefix = null,
	): void {
		$parameterPrefix		??= '';
		
		foreach($keys as $key) {
			$containerBuilder->setParameter($parameterPrefix.$key, $callbackGetValue($key));
		}
	}
	
	public static function removeDefinitions(
		ContainerBuilder $containerBuilder,
		array $ids,
	): void {
		foreach($ids as $id) {
			if ($containerBuilder->hasDefinition($id)) {
				$containerBuilder->removeDefinition($id);
			}				
		}
	}
}