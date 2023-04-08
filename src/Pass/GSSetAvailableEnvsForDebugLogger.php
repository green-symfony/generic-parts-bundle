<?php

namespace GS\GenericParts\Pass;

class GSSetAvailableEnvsForDebugLogger extends AbstractGSSetAvailableEnvs
{
	protected function doDisable(): void {
		$container->setAlias(
			'monolog.handler.gs_generic_parts.debugger',
			'monolog.handler.null_internal',
		);
	}
}