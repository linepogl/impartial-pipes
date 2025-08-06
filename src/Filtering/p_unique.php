<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template V
 * @template K
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
