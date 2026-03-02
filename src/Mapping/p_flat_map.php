<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that gets the values of an iterable using a projection to an iterable callable, flattening the result.
 *
 * ### Syntax
 *
 * ```
 * p_flat_map(
 *   callable(TValue[, TKey]): iterable<TNewValue>,
 *   [preserveKeys: bool = false,]
 * )
 * ```
 *
 * ### Examples
 *
 * Flat-map by value
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_flat_map(static fn (int $value) => [$value, $value * $value])
 * //= [1, 1, 2, 4, 3, 9]
 * ```
 *
 * Flat-map by value and key
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_flat_map(static fn (int $value, string $key) => [$value, $key, $key . $value])
 * //= [1, 'a', 'a1', 2, 'b', 'b2', 3, 'c', 'c3']
 * ```

 * Flat-map preserving keys
 * ```
 * ['a' => ['a1' => 1, 'a2' => 2], 'b' => ['b1' => 1, 'b2' => 2]]
 * |> p_flat_map(static fn (array $value, string $key) => $value |> p_map(static fn (int $innerValue) => $key), preserveKeys: true
 * //= ['a1' => 'a', 'a2' => 'a', 'b1' => 'b', 'b2' => 'b']
 * ```
 *
 * @template K
 * @template V
 * @template K2
 * @template V2
 * @param callable(V,K):iterable<K2,V2> $valueProjection
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K2,V2> : callable(iterable<K,V>):iterable<int,V2>)
 */
function p_flat_map(callable $valueProjection, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
            foreach ($iterable as $key => $value) {
                foreach ($valueProjection($value, $key) as $innerKey => $innerValue) {
                    yield $innerKey => $innerValue;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
            foreach ($iterable as $key => $value) {
                foreach ($valueProjection($value, $key) as $innerValue) {
                    yield $innerValue;
                }
            }
        });
}
