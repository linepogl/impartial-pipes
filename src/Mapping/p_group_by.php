<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Ds\Hashable;

/**
 * Returns a partial function that maps an iterable into groups of iterables, using a projection.
 *
 * ### Syntax
 *
 * ```
 * p_group_by(
 *   callable(TValue[, TKey]): TNewKey of array-key,
 *   [preserveKeys: bool = false,]
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
 * @template G of array-key|Hashable
 * @param callable(V,K):G $hasher
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<G,iterable<K,V>> : callable(iterable<K,V>):iterable<G,iterable<int,V>>)
 */
function p_group_by(callable $hasher, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
            $k = [];
            $v = [];
            $hashables = [];
            foreach ($iterable as $key => $value) {
                $hashable = $hasher($value, $key);
                $hash = $hashable instanceof Hashable ? strval($hashable->hash()) : $hashable;
                $hashables[$hash] ??= $hashable;
                $k[$hash] ??= [];
                $k[$hash][] = $key;
                $v[$hash] ??= [];
                $v[$hash][] = $value;
            }
            foreach ($hashables as $hash => $hashable) {
                $kk = $k[$hash];
                $vv = $v[$hash];
                yield $hashable => new LazyRewindableIterator(static function () use ($kk, $vv): iterable {
                    $length = count($kk);
                    for ($i = 0; $i < $length; $i++) {
                        yield $kk[$i] => $vv[$i];
                    }
                });
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
            $v = [];
            $hashables = [];
            foreach ($iterable as $key => $value) {
                $hashable = $hasher($value, $key);
                $hash = $hashable instanceof Hashable ? strval($hashable->hash()) : $hashable;
                $hashables[$hash] ??= $hashable;
                $v[$hash] ??= [];
                $v[$hash][] = $value;
            }
            foreach ($hashables as $hash => $hashable) {
                yield $hashable => $v[$hash];
            }
        });
}
