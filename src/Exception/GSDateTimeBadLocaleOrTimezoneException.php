<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;

class GSDateTimeBadLocaleOrTimezoneException extends AbstractGSException
{
	public const MESSAGE = 'Bad locale or timezone for DateTime';
}