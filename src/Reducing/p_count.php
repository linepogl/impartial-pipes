<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Countable;

/**
 * Partial function to count the element of the iterable that satisfy some optional predicate. If no predicate is
 * provided, the function counts the number of all the elements in the iterable.
 *
 * ### Syntax
 * ```
 * p_count(
 *   [callable(TValue[, TKey]): bool]
 * )
 * ```
 *
 * ### Examples
 * Count without a predicate
 * ```
 * []
 * |> p_count()
 * //= 0
 * ```
 * ```
 * [1, 2]
 * |> p_count()
 * //= 2
 * ```
 * Count with a value predicate
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_count(fn (int $x) => $x % 2 === 1)
 * //= 3
 * ```
 * Count with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'c' => 3, 'd' => 3]
 * |> p_any(fn (int $x, string $key) => strlen($key) === 1)
 * //= 3
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 *
 * @return ($predicate is null ? callable<KK,VV>(iterable<KK, VV>|Countable):int<0,max> : callable(iterable<K, V>):int<0,max>)
 */
function p_count(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable|Countable $input) {
            return $input instanceof Countable
                ? $input->count()
                : iterable_count($input);
        }
    : static function (iterable $iterable) use ($predicate) {
        $count = 0;
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                $count++;
            }
        }
        return $count;
    };
}
