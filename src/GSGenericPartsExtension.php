<?php

namespace GS\GenericParts;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\DependencyInjection\Definition;
use GS\GenericParts\Service\{
    GSServiceContainer,
    GSStringNormalizer
};
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
    public const PREFIX = 'gs_generic_parts.';

    /**
        -   load packages .yaml
    */
    public function prepend(ContainerBuilder $container)
    {
        $this->loadYaml($container, [
            ['config/packages',     'messenger.yaml'],
            ['config/packages',     'framework.yaml'],
            ['config/packages',     'translation.yaml'],
            ['config',              'services.yaml'],
            // needs services.yaml
            ['config/packages',     'monolog.yaml'],
            ['config/packages',     'twig.yaml'],
        ]);
    }

    public function getConfiguration(
        array $config,
        ContainerBuilder $container,
    ) {
        return new Configuration(
            locale:                     $container->getParameter('gs_generic_parts.locale'),
            timezone:                   $container->getParameter('gs_generic_parts.timezone'),
        );
    }

    /**
        -   load services.yaml
        -   config->services
        -   bundle's tags
    */
    public function loadInternal(array $config, ContainerBuilder $container)
    {
        $this->loadYaml($container, [
            //['config',                    'services.yaml'],
        ]);
        $this->fillInParameters($config, $container);
        $this->fillInServiceArgumentsWithConfigOfCurrentBundle($config, $container);
        $this->registerBundleTagsForAutoconfiguration($container);
        /*
        \dd(
            $container->getParameter('gs_generic_parts.timezone'),
        );
        */
    }

    //###> HELPERS ###

    private function fillInParameters(
        array $config,
        ContainerBuilder $container,
    ) {
        /*
        \dd(
            $container->hasParameter('error_prod_logger_email'),
            PropertyAccess::createPropertyAccessor()->getValue($config, '[error_prod_logger_email][from]'),
        );
        */

        GSServiceContainer::setParametersForce(
            $container,
            callbackGetValue:       static function ($key) use (&$config) {
                return PropertyAccess::createPropertyAccessor()->getValue($config, $key);
            },
            parameterPrefix:        self::PREFIX,
            keys:                   [
                '[error_logger_email][from]',
                '[error_logger_email][to]',
            ],
        );
    }

    private function fillInServiceArgumentsWithConfigOfCurrentBundle(
        array $config,
        ContainerBuilder $container,
    ) {
        $this->carbonService($config, $container);
        $this->fakerService($config, $container);
    }

    private function carbonService(array $config, ContainerBuilder $container)
    {
        $carbon         = new Definition(
            class:          \Carbon\FactoryImmutable::class,
            arguments:      [
                '$settings'         => [
                    'locale'                    => $config['locale'],
                    'strictMode'                => true,
                    'timezone'                  => $config['timezone'],
                    'toStringFormat'            => 'd.m.Y H:i:s P',
                    'monthOverflow'             => true,
                    'yearOverflow'              => true,
                ],
            ],
        );
        $container->setDefinition(
            id:             'gs_generic_parts.carbon_factory',
            definition:     $carbon,
        );
    }

    private function fakerService(array $config, ContainerBuilder $container)
    {
        $faker          = (new Definition(\Faker\Factory::class, []))
            ->setFactory([\Faker\Factory::class, 'create'])
            ->setArgument(0, GSStringNormalizer::getFullLocale($config['locale']))
        ;
        //\dd($config['locale']);
        $faker          = $container->setDefinition(
            id:             'gs_generic_parts.faker',
            definition:     $faker,
        );
    }

    private function registerBundleTagsForAutoconfiguration(ContainerBuilder $container)
    {
        /*
        $container
            ->registerForAutoconfiguration(\GS\GenericParts\<>Interface::class)
            ->addTag(GSTag::<>)
        ;
        */
    }

    /**
        @var    $relPath is a relPath or array with the following structure:
            [
                ['relPath', 'filename'],
                ...
            ]
    */
    private function loadYaml(
        ContainerBuilder $container,
        string|array $relPath,
        ?string $filename = null,
    ): void {

        if (\is_array($relPath)) {
            foreach ($relPath as [$path, $filename]) {
                $this->loadYaml($container, $path, $filename);
            }
            return;
        }

        if (\is_string($relPath) && $filename === null) {
            throw new \Exception('Incorrect method arguments');
        }

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(
                [
                    __DIR__ . '/../' . $relPath,
                ],
            ),
        );
        $loader->load($filename);
    }
}
