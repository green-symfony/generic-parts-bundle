<?php

namespace GS\GenericParts\Contracts;

use Symfony\Component\HttpFoundation\{
	Response
};
use function Symfony\Component\String\u;

abstract class AbstractGSException extends \Exception
{
	###> CAN OVERRIDE IT ###
	public const MESSAGE		= self::class;
	public const HTTP_CODE		= Response::HTTP_INTERNAL_SERVER_ERROR;
	###< CAN OVERRIDE IT ###
	
	protected int $httpCode;
	public function __construct(
		?string $message				= null,
		?int $httpCode					= null,
		protected array $params			= [],
	) {
		$this->httpCode			= $httpCode		?? static::HTTP_CODE;
		$this->message			= $message		?? static::MESSAGE;
	}
	
	public function getHttpCode(): int {
		return $this->httpCode;
	}
	
	public function getParams(): array {
		return $this->params;
	}
	
	###> HELPER ###
}