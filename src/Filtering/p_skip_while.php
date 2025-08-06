<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template V
 * @template K
 * @param callable(V,K):bool $predicate
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function p_skip_while(callable $predicate, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            $skipping = true;
            foreach ($iterable as $key => $value) {
                if ($skipping) {
                    if ($predicate($value, $key)) {
                        continue;
                    }
                    $skipping = false;

                }
                yield $key => $value;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $predicate): iterable {
            $skipping = true;
            foreach ($iterable as $key => $value) {
                if ($skipping) {
                    if ($predicate($value, $key)) {
                        continue;
                    }
                    $skipping = false;

                }
                yield $value;
            }
        });
}
