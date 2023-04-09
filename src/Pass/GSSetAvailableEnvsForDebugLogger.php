<?php

namespace GS\GenericParts\Pass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class GSSetAvailableEnvsForDebugLogger extends AbstractGSSetAvailableEnvs
{
    protected function doDisable(ContainerBuilder $container): void
    {
        $container->setAlias(
            'monolog.handler.gs_generic_parts.debug',
            'monolog.handler.null_internal',
        );
    }
}
