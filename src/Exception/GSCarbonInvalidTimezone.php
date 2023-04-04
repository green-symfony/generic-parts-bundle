<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;

class GSCarbonInvalidTimezone extends AbstractGSException
{
	public const MESSAGE = 'exception.carbon_invalid_timezone';
}