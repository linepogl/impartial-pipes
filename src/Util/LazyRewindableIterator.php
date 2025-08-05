<?php

declare(strict_types=1);

namespace Pipes\Util;

use Generator;
use Iterator;
use Override;
use RuntimeException;

/**
 * @template K
 * @template V
 * @implements Iterator<K,V>
 */
class LazyRewindableIterator implements Iterator
{
    /** @var callable(): iterable<K,V> */
    private readonly mixed $lazyIterable;

    /** @var ?Iterator<K,V> */
    private ?Iterator $iterator = null;

    /**
     * @param callable(): iterable<K,V> $lazyIterable
     */
    public function __construct(callable $lazyIterable)
    {
        $this->lazyIterable = $lazyIterable;
    }

    #[Override]
    public function rewind(): void
    {
        if ($this->iterator === null || $this->iterator instanceof Generator) {
            $iterable = ($this->lazyIterable)();
            $this->iterator = iterable_to_iterator($iterable);
        }
        $this->iterator->rewind();
    }

    #[Override]
    public function current(): mixed
    {
        if ($this->iterator === null) {
            throw new RuntimeException('The iterator must be rewound first');
        }
        return $this->iterator->current();
    }

    #[Override]
    public function next(): void
    {
        if ($this->iterator === null) {
            throw new RuntimeException('The iterator must be rewound first');
        }

        $this->iterator->next();
    }

    #[Override]
    public function key(): mixed
    {
        if ($this->iterator === null) {
            throw new RuntimeException('The iterator must be rewound first');
        }

        return $this->iterator->key();
    }

    #[Override]
    public function valid(): bool
    {
        if ($this->iterator === null) {
            throw new RuntimeException('The iterator must be rewound first');
        }

        return $this->iterator->valid();
    }
}
