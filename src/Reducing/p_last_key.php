<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * Returns a partial function that gets the key of the last element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the last key.
 *
 * If no element is found, an `OutOfBoundsException` is thrown.
 *
 * ### Syntax
 * ```
 * p_last_key(
 *   [callable(TValue[, TKey]): bool,]
 * )
 * ```
 *
 * ### Examples
 * First key without a predicate
 * ```
 * []
 * |> p_last_key()
 * //= OutOfBoundsException
 * ```
 * ```
 * [1, 2]
 * |> p_last_key()
 * //= 0
 * ```
 * First key with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_last_key(fn (int $x) => $x % 2 === 0)
 * //= 1
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_last_key(fn (int $x) => $x % 2 === 0)
 * //= OutOfBoundsException
 * ```
 * First key with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_last_key(fn (int $x, string $key) => strlen($key) === 2)
 * //= 'bb'
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_last_key(fn (int $x, string $key) => strlen($key) === 5)
 * //= OutOfBoundsException
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):V2 : callable(iterable<K,V>):V)
 */
function p_last_key(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return array_key_last($iterable) ?? throw new OutOfBoundsException('Cannot get last element of an empty iterable');
            } else {
                $found = false;
                $lastKey = null;
                foreach ($iterable as $key => $value) {
                    $found = true;
                    $lastKey = $key;
                }
                if (!$found) {
                    throw new OutOfBoundsException('Cannot get last element of an empty iterable');
                }
                return $lastKey;
            }
        }
    : static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            for ($value = end($iterable); null !== ($key = key($iterable)); $value = prev($iterable)) {
                // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
                if ($predicate($value, $key)) {
                    return $key;
                }
            }
            throw new OutOfBoundsException('Key not found');
        } else {
            $found = false;
            $lastKey = null;
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    $found = true;
                    $lastKey = $key;
                }
            }
            if (!$found) {
                throw new OutOfBoundsException('Key not found');
            }
            return $lastKey;
        }
    };
}
