<?php

namespace GS\GenericParts;

use GS\GenericParts\Configuration;
use GS\GenericParts\Contracts\GSTag;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\{
	YamlFileLoader
};
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class GSGenericPartsExtension extends ConfigurableExtension implements PrependExtensionInterface
{
	/**
		-	load packages .yaml
	*/
	public function prepend(ContainerBuilder $container)
	{
		foreach([
			['config/packages',		'twig.yaml'],
			['config/packages',		'messenger.yaml'],
			['config/packages',		'framework.yaml'],
			['config/packages',		'translation.yaml'],
		] as [$relPath, $filename]) {
			$this->loadYaml($container, $relPath, $filename);			
		}
	}
	
	/**
		-	load services.yaml
		-	config->services
		-	bundle's tags
	*/
	public function loadInternal(array $config, ContainerBuilder $container)
	{
		$this->loadYaml($container, 'config', 'services.yaml');
		$this->fillInServiceArgumentsWithConfigOfCurrentBundle($config, $container);
		$this->registerBundleTagsForAutoconfiguration($container);
		/*
		\dd(
			$container->getParameter('gs_generic_parts.timezone'),
		);
		*/
	}
	
	public function getConfiguration(array $config, ContainerBuilder $container)
    {
		return new Configuration();
	}
	
	//###> HELPERS ###
	
	private function fillInServiceArgumentsWithConfigOfCurrentBundle(
		array $config,
		ContainerBuilder $container,
	) {
	}
	
	private function registerBundleTagsForAutoconfiguration(ContainerBuilder $container) {
		/*
		$container
			->registerForAutoconfiguration(\GS\GenericParts\<>Interface::class)
			->addTag(GSTag::<>)
		;
		*/
	}
	
	private function loadYaml(
		ContainerBuilder $container,
		string $relPath,
		string $filename,
	): void {
		$loader = new YamlFileLoader(
			$container,
			new FileLocator(
				[
					__DIR__.'/../'.$relPath,
				],
			),
		);
		$loader->load($filename);
	}
}