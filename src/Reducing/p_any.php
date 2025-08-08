<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;

/**
 * Partial function to check if any element of the iterable satisfies some optional predicate. If no predicate is
 * provided, the function checks if the iterable is not empty.
 *
 * ### Syntax
 * ```
 * p_any(
 *   [callable(TValue[, TKey]): bool]
 * )
 * ```
 *
 * ### Examples
 * Check without a predicate
 * ```
 * []
 * |> p_any()
 * //= false
 * ```
 * ```
 * [1, 2]
 * |> p_any()
 * //= true
 * ```
 * Check with a value predicate
 * ```
 * [2, 4, 6, 8, 10]
 * |> p_any(fn (int $x) => $x % 2 === 1)
 * //= false
 * ```
 * ```
 * [2, 4, 6, 7, 10]
 * |> p_any(fn (int $x) => $x % 2 === 1)
 * //= true
 * ```
 * Check with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_any(fn (int $x, string $key) => strlen($key) > 5)
 * //= false
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_any(fn (int $x, string $key) => strlen($key) > 2)
 * //= true
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):bool : callable(iterable<K,V>):bool)
 */
function p_any(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return count($iterable) > 0; // quicker than iterating
            } elseif ($iterable instanceof ArrayIterator) {
                return count($iterable->getArrayCopy()) > 0; // quicker than iterating, and it does not really copy the array
            }
            foreach ($iterable as $_) {
                return true;
            }
            return false;
        }
    : static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
            return array_any($iterable, static fn ($value, $key) => $predicate($value, $key));
        }
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return true;
            }
        }
        return false;
    };
}
