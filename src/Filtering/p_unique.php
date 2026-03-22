<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that gets the unique elements of an iterable, based on an optional hashing projection.
 * If no hashing projection is provided, an identity projection is used. In that case, the elements must be hashable or stringable.
 *
 * ### Syntax
 * ```
 * p_unique(
 *   [callable(TValue $value[, TKey $key]): Hashable|array-key,]
 * )
 * ```
 *
 * ### Examples
 * Unique elements, based on the identity projection
 * ```
 * [1, 2, 1, 3]
 * |> p_unique()
 * //= [1, 2, 3]
 * ```
 * Unique elements, based on some projection on values
 * ```
 * [1, 3, 5, 8]
 * |> p_unique(static fn (int $x) => $x % 2)
 * //= [1, 8]
 * ```
 * Unique elements, based on some projection on values and keys
 * ```
 * ['a' => 1, 'b' => 2, 'cc' => 3, 'ddd' => 4]
 * |> p_unique(static fn (int $x, string $k) => strlen($k))
 * //= [1, 3, 4]
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):mixed $hasher
 * @return ($hasher is null ? callable<K2,V2>(iterable<K2,V2>):iterable<int,V2> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_unique(?callable $hasher = null): callable
{
    $hasher ??= static fn ($value) => $value;
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
        $seen = [];
        foreach ($iterable as $key => $value) {
            $hash = as_array_key($hasher($value, $key));
            if (!array_key_exists($hash, $seen)) {
                $seen[$hash] = true;
                yield $value;
            }
        }
    });
}

/**
 * Returns a partial function that gets the unique elements of an iterable, based on an optional hashing projection, preserving the keys.
 * If no hashing projection is provided, an identity projection is used. In that case, the elements must be hashable.
 *
 * ### Syntax
 * ```
 * p_assoc_unique(
 *   [callable(TValue $value[, TKey $key]): Hashable|array-key,]
 * )
 * ```
 *
 * ### Examples
 * Unique elements, based on the identity projection
 * ```
 * [1, 2, 1, 3]
 * |> p_assoc_unique()
 * //= [0 => 1, 1 => 2, 3 => 3]
 * ```
 * Unique elements, based on some projection on values
 * ```
 * [1, 3, 5, 8]
 * |> p_assoc_unique(static fn (int $x) => $x % 2)
 * * //= [0 => 1, 3 => 8]
 * ```
 * Unique elements, based on some projection on values and keys
 * ```
 * ['a' => 1, 'b' => 2, 'cc' => 3, 'ddd' => 4]
 * |> p_assoc_unique(static fn (int $x, string $k) => strlen($k))
 * //= ['a' => 1, 'cc' => 3, 'ddd' => 4]
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):mixed $hasher
 * @return ($hasher is null ? callable<K2,V2>(iterable<K2,V2>):iterable<K2,V2> : callable(iterable<K,V>):iterable<K,V>)
 */
function p_assoc_unique(?callable $hasher = null): callable
{
    $hasher ??= static fn ($value) => $value;
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
        $seen = [];
        foreach ($iterable as $key => $value) {
            $hash = as_array_key($hasher($value, $key));
            if (!array_key_exists($hash, $seen)) {
                $seen[$hash] = true;
                yield $key => $value;
            }
        }
    });
}
