<?php

namespace GS\GenericParts\EventSubscriber;

use GS\GenericParts\Service\{
	GSArrayService
};
use function Symfony\Component\String\u;
use Symfony\Component\HttpFoundation\{
	Response,
	JsonResponse
};
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use GS\GenericParts\Contracts\AbstractGSException;
use Symfony\Component\HttpKernel\KernelEvents;

class GSExceptionSubscriber implements EventSubscriberInterface
{	
    public function __construct(
		private $t,
	) {
	}
	
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception			= $event->getThrowable();
		
		if (!$exception instanceof AbstractGSException) return;
		
		$responseData		= [
			'error'		=> [
				'message'	=> $this->getMessageWithParams($exception),
				'http_code' => $httpCode = $exception->getHttpCode(),
				'file'		=> $exception->getFile(),
				'line'		=> $exception->getLine(),
				'code'		=> $code = $exception->getCode(),
			],
		];
		$response			= new JsonResponse(
			$responseData,
			$httpCode,
		);
		$response->setEncodingOptions(\JSON_UNESCAPED_UNICODE);
		
		$event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
	
	//###> HELPER ###
	
	private function getMessageWithParams(AbstractGSException $exception): string {
		$resultMessage			= $this->t->trans($exception->getMessage(), domain: 'gs_generic_parts');
		
		if (!empty($exceptionParams = $exception->getParams())) {
			$resultMessage			= (
				(string) u($resultMessage)->ensureEnd(': ')
			) . '['.GSArrayService::getKeyValueString($exceptionParams).']';
		}
		
		return $resultMessage;
	}
}
