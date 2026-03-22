<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that takes elements of an iterable, while they are not null.
 *
 * ### Syntax
 * ```
 * p_while_not_null()
 * ```
 *
 * ### Examples
 * Take elements until a null is encountered
 * ```
 * [1, 2, null, 4]
 * |> p_while_not_null()
 * //= [1, 2]
 * ```
 *
 * @return callable<K,V>(iterable<K,?V>):iterable<int,V>
 */
function p_while_not_null(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $key => $value) {
            if (null === $value) {
                break;
            }
            yield $value;
        }
    });
}

/**
 * Returns a partial function that takes elements of an iterable, while they are not null, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_while_not_null()
 * ```
 *
 * ### Examples
 * Take elements until a null is encountered
 * ```
 * ['a' => 1, 'b' => 2, 'c' => null, 'd' => 4]
 * |> p_assoc_while_not_null()
 * //= ['a' => 1, 'b' => 2]
 * ```
 *
 * @return callable<K,V>(iterable<K,?V>):iterable<K,V>
 */
function p_assoc_while_not_null(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $key => $value) {
            if (null === $value) {
                break;
            }
            yield $key => $value;
        }
    });
}
