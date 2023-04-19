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

#[AsTwigComponent('gs_flash_bag', template: '@GSGenericParts/components/gs_flash_bag.html.twig')]
class GSFlashBag extends AbstractTwigComponent
{
    protected function configureOptions(OptionsResolver $resolver): void {}
}
