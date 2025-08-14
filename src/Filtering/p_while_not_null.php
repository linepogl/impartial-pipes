<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that takes elements of an iterable, while they are not null.
 *
 * ### Syntax
 * ```
 * p_while(
 *   [preserveKeys: bool = false,]
 * )
 * ```
 *
 * ### Examples
 * Take elements until a null is encountered
 * ```
 * [1, 2, null, 4]
 * |> p_while_not_null()
 * //= [1, 2]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => null, 'd' => 4]
 * |> p_while_not_null(preserveKeys: true)
 * //= ['a' => 1, 'b' => 2]
 * ```
 *
 * @template K
 * @template V
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,?V>):iterable<K,V> : callable(iterable<K,?V>):iterable<int,V>)
 */
function p_while_not_null(bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
            foreach ($iterable as $key => $value) {
                if (null === $value) {
                    break;
                }
                yield $key => $value;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
            foreach ($iterable as $key => $value) {
                if (null === $value) {
                    break;
                }
                yield $value;
            }
        });
}
