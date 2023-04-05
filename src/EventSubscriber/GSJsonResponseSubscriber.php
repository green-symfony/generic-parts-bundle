<?php

namespace GS\GenericParts\EventSubscriber;

use GS\GenericParts\Contracts\{
	AbstractGSJsonResponse
};
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;
use Symfony\Component\HttpFoundation\HeaderUtils;
use GS\GenericParts\Contracts\{
	AbstractGSJsonAnswer,
	AbstractGSException
};
use GS\GenericParts\Service\{
	GSArrayService
};
use function Symfony\Component\String\u;
use Symfony\Component\HttpFoundation\{
	Response,
	JsonResponse
};
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\{
	ViewEvent,
	ExceptionEvent
};
use Symfony\Component\HttpKernel\KernelEvents;

class GSJsonResponseSubscriber implements EventSubscriberInterface
{	
    public function __construct(
		private $t,
	) {
	}
	
    public function onKernelView(ViewEvent $event): void 
	{
		$controllerResult			= $event->getControllerResult();
		
		if (!$controllerResult instanceof AbstractGSJsonResponse) return;
		
		$responseData		= [
			'message'	=> $this->getMessageWithParams($controllerResult),
			'http_code' => $httpCode = $controllerResult->getHttpCode(),
		];
		
		$event->setResponse($this->getJsonResponse($responseData, $httpCode));
		
		$this->end($event);
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
		
		$event->setResponse($this->getJsonResponse($responseData, $httpCode));
		
		$this->end($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION		=> 'onKernelException',
            KernelEvents::VIEW			=> 'onKernelView',
        ];
    }
	
	//###> HELPER ###
	
	private function getJsonResponse(array|string|int $data, int $httpCode): JsonResponse {
		$response			= new JsonResponse(
			$data,
			$httpCode,
		);
		$response->setEncodingOptions(\JSON_UNESCAPED_UNICODE);
		return $response;
	}
	
	private function getMessageWithParams(object $response): string {
		$resultMessage			= $this->t->trans($response->getMessage(), domain: 'gs_generic_parts');
		
		if (!empty($responseParams = $response->getParams())) {
			$resultMessage			= (
				(string) u($resultMessage)->ensureEnd(': ')
			) . '['.GSArrayService::getKeyValueString($responseParams).']';
		}
		
		return $resultMessage;
	}
	
	private function end(Event $event): void {
		$event->stopPropagation();
	}
}
