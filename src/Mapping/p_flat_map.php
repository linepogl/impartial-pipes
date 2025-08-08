<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to map the values of an iterable using a projection to an iterable callable, flattening the result.
 *
 * ### Syntax
 *
 * ```
 * p_flat_map(
 *   callable(TValue[, TKey]): iterable<TValueNew>
 * )
 * ```
 *
 * ### Examples
 *
 * Map by value
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_flat_map(static fn (int $value) => [$value, $value * $value])
 * //= [1, 1, 2, 4, 3, 9]
 * ```
 *
 * Map by value and key
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_flat_map(static fn (int $value, string $key) => [$value, $key, $key . $value])
 * //= [1, 'a', 'a1', 2, 'b', 'b2', 3, 'c', 'c3']
 * ```
 *
 * @template V
 * @template K
 * @template V2
 * @param callable(V,K):iterable<V2> $valueProjection
 * @return callable(iterable<K,V>):iterable<K,V2>
 */
function p_flat_map(callable $valueProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
        foreach ($iterable as $key => $value) {
            foreach ($valueProjection($value, $key) as $innerValue) {
                yield $innerValue;
            }
        }
    });
}
