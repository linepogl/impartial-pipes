<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that skips the elements of an iterable, while some predicate is true.
 *
 * ### Syntax
 * ```
 * p_skip_while(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Skip elements with a value predicate
 * ```
 * [1, 2, 3, 4]
 * |> p_skip_while(static fn (int $x) => $x < 3)
 * //= [3, 4]
 * ```
 * Skip elements with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_skip_while(static fn (int $x, string $k) => strlen($k) < 3)
 * //= [3, 4]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<int,V>
 */
function p_skip_while(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        $skipping = true;
        foreach ($iterable as $key => $value) {
            if ($skipping) {
                if ($predicate($value, $key)) {
                    continue;
                }
                $skipping = false;
            }
            yield $value;
        }
    });
}

/**
 * Returns a partial function that skips the elements of an iterable, while some predicate is true, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_skip_while(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Skip elements with a value predicate
 * ```
 * [1, 2, 3, 4]
 * |> p_assoc_skip_while(static fn (int $x) => $x < 3)
 * //= [2 => 3, 3 => 4]
 * ```
 * Skip elements with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_assoc_skip_while(static fn (int $x, string $k) => strlen($k) < 3)
 * //= ['ccc' => 3, 'd' => 4]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<K,V>
 */
function p_assoc_skip_while(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        $skipping = true;
        foreach ($iterable as $key => $value) {
            if ($skipping) {
                if ($predicate($value, $key)) {
                    continue;
                }
                $skipping = false;
            }
            yield $key => $value;
        }
    });
}
