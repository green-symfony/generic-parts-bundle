<?php

namespace GS\GenericParts\Pass;

class GSSetAvailableEnvsForEmailErrorLogger extends AbstractGSDisableWhenEnv
{
	protected function doDisable(): void {
		$container->setAlias(
			MonologLoggerPass::EMAIL_ERROR_HANDLER_ID,
			'monolog.handler.null_internal',
		);
	}
}