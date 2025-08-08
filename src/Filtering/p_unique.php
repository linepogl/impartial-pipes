<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to get the unique elements of an iterable, based on a optional hashing projection.
 * If no hashing projection is provided, an identity projection is used. In that case, the elements must be stringable.
 *
 * ### Syntax
 * ```
 * p_unique(
 *   [callable(TValue $value[, TKey $key]): array-key,]
 *   [preserveKeys: bool = false,]
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
 * ```
 * [1, 2, 1, 3]
 * |> p_unique(preserveKeys: true)
 * //= [0 => 1, 1 => 2, 3 => 3]
 * ```
 * Unique elements, based on some projection on values
 * ```
 * [1, 3, 5, 8]
 * |> p_unique(static fn (int $x) => $x % 2)
 * //= [1, 8]
 * ```
 * ```
 * [1, 3, 5, 8]
 * |> p_unique(static fn (int $x) => $x % 2, preserveKeys: true)
 * * //= [0 => 1, 3 => 8]
 * ```
 * Unique elements, based on some projection on values and keys
 * ```
 * ['a' => 1, 'b' => 2, 'cc' => 3, 'ddd' => 4]
 * |> p_unique(static fn (int $x, string $k) => strlen($k))
 * //= [1, 3, 4]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'cc' => 3, 'ddd' => 4]
 * |> p_unique(static fn (int $x, string $k) => strlen($k), preserveKeys: true)
 * //= ['a' => 1, 'cc' => 3, 'ddd' => 4]
 * ```
 *
 * @template K
 * @template V
 * @param ?callable(V,K):array-key $hasher
 * @param bool $preserveKeys
 * @return ($hasher is null
 *    ? ($preserveKeys is true ? callable<K2,V2>(iterable<K2,V2>):iterable<K2,V2> : callable<K2,V2>(iterable<K2,V2>):iterable<int,V2>)
 *    : ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 * )
 */
function p_unique(?callable $hasher = null, bool $preserveKeys = false): callable
{
    $hasher ??= static fn ($value) => $value;
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
            $seen = [];
            foreach ($iterable as $key => $value) {
                $hash = $hasher($value, $key);
                if (!array_key_exists($hash, $seen)) {
                    $seen[$hash] = true;
                    yield $key => $value;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $hasher): iterable {
            $seen = [];
            foreach ($iterable as $key => $value) {
                $hash = $hasher($value, $key);
                if (!array_key_exists($hash, $seen)) {
                    $seen[$hash] = true;
                    yield $value;
                }
            }
        });
}
