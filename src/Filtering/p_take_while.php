<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to take the elements of an iterable, while some predicate is true.
 *
 * ### Syntax
 * ```
 * p_take_while(
 *   callable(TValue[, TKey]):bool
 *   [, preserveKeys: bool = false]
 * )
 * ```
 *
 * ### Examples
 * Take elements with a value predicate
 * ```
 * [1, 2, 3, 4]
 * |> p_take_while(static fn (int $x) => $x < 3)
 * //= [1, 2]
 * ```
 * ```
 * [1, 2, 3, 4]
 * |> p_take_while(static fn (int $x) => $x < 3, preserveKeys: true)
 * //= [1, 2]
 * ```
 * Skip elements with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_take_while(static fn (int $x, string $k) => strlen($k) < 3)
 * //= [1, 2]
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_take_while(static fn (int $x, string $k) => strlen($k) < 3, preserveKeys: true)
 * //= ['a' => 3, 'bb' => 4]
 * ```
 *
 * @template V
 * @template K
 * @param callable(V,K):bool $predicate
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_take_while(callable $predicate, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    yield $key => $value;
                } else {
                    break;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    yield $value;
                } else {
                    break;
                }
            }
        });
}
