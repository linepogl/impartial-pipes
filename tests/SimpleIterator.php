<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests;

use Iterator;
use OutOfBoundsException;
use Override;

/**
 * @internal
 * @template V
 * @implements Iterator<array-key,V>
 */
final class SimpleIterator implements Iterator
{
    /**
     * @param array<array-key,V> $array
     */
    public function __construct(
        private array $array,
    ) {
    }

    #[Override]
    public function current(): mixed
    {
        $key = key($this->array) ?? throw new OutOfBoundsException();
        return $this->array[$key];
    }

    #[Override]
    public function next(): void
    {
        next($this->array);
    }

    #[Override]
    public function key(): mixed
    {
        return key($this->array) ?? throw new OutOfBoundsException();
    }

    #[Override]
    public function valid(): bool
    {
        return null !== key($this->array);
    }

    #[Override]
    public function rewind(): void
    {
        reset($this->array);
    }
}
