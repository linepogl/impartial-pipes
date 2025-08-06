<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template V
 * @template K
 * @template V2
 * @param callable(V,K):V2 $valueProjection
 * @return callable(iterable<K,V>):iterable<K,V2>
 */
function p_map(callable $valueProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
        foreach ($iterable as $key => $value) {
            yield $key => $valueProjection($value, $key);
        }
    });
}
