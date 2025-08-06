<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @return callable<K,V>(iterable<K, V>):iterable<int, V>
 */
function it_values(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $value) {
            yield $value;
        }
    });
}
