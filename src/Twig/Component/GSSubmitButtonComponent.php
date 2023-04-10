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
class GSSubmitButtonComponent extends AbstractTwigComponent
{
    public string $class        = 'btn btn-outline-primary';
    public array $attr          = [
		'data-turbo'	=> false,
	];
    public string $text;

	public function mount(
		array $attr = [],
	) {
		$this->setAttr($attr);
	}

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired([
                'text',
            ])
			->setDefined([
				'class',
				'attr',
			])
        ;
	}
 
	// ###> HELPER ###
	
	private function setAttr(array $innerAttr) {
		$this->attr			= \array_replace_recursive($innerAttr, $this->attr);
	}

}
