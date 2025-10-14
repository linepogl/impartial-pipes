<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that merges two iterables.
 *  - If `$preserveKeys` is `false`, the result is a 0-indexed iteration.
 *  - If `$preserveKeys` is `true`, the keys of the two iterables are preserved. If the same key exists in both iterables, only the first occurrence is used.
 *
 * ### Syntax
 * ```
 * p_megre(
 *   iterable<TOtherKey, TOtherValue>,
 *   [preserveKeys: bool = false,]
 * )
 * ```
 *
 * ### Examples
 * Merging two iterables
 * ```
 * [1, 2]
 * |> p_merge([3, 4])
 * //= [1, 2, 3, 4]
 * ```
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_merge(['b' => 22,'c' => 3])
 * //= [1, 2, 22, 3]
 * ```
 * Merging two iterables, preserving keys. Keys might be duplicated in the result.
 * ```
 * [1, 2]
 * |> p_merge([3, 4], preserveKeys: true)
 * //= [0 => 1, 1 => 2, 0 => 3, 1 => 4]
 * ```
 * ```
 * ['a' => 1,'b' => 2]
 * |> p_merge(['b' => 22,'c' => 3], preserveKeys: true)
 * //= ['a' => 1,'b' => 2,'b' => 22,'c' => 3]
 * ```
 *
 * @template K2
 * @template V2
 * @param iterable<K2,V2> $other
 * @return callable<K1,V1>(iterable<K1,V1>):iterable<K1|K2,V1|V2>
 */
function p_merge(iterable $other, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $other): iterable {
            foreach ($iterable as $key => $value) {
                yield $key => $value;
            }
            foreach ($other as $key => $value) {
                yield $key => $value;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $other): iterable {
            foreach ($iterable as $value) {
                yield $value;
            }
            foreach ($other as $value) {
                yield $value;
            }
        });
}
