<?php

namespace GS\GenericParts\Contracts;

use Symfony\Component\HttpFoundation\{
	Response
};
use function Symfony\Component\String\u;

abstract class AbstractGSJsonResponse implements GSJsonResponseInterface
{
	use GSJsonResponseTrait;
	
	protected string $message;
	
	###> HELPER ###
}