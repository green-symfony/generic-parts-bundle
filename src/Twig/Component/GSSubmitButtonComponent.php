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

#[AsTwigComponent('gs_submit_button', template: '@GSGenericParts/components/gs_submit_button.html.twig')]
class GSSubmitButtonComponent extends AbstractController
{
    public string $class		= 'btn btn-outline-secondary';
    public array $attr			= [];
    public string $text;
	
	#[PreMount]
	public function preMount(array $data) {
		return $this->getResolvedData($data);
	}
	
	//###> HELPERS ###
	
	private function getResolvedData(array $data): array {
		$resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        return $resolver->resolve($data);
	}
	
	private function configureOptions($resolver) {
		$resolver
			->setRequired('text')
		;
	}
}
