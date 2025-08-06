<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable<K,V>(iterable<K,V>):iterable<K,V> : callable<K,V>(iterable<K,V>):iterable<int,V>)
 */
function p_compact(bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
            foreach ($iterable as $key => $value) {
                if (null !== $value) {
                    yield $key => $value;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
            foreach ($iterable as $key => $value) {
                if (null !== $value) {
                    yield $value;
                }
            }
        });
}
