<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to get the value of the first element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the first value.
 *
 * If no element is found, a predefined default is returned.
 *
 * ### Syntax
 * ```
 * p_first_or(
 *   TDefault
 *   [, callable(TValue[, TKey]): bool]
 * )
 * ```
 *
 * ### Examples
 * First without a predicate
 * ```
 * []
 * |> p_first_or(null)
 * //= null
 * ```
 * ```
 * [1, 2]
 * |> p_first_or(null)
 * //= 2
 * ```
 * First with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_first_or(null, fn (int $x) => $x % 2 === 0)
 * //= 2
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_first_or(null, fn (int $x) => $x % 2 === 0)
 * //= null
 * ```
 * First with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first_or(null, fn (int $x, string $key) => strlen($key) === 2)
 * //= 2
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first_or(null, fn (int $x, string $key) => strlen($key) === 5)
 * //= null
 * ```
 *
 * @template K
 * @template V
 * @template D
 * @param D $default
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):(V2|D) : callable(iterable<K,V>):(V|D))
 */
function p_first_or(mixed $default, ?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) use ($default) {
            if (is_array($iterable)) {
                $firstKey = array_key_first($iterable);
                if (null === $firstKey) {
                    return $default;
                }
                return $iterable[$firstKey];
            }
            foreach ($iterable as $value) {
                return $value;
            }
            return $default;

        }
    : static function (iterable $iterable) use ($default, $predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $value;
            }
        }
        return $default;
    };
}
