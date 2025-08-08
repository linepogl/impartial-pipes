<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to filter elements of an iterable, using a predicate.
 *
 * ### Syntax
 * ```
 * p_filter(
 *   callable(TValue[, TKey]): bool,
 *   [preserveKeys: bool = false,]
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
 * ```
 * [1, 2, 3, 4, 5]
 * |> p_filter(static fn (int $x) => $x % 2 === 0, preserveKeys: true);
 * //= [1 => 2, 3 => 4]
 * ```
 * Filter elements with keys shorter than three characters
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_filter(static fn (int $x, string $k) => strlen($k) < 3);
 * //= [1, 2]
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_filter(static fn (int $x, string $k) => strlen($k) < 3, preserveKeys: true);
 * //= ['a' => 1, 'bb' => 2]
 * ```
 *
 * @template K
 * @template V
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
