<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to filter elements of an iterable with a predicate.
 *
 * ### Syntax
 *
 * ```
 * p_filter(
 *   predicate: callable( TValue $value[, TKey $key ] ): bool
 * )
 * ```
 * ### Examples
 *
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_filter(static fn (int $x) => $x % 2 === 0);
 * //= [2, 4]
 * ```
 * ```
 * 1, 2, 3, 4, 5]
 * |> p_filter(static fn (int $x) => $x % 2 === 0);
 * //= [2, 4]
 * ```
 *
 * @template V
 * @template K
 * @param callable(V,K):bool $predicate
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_filter(callable $predicate, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    yield $key => $value;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    yield $value;
                }
            }
        });
}
