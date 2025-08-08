<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * Partial function to get the key of the first element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the first key.
 *
 * If no element is found, an `OutOfBoundsException` is thrown.
 *
 * ### Syntax
 * ```
 * p_first_key(
 *   [callable(TValue[, TKey]): bool,]
 * )
 * ```
 *
 * ### Examples
 * First key without a predicate
 * ```
 * []
 * |> p_first_key()
 * //= OutOfBoundsException
 * ```
 * ```
 * [1, 2]
 * |> p_first_key()
 * //= 0
 * ```
 * First key with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_first_key(fn (int $x) => $x % 2 === 0)
 * //= 1
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_first_key(fn (int $x) => $x % 2 === 0)
 * //= OutOfBoundsException
 * ```
 * First key with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first_key(fn (int $x, string $key) => strlen($key) === 2)
 * //= 'bb'
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first_key(fn (int $x, string $key) => strlen($key) === 5)
 * //= OutOfBoundsException
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):K2 : callable(iterable<K,V>):K)
 */
function p_first_key(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return array_key_first($iterable) ?? throw new OutOfBoundsException('Cannot get first key of an empty iterable');
            } else {
                foreach ($iterable as $key => $value) {
                    return $key;
                }
                throw new OutOfBoundsException('Cannot get first key of an empty iterable');
            }
        }
    : static function (iterable $iterable) use ($predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $key;
            }
        }
        throw new OutOfBoundsException('Key not found');
    };
}
