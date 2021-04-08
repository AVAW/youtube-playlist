<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class CommandHandlerCollection implements IteratorAggregate
{

    /** @var CommandInterface[] */
    protected array $collection = [];

    public function __construct(iterable $collection = [])
    {
        if ($collection) {
            $this->collection = iterator_to_array($collection);
        }
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }

}
