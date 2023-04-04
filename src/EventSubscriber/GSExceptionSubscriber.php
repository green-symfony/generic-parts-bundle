<?php

namespace GS\GenericParts\EventSubscriber;

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
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception			= $event->getThrowable();
		
		if (!$exception instanceof AbstractGSException) return;
		
		$responseData		= [
			'error'		=> [
				'message'	=> $exception->getMessage(),
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
}
