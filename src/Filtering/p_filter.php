<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that filters the elements of an iterable, using a predicate.
 *
 * ### Syntax
 * ```
 * p_filter(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Filter even numbers from an array
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_filter(static fn (int $x) => $x % 2 === 0);
 * //= [2, 4]
 * ```
 * Filter elements with keys shorter than three characters
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_filter(static fn (int $x, string $k) => strlen($k) < 3);
 * //= [1, 2]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<int,V>
 */
function p_filter(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                yield $value;
            }
        }
    });
}

/**
 * Returns a partial function that filters the elements of an iterable, using a predicate, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_filter(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Filter even numbers from an array
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_assoc_filter(static fn (int $x) => $x % 2 === 0);
 * //= [1 => 2, 3 => 4]
 * ```
 * Filter elements with keys shorter than three characters
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_assoc_filter(static fn (int $x, string $k) => strlen($k) < 3);
 * //= ['a' => 1, 'bb' => 2]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<K,V>
 */
function p_assoc_filter(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                yield $key => $value;
            }
        }
    });
}
