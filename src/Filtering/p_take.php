<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that takes the first n elements of an iterable.
 *
 * ### Syntax
 * ```
 * p_take(
 *   int,
 *   [preserveKeys: bool = false,]
 * )
 * ```
 *
 * ### Examples
 * Take elements
 * ```
 * [1, 2, 3, 4]
 * |> p_take(2)
 * //= [1, 2]
 * ```
 * ```
 * [1, 2, 3, 4]
 * |> p_take(2, preserveKeys: true)
 * //= [1, 2]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_take(2)
 * //= [1, 2]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_take(2, preserveKeys: true)
 * //= ['a' => 1, 'b' => 2]
 * ```
 *
 * @template K
 * @template V
 * @param int $howMany
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_take(int $howMany, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
            $i = 0;
            foreach ($iterable as $key => $value) {
                if (++$i > $howMany) {
                    break;
                }
                yield $key => $value;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
            $i = 0;
            foreach ($iterable as $value) {
                if (++$i > $howMany) {
                    break;
                }
                yield $value;
            }
        });
}
