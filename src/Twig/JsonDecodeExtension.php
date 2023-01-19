<?php

namespace App\Twig;

use Twig\TwigFunction;

class JsonDecodeExtension extends \Twig\Extension\AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('json_decode', function ($string) {
                return json_decode($string);
            }),
            new TwigFunction('unserialize', 'unserialize'),
        ];
    }
}
