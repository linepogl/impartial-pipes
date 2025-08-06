<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @template K2
 * @template V2
 * @param iterable<K2,V2> $other
 * @return callable<K1,V1>(iterable<K1,V1>):iterable<K1|K2,V1|V2>
 */
function it_union(iterable $other, bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $other): iterable {
            $seen = [];
            foreach ($iterable as $key => $value) {
                if (!array_key_exists($key, $seen)) { // @phpstan-ignore argument.type (assume that K1 is string|int)
                    $seen[$key] = true;
                    yield $key => $value;
                }
            }
            foreach ($other as $key => $value) {
                if (!array_key_exists($key, $seen)) { // @phpstan-ignore argument.type (assume that K2 is string|int)
                    $seen[$key] = true;
                    yield $key => $value;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $other): iterable {
            foreach ($iterable as $value) {
                yield $value;
            }
            foreach ($other as $value) {
                yield $value;
            }
        });
}
