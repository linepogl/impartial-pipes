<?php

declare(strict_types=1);

namespace Pipes;

use Pipes\Util\LazyRewindableIterator;

if (!function_exists(__NAMESPACE__ . '\it_reindex')) {
    /**
     * @no-named-arguments
     *
     * @template V
     * @template K
     * @template K2
     * @param callable(V,K):K2 $keyProjection
     * @return callable(iterable<K,V>):iterable<K2,V>
     */
    function it_reindex(callable $keyProjection): callable
    {
        return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $keyProjection): iterable {
            foreach ($iterable as $key => $value) {
                yield $keyProjection($value, $key) => $value;
            }
        });
    }
}
