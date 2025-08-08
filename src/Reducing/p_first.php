<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * Partial function to get the value of the first element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the first value.
 *
 * If no element is found, an `OutOfBoundsException` is thrown.
 *
 * ### Syntax
 * ```
 * p_first(
 *   [callable(TValue[, TKey]): bool,]
 * )
 * ```
 *
 * ### Examples
 * First without a predicate
 * ```
 * []
 * |> p_first()
 * //= OutOfBoundsException
 * ```
 * ```
 * [1, 2]
 * |> p_first()
 * //= 2
 * ```
 * First with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_first(fn (int $x) => $x % 2 === 0)
 * //= 2
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_first(fn (int $x) => $x % 2 === 0)
 * //= OutOfBoundsException
 * ```
 * First with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first(fn (int $x, string $key) => strlen($key) === 2)
 * //= 2
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first(fn (int $x, string $key) => strlen($key) === 5)
 * //= OutOfBoundsException
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):V2 : callable(iterable<K,V>):V)
 */
function p_first(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                $firstKey = array_key_first($iterable);
                if (null === $firstKey) {
                    throw new OutOfBoundsException('Cannot get first element of an empty iterable');
                }
                return $iterable[$firstKey];
            }
            foreach ($iterable as $value) {
                return $value;
            }
            throw new OutOfBoundsException('Cannot get first element of an empty iterable');

        }
    : static function (iterable $iterable) use ($predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $value;
            }
        }
        throw new OutOfBoundsException('Element not found');
    };
}
