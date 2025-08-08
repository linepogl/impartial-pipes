<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to skip the elements of an iterable, while some predicate is true.
 *
 * ### Syntax
 * ```
 * p_skip_while(
 *   callable(TValue[, TKey]): bool,
 *   [preserveKeys: bool = false,]
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
 * ```
 * [1, 2, 3, 4]
 * |> p_skip_while(static fn (int $x) => $x < 3, preserveKeys: true)
 * //= [2 => 3, 3 => 4]
 * ```
 * Skip elements with a value and key predicate
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_skip_while(static fn (int $x, string $k) => strlen($k) < 3)
 * //= [3, 4]
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3, 'd' => 4]
 * |> p_skip_while(static fn (int $x, string $k) => strlen($k) < 3, preserveKeys: true)
 * //= ['ccc' => 3, 'd' => 4]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):bool $predicate
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_skip_while(callable $predicate, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
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
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
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
