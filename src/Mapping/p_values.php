<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @return callable<K,V>(iterable<K, V>):iterable<int, V>
 */
function p_values(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $value) {
            yield $value;
        }
    });
}
