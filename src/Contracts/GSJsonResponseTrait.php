<?php

namespace GS\GenericParts\Contracts;

use Symfony\Component\HttpFoundation\{
	Response
};
use function Symfony\Component\String\u;

trait GSJsonResponseTrait
{
	protected int $httpCode;
	public function __construct(
		?string $message				= null,
		?int $httpCode					= null,
		protected array $params			= [],
	) {
		$this->message			= $message		?? static::MESSAGE;
		$this->httpCode			= $httpCode		?? static::HTTP_CODE;
	}
	
	public function getMessage(): string {
		return $this->message;
	}
	
	public function getHttpCode(): int {
		return $this->httpCode;
	}
	
	public function getParams(): array {
		return $this->params;
	}
}