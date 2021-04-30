<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class Locales extends AbstractExtension implements GlobalsInterface
{

    protected array $locales;

    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }

    public function getGlobals(): array
    {
        return [
            'locales' => $this->locales,
        ];
    }

    public function getName(): string
    {
        return 'Locales_extension';
    }

}
