<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LimitExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('limit', [$this, 'limit']),
        ];
    }

    public function limit($value, $signs = 1024)
    {
        return substr($value, 0, $signs) . '...';
    }

}
