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
class GSDtComponent extends AbstractController
{
    public const PUBLIC_DATA = [
        'dt' => '',
        'tz' => '',
    ];
    public $dt;
    public $tz = '';

    #[PreMount]
    public function preMount(array $data)
    {
        return $this->resolveData($data);
    }

    public function __construct(
        private $carFacImm,
    ) {
    }

    // >>> h >>>

    public function resolveData(array $data = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        return $resolver->resolve($data);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$setDefaults = ['tz'];
		
        $resolver
            ->setDefaults(
				\array_intersect_key(
					self::PUBLIC_DATA,
					\array_combine($setDefaults, $setDefaults),
				)
			)
            ->setRequired('dt')
            ->setAllowedTypes('dt', [\DateTime::class,			'null'])
            ->setAllowedTypes('tz', ['string',					'null'])
        ;
    }
}
