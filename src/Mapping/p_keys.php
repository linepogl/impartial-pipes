<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @return callable<K,V>(iterable<K, V>):iterable<int, K>
 */
function p_keys(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $key => $value) {
            yield $key;
        }
    });
}
