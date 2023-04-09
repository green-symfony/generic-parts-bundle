<?php

namespace GS\GenericParts\Pass;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use GS\GenericParts\Contracts\GSTag;

abstract class AbstractGSSetAvailableEnvs implements CompilerPassInterface
{
    public function __construct(
        protected readonly string $appEnv,
        protected readonly array $availableEnvs,
    ) {
    }

    public function process(ContainerBuilder $container)
    {
        $disableErrorLogger         = !\in_array($this->appEnv, $this->availableEnvs);
        if ($disableErrorLogger) {
            $this->doDisable($container);
        }
    }

    ###> ABSTRACT ###
    abstract protected function doDisable(ContainerBuilder $container): void;
    ###< ABSTRACT ###
}
