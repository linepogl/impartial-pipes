<?php

declare(strict_types=1);

namespace Pipes;

use Pipes\Util\LazyRewindableIterator;

if (!function_exists(__NAMESPACE__ . '\it_flat_map')) {
    /**
     * @no-named-arguments
     *
     * @template V
     * @template K
     * @template V2
     * @param callable(V,K):iterable<V2> $valueProjection
     * @return callable(iterable<K,V>):iterable<K,V2>
     */
    function it_flat_map(callable $valueProjection): callable
    {
        return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
            foreach ($iterable as $key => $value) {
                foreach ($valueProjection($value, $key) as $innerValue) {
                    yield $innerValue;
                }
            }
        });
    }
}
