<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to map the an iterable into groups of iterables, using a projection.
 *
 * ### Syntax
 *
 * ```
 * p_group_by(
 *   callable(TValue[, TKey]): array-key
 *   [, preserveKeys: bool = false]
 * )
 * ```
 *
 * ### Examples
 * Group with a value projection
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_group_by(static fn (int $value) => $value % 2)
 * //= [
 * //    1 => [1, 3],
 * //    0 => [2, 4]
 * //  ]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
 * |> p_group_by(static fn (int $value) => $value % 2, preserveKeys: true)
 * //= [
 * //    1 => ['a' => 1, 'c' => 3],
 * //    0 => ['b' => 2, 'd' => 4]
 * //  ]
 * ```
 * Group with a value and key projection
 * ```
 * ['a' => 1, 'bb' => 2, 'c' => 3, 'dd' => 4]
 * |> p_group_by(static fn (int $value, string $key) => strlen($key))
 * //= [
 * //    1 => [1, 3],
 * //    2 => [2, 4]
 * //  ]
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'c' => 3, 'dd' => 4]
 * * |> p_group_by(static fn (int $value, string $key) => strlen($key), preserveKeys: true)
 * //= [
 * //    1 => ['a' => 1, 'c' => 3],
 * //    2 => ['b' => 2, 'd' => 4]
 * //  ]
 * ```
 *
 * @template K
 * @template V
 * @param callable(V,K):array-key $hasher
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<array-key,iterable<K,V>> : callable(iterable<K,V>):iterable<array-key,list<V>>)
 */
function p_group_by(callable $hasher, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
            $a = [];
            foreach ($iterable as $key => $value) {
                $groupKey = $hasher($value, $key);
                $a[$groupKey] ??= [];
                $a[$groupKey][$key] = $value;
            }
            foreach ($a as $groupKey => $groupValues) {
                yield $groupKey => $groupValues;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
            $a = [];
            foreach ($iterable as $key => $value) {
                $groupKey = $hasher($value, $key);
                $a[$groupKey] ??= [];
                $a[$groupKey][] = $value;
            }
            foreach ($a as $groupKey => $groupValues) {
                yield $groupKey => $groupValues;
            }
        });
}
