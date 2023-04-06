<?php

namespace GS\GenericParts\Twig\Extension;

use GS\GenericParts\Service\{
	GSCarbonService,
	GSBufferService,
	GSHtmlService
};
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\{
    Response,
    JsonResponse,
    Request
};
use Twig\Extension\AbstractExtension;

class DefaultExtension extends AbstractExtension
{
    public function __construct(
        private $faker,
        private $carFacImm,
        private FormFactoryInterface $formFactory,
    ) {
    }
    
	//###> FILTERS ###

    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('gs_trim',						$this->trim(...)),
            new \Twig\TwigFilter('gs_for_user',					$this->forUser(...)),
			/* Usage: attrVariable|<filter>|raw */
            new \Twig\TwigFilter('gs_array_to_attribute',		$this->arrayToAttribute(...)),
            new \Twig\TwigFilter('gs_binary_img',				$this->binary_img(...)),
        ];
    }
	
	public function binary_img(string $input) {
		return GSHtmlService::getImgHtmlByBinary($input);
	}
	
	public function trim(mixed $input, ?string $string = null) {
		return ($string !== null) ? \trim($input, $string) : \trim($input);
	}

	public function arrayToAttribute(
        array $input,
    ): string {
        \array_walk($input, static fn(&$v, $k) => $v = $k . '="' . $v.'"');
        return \implode(' ', $input);
    }

	//###< FILTERS ###
	
	//###> TESTS ###

    public function getTests()
    {
        return [
        ];
    }
    
	//###< TESTS ###
	
    //###> FUNCTIONS ###

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('gs_dump_array',						$this->dump_array(...)),
            new \Twig\TwigFunction('gs_lorem',							$this->lorem(...)),
            new \Twig\TwigFunction('gs_create_form',					$this->createForm(...)),
            new \Twig\TwigFunction('gs_time',							\time(...)),
            new \Twig\TwigFunction('gs_microtime',						$this->microtime(...)),
            new \Twig\TwigFunction('gs_echo',							$this->echo(...)),
            new \Twig\TwigFunction('gs_clear_output_buffer',			$this->clearOutputBuffer(...)),
        ];
    }
	
    public function clearOutputBuffer(): void
    {
		GSBufferService::clear();
    }


    public function dump_array($input) {
		\array_walk($input, static function($v, $k) {
			echo \nl2br($k . ' => ' . $v . \PHP_EOL . \PHP_EOL);
		});
	}
	
    public function forUser(
        \DateTime $data,
        string $tz = null,
        string $locale = null,
        string $iso = 'LLL',
        Request $request = null,
    ) {
        $cloneDateTime = $this->carFacImm->make($data)->toMutable();
        
		$cloneDateTime = GSCarbonService::forUser(
			origin:				$cloneDateTime,
			sourceOfMeta:		$sourceOfMeta,
			tz:					$tz,
			locale:				$locale,
		);
		$cloneDateTime->tz($tz ?? $cloneDateTime->tz())->locale($locale ?? $cloneDateTime->locale());
        if ($request && $locale = $request->attributes->get('_locale')) {
            $cloneDateTime->locale($locale);
        };
        unset($locale);

        return $cloneDateTime->isoFormat($iso);
    }

    public function echo($string)
    {
        echo($string);
    }

    public function microtime()
    {
        $offset = 2;
        $microtime = \microtime();
        return \substr($microtime, $offset, \strpos($microtime, ' ') - ($offset + 1));
    }

    public function createForm(string $type, object $entity = null, array $options = [])
    {
        return $this->formFactory->create($type, $entity, $options)->createView();
    }

    public function lorem(
        int $quantity = 1000,
    ): string {
		return $this->faker->realText($quantity);
    }
	
    //###< FUNCTIONS ###

    public function getTokenParsers()
    {
        return [];
    }

    public function getNodeVisitors()
    {
        return [];
	}
	
    public function getOperators()
    {
        return [];
    }

    public static function getPriority(): int
    {
        return -3;
    }

    public static function getDefaultIndexName(): int|string
    {
        return self::class;
    }
	
}
