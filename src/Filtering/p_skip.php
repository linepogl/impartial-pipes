<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to skip the first n elements of an iterable.
 *
 * ### Syntax
 * ```
 * p_skip(
 *   int
 *   [, preserveKeys: bool = false]
 * )
 * ```
 *
 * ### Examples
 * Skip elements
 * ```
 * [1, 2, 3, 4]
 * |> p_skip(2)
 * //= [3, 4]
 * ```
 * ```
 * [1, 2, 3, 4]
 * |> p_skip(2, preserveKeys: true)
 * //= [2 => 3, 3 => 4]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_skip(2)
 * //= [3, 4]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_skip(2, preserveKeys: true)
 * //= ['c' => 3, 'd' => 4]
 * ```
 *
 * @template K
 * @template V
 * @param int $howMany
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_skip(int $howMany, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
            $i = 0;
            foreach ($iterable as $key => $value) {
                if ($i++ < $howMany) {
                    continue;
                }
                yield $key => $value;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
            $i = 0;
            foreach ($iterable as $value) {
                if ($i++ < $howMany) {
                    continue;
                }
                yield $value;
            }
        });
}
