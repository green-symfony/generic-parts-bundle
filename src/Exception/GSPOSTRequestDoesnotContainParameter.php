<?php

namespace GS\GenericParts\Exception;

use Symfony\Component\HttpFoundation\{
	Response
};
use GS\GenericParts\Contracts\AbstractGSException;

class GSPOSTRequestDoesnotContainParameter extends AbstractGSException
{
	public const MESSAGE		= 'POST request doesn\'t contain parameters';
	public const HTTP_CODE		= Response::HTTP_BAD_REQUEST;
}