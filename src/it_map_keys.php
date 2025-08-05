<?php

declare(strict_types=1);

namespace Pipes;

if (!function_exists(__NAMESPACE__ . '\it_map_keys')) {
    /**
     * @no-named-arguments
     *
     * @template V
     * @template K
     * @template K2
     * @param callable(V,K):K2 $keyProjection
     * @return callable(iterable<K,V>):iterable<K2,V>
     */
    function it_map_keys(callable $keyProjection): callable
    {
        return static function (iterable $iterable) use ($keyProjection): iterable {
            foreach ($iterable as $key => $value) {
                yield $keyProjection($value, $key) => $value;
            }
        };
    }
}
