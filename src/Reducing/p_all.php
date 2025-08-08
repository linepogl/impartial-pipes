<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to check if all elements of the iterable satisfy some predicate.
 *
 * ### Syntax
 * ```
 * p_all(
 *   callable(TValue[, TKey]): bool
 * )
 * ```
 *
 * ### Examples
 * Check with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_all(fn (int $x) => $x % 2 === 1)
 * //= false
 * ```
 * ```
 * [1, 3, 5, 7, 11]
 * |> p_all(fn (int $x) => $x % 2 === 1)
 * //= true
 * ```
 * Check with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_all(fn (int $x, string $key) => strlen($key) < 2)
 * //= false
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_all(fn (int $x, string $key) => strlen($key) < 5)
 * //= true
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):bool
 */
function p_all(callable $predicate): callable
{
    return static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
            return array_all($iterable, static fn ($value, $key) => $predicate($value, $key));
        }
        foreach ($iterable as $key => $value) {
            if (!$predicate($value, $key)) {
                return false;
            }
        }
        return true;
    };
}
