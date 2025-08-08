<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * TODO: docs
 *
 * @template K
 * @template V
 * @template K2
 * @param callable(V,K):K2 $keyProjection
 * @return callable(iterable<K,V>):iterable<K2,V>
 */
function p_reindex(callable $keyProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $keyProjection): iterable {
        foreach ($iterable as $key => $value) {
            yield $keyProjection($value, $key) => $value;
        }
    });
}
