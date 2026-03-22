<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that skips the first n elements of an iterable.
 *
 * ### Syntax
 * ```
 * p_skip(
 *   int,
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
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_skip(2)
 * //= [3, 4]
 * ```
 *
 * @param int $howMany
 * @return callable<K,V>(iterable<K,V>):iterable<int,V>
 */
function p_skip(int $howMany): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
        $i = 0;
        foreach ($iterable as $value) {
            if ($i++ < $howMany) {
                continue;
            }
            yield $value;
        }
    });
}

/**
 * Returns a partial function that skips the first n elements of an iterable, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_skip(
 *   int,
 * )
 * ```
 *
 * ### Examples
 * Skip elements
 * ```
 * [1, 2, 3, 4]
 * |> p_assoc_skip(2)
 * //= [2 => 3, 3 => 4]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_assoc_skip(2)
 * //= ['c' => 3, 'd' => 4]
 * ```
 *
 * @param int $howMany
 * @return callable<K,V>(iterable<K,V>):iterable<K,V>
 */
function p_assoc_skip(int $howMany): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
        $i = 0;
        foreach ($iterable as $key => $value) {
            if ($i++ < $howMany) {
                continue;
            }
            yield $key => $value;
        }
    });
}
