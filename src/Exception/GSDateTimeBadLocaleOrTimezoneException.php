<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;

class GSDateTimeBadLocaleOrTimezoneException extends AbstractGSException
{
	public const MESSAGE = 'exception.bad_locale_or_timezone';
	
	public function __construct(
		?string $message		= null,
		?int $httpCode			= null,
		array $params			= [],
	) {
		parent::__construct(
			message:		$message,
			httpCode:		$httpCode,
			params:			$params,
		);
	}
}
