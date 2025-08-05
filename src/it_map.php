<?php

declare(strict_types=1);

namespace Pipes;

use Pipes\Util\LazyRewindableIterator;

if (!function_exists(__NAMESPACE__ . '\it_map')) {
    /**
     * @no-named-arguments
     *
     * @template V
     * @template K
     * @template V2
     * @template K2
     * @param callable(V,K):V2 $valueProjection
     * @param ?callable(V,K):K2 $keyProjection
     * @return ($keyProjection is null ? callable(iterable<K,V>):iterable<K,V2> : callable(iterable<K,V>):iterable<K2,V2>)
     */
    function it_map(callable $valueProjection, ?callable $keyProjection = null): callable
    {
        return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection, $keyProjection): iterable {
            if ($keyProjection === null) {
                foreach ($iterable as $key => $value) {
                    yield $key => $valueProjection($value, $key);
                }
            } else {
                foreach ($iterable as $key => $value) {
                    yield $keyProjection($value, $key) => $valueProjection($value, $key);
                }
            }
        });
    }
}
