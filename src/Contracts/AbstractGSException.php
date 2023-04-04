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
		
		$this->message = $this->getConstructedMessage($message ?? static::MESSAGE);
	}
	
	public function getHttpCode(): int {
		return $this->httpCode;
	}
	
	###> HELPER ###
	
	private function getConstructedMessage(
		string $message,
	): string {
		$resultMessage				= $message;
		
		if (!empty($this->params)) {
			$params = [];
			\array_walk($this->params, static function($v, $k) use (&$params) { $params[] = $k.': '.$v; } );
			
			$resultMessage			= (
				(string) u($message)->ensureEnd(': ')
			) . '['.\implode(', ', $params).']';
		}
		
		return $resultMessage;
	}
}