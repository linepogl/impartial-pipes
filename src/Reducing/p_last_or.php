<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that gets the value of the last element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the last value.
 *
 * If no element is found, a predefined default is returned.
 *
 * ### Syntax
 * ```
 * p_last_or(
 *   TDefault,
 *   [callable(TValue[, TKey]): bool,]
 * )
 * ```
 *
 * ### Examples
 * First without a predicate
 * ```
 * []
 * |> p_last_or(null)
 * //= null
 * ```
 * ```
 * [1, 2]
 * |> p_last_or(null)
 * //= 2
 * ```
 * First with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_last_or(null, fn (int $x) => $x % 2 === 0)
 * //= 2
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_last_or(null, fn (int $x) => $x % 2 === 0)
 * //= null
 * ```
 * First with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_last_or(null, fn (int $x, string $key) => strlen($key) === 2)
 * //= 2
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_last_or(null, fn (int $x, string $key) => strlen($key) === 5)
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
function p_last_or(mixed $default, ?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) use ($default) {
            if (is_array($iterable)) {
                $lastKey = array_key_last($iterable);
                if (null === $lastKey) {
                    return $default;
                }
                return $iterable[$lastKey];
            }
            $last = $default;
            foreach ($iterable as $value) {
                $last = $value;
            }
            return $last;
        }
    : static function (iterable $iterable) use ($default, $predicate) {
        if (is_array($iterable)) {
            for ($value = end($iterable); null !== ($key = key($iterable)); $value = prev($iterable)) {
                // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
                if ($predicate($value, $key)) {
                    return $value;
                }
            }
            return $default;
        }
        $last = $default;
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                $last = $value;
            }
        }
        return $last;
    };
}
