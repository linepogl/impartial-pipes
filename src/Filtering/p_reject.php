<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that filters elements out of an iterable, using a predicate.
 *
 * ### Syntax
 * ```
 * p_reject(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Filter out even numbers from an array
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_reject(static fn (int $x) => $x % 2 === 0);
 * //= [1, 3, 5]
 * ```
 * Filter out elements with keys shorter than three characters
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_reject(static fn (int $x, string $k) => strlen($k) < 3);
 * //= [3]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<int,V>
 */
function p_reject(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        foreach ($iterable as $key => $value) {
            if (!$predicate($value, $key)) {
                yield $value;
            }
        }
    });
}

/**
 * Returns a partial function that filters elements out of an iterable, using a predicate, preserving the keys
 *
 * ### Syntax
 * ```
 * p_reject_assoc(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Filter out even numbers from an array
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_reject_assoc(static fn (int $x) => $x % 2 === 0);
 * //= [0 => 1, 2 => 3, 4 => 5]
 * ```
 * Filter out elements with keys shorter than three characters
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_reject_assoc(static fn (int $x, string $k) => strlen($k) < 3);
 * //= ['ccc' => 3]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<K,V>
 */
function p_reject_assoc(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        foreach ($iterable as $key => $value) {
            if (!$predicate($value, $key)) {
                yield $key => $value;
            }
        }
    });
}
