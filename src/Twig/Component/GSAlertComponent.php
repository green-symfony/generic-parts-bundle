<?php

namespace GS\GenericParts\Twig\Component;

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

#[AsTwigComponent('gs_alert', template: '@GSGenericParts/components/gs_alert.html.twig')]
class GSAlertComponent
{
    public const ALERT_PREFIX = 'alert alert-';

    /*
        Input Data
    */
    public string $type = 'success';
    public bool $isFlash = true;
    public bool $isTop = false;
    public int $delay = 3000;
    public string $containerAttribute = '';
    public string $containerClass = '';
    public string $messageClass = '';
    public string $messageStyle = '';
    public string $message = '';

    /*
        _Inner set data
        _Косвенная установка свойств
    */
    public string $containerInnerClass = '';
    public string $containerInnerAttribute = '';
    public function mount(
        ?bool $isFlash = null,
        ?bool $isTop = null,
        ?int $delay = null,
        //?string $type = null,
    ) {
        // if ($type) $this->type = $type;
        $isFlash ??= $this->isFlash;
        $delay ??= $this->delay;

        if ($isFlash) {
            $this->containerInnerAttribute = "data-controller=flash  data-flash-delay-value=${delay}";
            $this->containerInnerClass = ' d-none';
        }
        if ($isTop) {
            //$this->containerInnerClass .= ' fixed-top rounded-0 rounded-bottom';
        }
        //\dd($this->containerClass);
    }

    #[preMount(priority: 0)]
    public function preMount(array $data)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        return $resolver->resolve($data);
    }

    // >>> helpers >>>

    protected function configureOptions(OptionsResolver $resolver)
    {
        //\dd($this->type);
        $resolver
            ->setDefined([
            ])
            ->setDefaults([
                'type'  =>              $this->type,
                'isFlash' =>            $this->isFlash,
                'containerClass' =>     $this->containerClass,
                'containerAttribute' => $this->containerAttribute,
                'messageClass' =>       $this->messageClass,
                'messageStyle' =>       $this->messageStyle,
                'delay' =>              $this->delay,
                'isTop' =>              $this->isTop,
                'message' =>            $this->message,
            ])
            //
            ->setRequired([
                'message',
            ])
            //
            ->setAllowedTypes('type', ['string', 'null'])
            ->setAllowedTypes('message', ['string', 'null'])
            ->setAllowedTypes('isFlash', ['bool', 'null'])
            ->setAllowedTypes('isTop', ['bool', 'null'])
            //
            ->setAllowedValues(
                'type',
                [
                    'success',
                    'primary',
                    'danger',
                    'warning',
                    'secondary',
                    'info',
                    'light',
                    'dark',
                ],
            )
        ;
    }
}
