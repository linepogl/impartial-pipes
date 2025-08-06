<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @template V
 * @template K
 * @param int $howMany
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):iterable<K,V> : callable(iterable<K,V>):iterable<int,V>)
 */
function it_take(int $howMany, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
            $i = 0;
            foreach ($iterable as $key => $value) {
                if (++$i > $howMany) {
                    break;
                }
                yield $key => $value;
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $howMany): iterable {
            $i = 0;
            foreach ($iterable as $value) {
                if (++$i > $howMany) {
                    break;
                }
                yield $value;
            }
        });
}
