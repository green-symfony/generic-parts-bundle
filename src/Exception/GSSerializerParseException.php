<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;

class GSSerializerParseException extends AbstractGSException
{
	public const MESSAGE = 'Serializer couldn\'t parse the request content because it\'s incorrect or empty';
}