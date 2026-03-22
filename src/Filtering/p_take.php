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
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_take(2)
 * //= [1, 2]
 * ```
 *
 * @param int $howMany
 * @return callable<K,V>(iterable<K,V>):iterable<int,V>
 */
function p_take(int $howMany): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
        $i = 0;
        foreach ($iterable as $value) {
            if (++$i > $howMany) {
                break;
            }
            yield $value;
        }
    });
}

/**
 * Returns a partial function that takes the first n elements of an iterable, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_take(
 *   int,
 * )
 * ```
 *
 * ### Examples
 * Take elements
 * ```
 * [1, 2, 3, 4]
 * |> p_assoc_take(2)
 * //= [1, 2]
 * ```
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_assoc_take(2)
 * //= ['a' => 1, 'b' => 2]
 * ```
 *
 * @param int $howMany
 * @return callable<K,V>(iterable<K,V>):iterable<K,V>
 */
function p_assoc_take(int $howMany): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
        $i = 0;
        foreach ($iterable as $key => $value) {
            if (++$i > $howMany) {
                break;
            }
            yield $key => $value;
        }
    });
}
