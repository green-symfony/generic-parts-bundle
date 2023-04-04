<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;

class GSSerializerParseException extends AbstractGSException
{
	public const MESSAGE = 'exception.serializer_parse';
}