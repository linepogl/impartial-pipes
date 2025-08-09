<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that gets the key of the first element that satisfies some optional predicate.
 * If no predicate is provided, the function returns the first key.
 *
 * If no element is found, a predefined default is returned.
 *
 * ### Syntax
 * ```
 * p_first_key_or(
 *   TDefault,
 *   [callable(TValue[, TKey]): bool,]
 * )
 * ```
 *
 * ### Examples
 * First key without a predicate
 * ```
 * []
 * |> p_first_key_or(null)
 * //= null
 * ```
 * ```
 * [1, 2]
 * |> p_first_key_or(null)
 * //= 0
 * ```
 * First key with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_first_key_or(null, fn (int $x) => $x % 2 === 0)
 * //= 1
 * ```
 * ```
 * [1, 3, 5, 7, 9]
 * |> p_first_key_or(null, fn (int $x) => $x % 2 === 0)
 * //= null
 * ```
 * First key with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first_key_or(null, fn (int $x, string $key) => strlen($key) === 2)
 * //= 'bb'
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'dddd' => 4]
 * |> p_first_key_or(null, fn (int $x, string $key) => strlen($key) === 5)
 * //= null
 * ```
 *
 * @template K
 * @template V
 * @template D
 * @param D $default
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):(K2|D) : callable(iterable<K,V>):(K|D))
 */
function p_first_key_or(mixed $default, ?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return array_key_first($iterable);
            }
            foreach ($iterable as $key => $value) {
                return $key;
            }
            return null;

        }
    : static function (iterable $iterable) use ($predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $key;
            }
        }
        return null;
    };
}
