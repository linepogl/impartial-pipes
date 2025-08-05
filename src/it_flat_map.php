<?php

declare(strict_types=1);

namespace Pipes;

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
        return static function (iterable $iterable) use ($valueProjection): iterable {
            foreach ($iterable as $key => $value) {
                foreach ($valueProjection($value, $key) as $innerValue) {
                    yield $innerValue;
                }
            }
        };
    }
}
