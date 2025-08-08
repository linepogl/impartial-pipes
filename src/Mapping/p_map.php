<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to map the values of an iterable using a projection callable, while preserving the keys.
 *
 * ### Syntax
 *
 * ```
 * p_map(
 *   callable(TValue[, TKey]): TNewValue
 * )
 * ```
 *
 * ### Examples
 *
 * Map by value
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_map(static fn (int $value) => $value * $value)
 * //= ['a' => 1, 'b' => 4]
 * ```
 *
 * Map by value and key
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_map(static fn (int $value, string $key) => $key . $value)
 * //= ['a' => 'a1', 'b' => 'b2']
 * ```
 *
 * @template K
 * @template V
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
