<?php

namespace GS\GenericParts\Twig\Component;

use Symfony\Component\Filesystem\Path;
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

#[AsTwigComponent('gs_sprite', template: '@GSGenericParts/components/gs_sprite.html.twig')]
class GSSpriteComponent extends AbstractTwigComponent
{
    public string $id;

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired([
                'id',
            ])
        ;
    }
}
