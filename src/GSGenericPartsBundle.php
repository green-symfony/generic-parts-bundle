<?php

namespace GS\GenericParts;

use Symfony\Component\EventDispatcher\DependencyInjection\AddEventAliasesPass;
use GS\GenericParts\Pass\{
	AddEventAliasPass
};
use GS\GenericParts\GSGenericPartsExtension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class GSGenericPartsBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
		$container
			->addCompilerPass(new AddEventAliasPass([
			]))
		;
    }

	public function getContainerExtension(): ?ExtensionInterface
	{
		if ($this->extension === null) {
			$this->extension = new GSGenericPartsExtension;
		}
		
		return $this->extension;
	}
	
	/*
	public function loadExtension(
		array $config,
		ContainerConfigurator $containerConfigurator,
		ContainerBuilder $containerBuilder,
	): void {
		//\dd(\func_get_args());
		
		$containerConfigurator->import('../config/services.yaml');
		$containerConfigurator->import('../config/routes.yaml');
	}
	*/
}