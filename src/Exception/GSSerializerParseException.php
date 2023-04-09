<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;
use Symfony\Component\HttpFoundation\{
    Response
};

class GSSerializerParseException extends AbstractGSException
{
    public const MESSAGE = 'exception.serializer_parse';
}
