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

#[AsTwigComponent('gs_dt', template: '@GSGenericParts/components/gs_dt.html.twig')]
class GSDtComponent extends AbstractTwigComponent
{
    public $dt;
    public $tz = '';

    public function __construct(
        private $carFacImm,
        private $timezone,
    ) {
    }

    // ###> HELPER ###
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'tz'        => $this->timezone,
            ])
            ->setRequired('dt')
            ->setAllowedTypes('dt', [\DateTime::class, \DateTimeImmutable::class,           'null'])
            ->setAllowedTypes('tz', ['string',                                              'null'])
        ;
    }
}
