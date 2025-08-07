<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Countable;
use Generator;
use Iterator;
use Override;

/**
 * @template K
 * @template V
 * @implements Iterator<K,V>
 */
class LazyRewindableIterator implements Iterator, Countable
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
            $this->init();
        }
        $this->iterator->rewind();
    }

    #[Override]
    public function current(): mixed
    {
        if ($this->iterator === null) {
            $this->init();
        }
        return $this->iterator->current();
    }

    #[Override]
    public function next(): void
    {
        if ($this->iterator === null) {
            $this->init();
        }

        $this->iterator->next();
    }

    #[Override]
    public function key(): mixed
    {
        if ($this->iterator === null) {
            $this->init();
        }

        return $this->iterator->key();
    }

    #[Override]
    public function valid(): bool
    {
        if ($this->iterator === null) {
            $this->init();
        }

        return $this->iterator->valid();
    }

    /**
     * @phpstan-assert Iterator<K,V> $this->iterator //post-condition: after calling this method, $this->iterator is not null
     */
    private function init(): void
    {
        $this->iterator = iterable_to_iterator(($this->lazyIterable)());
    }

    #[Override]
    public function count(): int
    {
        if ($this->iterator === null) {
            $this->init();
        }
        return iterable_count($this->iterator);
    }
}
