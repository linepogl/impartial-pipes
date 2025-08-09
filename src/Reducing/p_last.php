<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * Returns a partial function that gets the value of the last element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the last value.
 *
 * If no element is found, an `OutOfBoundsException` is thrown.
 *
 * ### Syntax
 * ```
 * p_last(
 *   [callable(TValue[, TKey]): bool,]
 * )
 * ```
 *
 * ### Examples
 * First without a predicate
 * ```
 * []
 * |> p_last()
 * //= OutOfBoundsException
 * ```
 * ```
 * [1, 2]
 * |> p_last()
 * //= 2
 * ```
 * First with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_last(fn (int $x) => $x % 2 === 0)
 * //= 2
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_last(fn (int $x) => $x % 2 === 0)
 * //= OutOfBoundsException
 * ```
 * First with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_last(fn (int $x, string $key) => strlen($key) === 2)
 * //= 2
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_last(fn (int $x, string $key) => strlen($key) === 5)
 * //= OutOfBoundsException
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):V2 : callable(iterable<K,V>):V)
 */
function p_last(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                $lastKey = array_key_last($iterable);
                if (null === $lastKey) {
                    throw new OutOfBoundsException('Cannot get last element of an empty iterable');
                }
                return $iterable[$lastKey];
            }
            $found = false;
            $last = null;
            foreach ($iterable as $value) {
                $found = true;
                $last = $value;
            }
            if (!$found) {
                throw new OutOfBoundsException('Cannot get last element of an empty iterable');
            }
            return $last;

        }
    : static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            for ($value = end($iterable); null !== ($key = key($iterable)); $value = prev($iterable)) {
                // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
                if ($predicate($value, $key)) {
                    return $value;
                }
            }
            throw new OutOfBoundsException('Element not found');
        } else {
            $found = false;
            $last = null;
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    $found = true;
                    $last = $value;
                }
            }
            if (!$found) {
                throw new OutOfBoundsException('Element not found');
            }
            return $last;
        }
    };
}
