<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that takes elements of an iterable, while some predicate is true.
 *
 * ### Syntax
 * ```
 * p_while(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Take elements with a value predicate
 * ```
 * [1, 2, 3, 4]
 * |> p_while(static fn (int $x) => $x < 3)
 * //= [1, 2]
 * ```
 * Take elements with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_while(static fn (int $x, string $k) => strlen($k) < 3)
 * //= [1, 2]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<int,V>
 */
function p_while(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                yield $value;
            } else {
                break;
            }
        }
    });
}

/**
 * Returns a partial function that takes elements of an iterable, while some predicate is true, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_while(
 *   callable(TValue[, TKey]): bool,
 * )
 * ```
 *
 * ### Examples
 * Take elements with a value predicate
 * ```
 * [1, 2, 3, 4]
 * |> p_assoc_while(static fn (int $x) => $x < 3)
 * //= [1, 2]
 * ```
 * Take elements with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_assoc_while(static fn (int $x, string $k) => strlen($k) < 3)
 * //= ['a' => 3, 'bb' => 4]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):iterable<K,V>
 */
function p_assoc_while(callable $predicate): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                yield $key => $value;
            } else {
                break;
            }
        }
    });
}
