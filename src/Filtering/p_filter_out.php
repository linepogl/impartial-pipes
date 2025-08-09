<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that filters elements out of an iterable, using a predicate.
 *
 * ### Syntax
 * ```
 * p_filter_out(
 *   callable(TValue[, TKey]): bool,
 *   [preserveKeys: bool = false,]
 * )
 * ```
 *
 * ### Examples
 * Filter out even numbers from an array
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_filter_out(static fn (int $x) => $x % 2 === 0);
 * //= [1, 3, 5]
 * ```
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_filter_out(static fn (int $x) => $x % 2 === 0, preserveKeys: true);
 * //= [0 => 1, 2 => 3, 4 => 5]
 * ```
 * Filter out elements with keys shorter than three characters
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_filter_out(static fn (int $x, string $k) => strlen($k) < 3);
 * //= [3]
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_filter_out(static fn (int $x, string $k) => strlen($k) < 3, preserveKeys: true);
 * //= ['ccc' => 3]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_filter_out(callable $predicate, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            foreach ($iterable as $key => $value) {
                if (!$predicate($value, $key)) {
                    yield $key => $value;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            foreach ($iterable as $key => $value) {
                if (!$predicate($value, $key)) {
                    yield $value;
                }
            }
        });
}
