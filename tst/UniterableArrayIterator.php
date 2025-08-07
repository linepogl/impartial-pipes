<?php

declare(strict_types=1);

namespace Tests;

use ArrayIterator;
use Override;
use RuntimeException;

/**
 * @internal
 * @template K of array-key
 * @template V
 * @extends ArrayIterator<K,V>
 */
final class UniterableArrayIterator extends ArrayIterator
{
    #[Override]
    public function rewind(): void
    {
        throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
    }
    #[Override]
    public function next(): void
    {
        throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
    }
    #[Override]
    public function key(): null|int|string
    {
        throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
    }
    #[Override]
    public function current(): mixed
    {
        throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
    }
    #[Override]
    public function valid(): bool
    {
        throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
    }
}
