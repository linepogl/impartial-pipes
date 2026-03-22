<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that merges two iterables.
 *
 * ### Syntax
 * ```
 * p_concat(
 *   iterable<TOtherKey, TOtherValue>,
 * )
 * ```
 *
 * ### Examples
 * Concatenating two iterables
 * ```
 * [1, 2]
 * |> p_concat([3, 4])
 * //= [1, 2, 3, 4]
 * ```
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_concat(['b' => 22,'c' => 3])
 * //= [1, 2, 22, 3]
 * ```
 *
 * @template K2
 * @template V2
 * @param iterable<K2,V2> $other
 * @return callable<K1,V1>(iterable<K1,V1>):iterable<int,V1|V2>
 */
function p_concat(iterable $other): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $other): iterable {
        foreach ($iterable as $value) {
            yield $value;
        }
        foreach ($other as $value) {
            yield $value;
        }
    });
}

/**
 * Returns a partial function that merges two iterables, preserving the keys. Attention: This might result in duplicated keys.
 *
 * ### Syntax
 * ```
 * p_concat_assoc(
 *   iterable<TOtherKey, TOtherValue>,
 * )
 * ```
 * Concatenating two iterables, preserving keys. Keys might be duplicated in the result.
 * ```
 * [1, 2]
 * |> p_concat_assoc([3, 4])
 * //= [0 => 1, 1 => 2, 0 => 3, 1 => 4]
 * ```
 * ```
 * ['a' => 1,'b' => 2]
 * |> p_concat_assoc(['b' => 22,'c' => 3])
 * //= ['a' => 1,'b' => 2,'b' => 22,'c' => 3]
 * ```
 *
 * @template K2
 * @template V2
 * @param iterable<K2,V2> $other
 * @return callable<K1,V1>(iterable<K1,V1>):iterable<K1|K2,V1|V2>
 */
function p_concat_assoc(iterable $other): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $other): iterable {
        foreach ($iterable as $key => $value) {
            yield $key => $value;
        }
        foreach ($other as $key => $value) {
            yield $key => $value;
        }
    });
}
