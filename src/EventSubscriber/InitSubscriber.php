<?php

namespace GS\GenericParts\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use GS\GenericParts\Messenger\KernelBootstrap\Command\{
    InitCarbon,
    SetDefaultDateTimeZone
};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\{
    Response,
    JsonResponse,
    Request
};
use Symfony\Component\HttpKernel\Event\{
    TerminateEvent,
    FinishRequestEvent,
    ControllerArgumentsEvent,
    ResponseEvent,
    ExceptionEvent,
    ViewEvent,
    RequestEvent,
    ControllerEvent
};
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class InitSubscriber implements EventSubscriberInterface
{
	public function __construct(
		private MessageBusInterface $bus,
		private $defaultTimeZone,
	) {
	}
	
	//###> EVENTS ###
	public function onKernelRequest(RequestEvent $e)
    {
        $this->handleRequest($e);
    }
	//###< EVENTS ###


	//###> HELPERS ###
    private function handleRequest($e)
    {
        foreach (
            [
				new SetDefaultDateTimeZone($this->defaultTimeZone),
				new InitCarbon(),
            ] as $message
        ) {
            $this->bus->dispatch($message);
        }
    }
	//###< HELPERS ###

	/** implements EventSubscriberInterface */
	public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 256],
        ];
    }
}
