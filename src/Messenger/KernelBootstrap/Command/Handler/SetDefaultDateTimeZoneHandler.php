<?php

namespace GS\GenericParts\Messenger\KernelBootstrap\Command\Handler;

use GS\GenericParts\Messenger\AbstractHandler;
use GS\GenericParts\Messenger\KernelBootstrap\Command\SetDefaultDateTimeZone;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SetDefaultDateTimeZoneHandler extends AbstractHandler
{
    public function __construct()
    {
    }

    public function __invoke(SetDefaultDateTimeZone $c)
    {
        \date_default_timezone_set($c->getTZ());
    }
}
