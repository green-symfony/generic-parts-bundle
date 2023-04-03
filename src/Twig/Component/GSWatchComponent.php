<?php

namespace GS\GenericParts\Twig\Component;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function Symfony\Component\String\u;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Validator\{
    Constraints,
    Validation
};
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{
    ExposeInTemplate,
    PreMount,
    PostMount,
    AsTwigComponent
};
use Symfony\UX\LiveComponent\{
    Attribute\AsLiveComponent,
    Attribute\LiveProp,
    Attribute\LiveArg,
    Attribute\LiveAction,
    DefaultActionTrait
};

#[AsTwigComponent('gs_watch', template: '@GSGenericParts/components/gs_watch.html.twig')]
class GSWatchComponent extends AbstractController
{
    public $intervalMs			= 1000;
}
