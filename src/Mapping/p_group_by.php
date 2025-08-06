<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
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
