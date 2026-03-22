<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Ds\Hashable;

/**
 * Returns a partial function that skips elements with repeated keys of an iterable, based on an optional hashing projection.
 * If no hashing projection is provided, an identity projection is used. In that case, the elements must be hashable.
 *
 * ### Syntax
 * ```
 * p_unique_keys(
 *   [callable(TKey $key]): array-key,]
 * )
 * ```
 *
 * ### Examples
 * Unique keys, based on the identity projection
 * ```
 * ['a1', 'b1', 'a2', 'b2']
 * |> p_map_keys(fn(string $x) => $x[0]) //= iterable{'a' => 'a1', 'b' => 'b1', 'a' => 'a2', 'b' => 'b2'}
 * |> p_unique_keys()
 * //= ['a1', 'b1']
 * ```
 * Unique keys, based on some projection on keys
 * ```
 * ['a1', 'b1', 'a2', 'b2']
 * |> p_map_keys(fn(string $x) => $x) //= iterable{'a1' => 'a1', 'b1' => 'b1', 'a2' => 'a2', 'b2' => 'b2'}
 * |> p_unique_keys(fn(string $k) => $k[1])
 * //= ['a1', 'a2']
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(K):mixed $hasher
 * @return ($hasher is null ? callable<K2,V2>(iterable<K2,V2>):iterable<K2,V2> : callable(iterable<K,V>):iterable<K,V>)
 */
function p_unique_keys(?callable $hasher = null): callable
{
    $hasher ??= static fn ($key) => $key;
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
        $seen = [];
        foreach ($iterable as $key => $value) {
            $hash = as_array_key($hasher($key));
            if (!array_key_exists($hash, $seen)) {
                $seen[$hash] = true;
                yield $value;
            }
        }
    });
}

/**
 * Returns a partial function that skips elements with repeated keys of an iterable, based on an optional hashing projection, preserving the keys.
 * If no hashing projection is provided, an identity projection is used. In that case, the elements must be hashable.
 *
 * ### Syntax
 * ```
 * p_assoc_unique_keys(
 *   [callable(TKey $key]): array-key,]
 * )
 * ```
 *
 * ### Examples
 * Unique keys, based on the identity projection
 * ```
 * ['a1', 'b1', 'a2', 'b2']
 * |> p_map_keys(fn(string $x) => $x[0]) //= iterable{'a' => 'a1', 'b' => 'b1', 'a' => 'a2', 'b' => 'b2'}
 * |> p_assoc_unique_keys()
 * //= ['a' => 'a1', 'b' => 'b1']
 * ```
 * Unique keys, based on some projection on keys
 * ```
 * ['a1', 'b1', 'a2', 'b2']
 * |> p_map_keys(fn(string $x) => $x) //= iterable{'a1' => 'a1', 'b1' => 'b1', 'a2' => 'a2', 'b2' => 'b2'}
 * |> p_assoc_unique_keys(fn(string $k) => $k[1])
 * //= ['a1' => 'a1', 'a2' => 'a2']
 * ```
 *
 * @template K
 * @param ?callable(K):mixed $hasher
 * @return ($hasher is null ? callable<K2,V2>(iterable<K2,V2>):iterable<K2,V2> : callable<V>(iterable<K,V>):iterable<K,V>)
 */
function p_assoc_unique_keys(?callable $hasher = null): callable
{
    $hasher ??= static fn ($key) => $key;
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
        $seen = [];
        foreach ($iterable as $key => $value) {
            $hash = as_array_key($hasher($key));
            if (!array_key_exists($hash, $seen)) {
                $seen[$hash] = true;
                yield $key => $value;
            }
        }
    });
}
