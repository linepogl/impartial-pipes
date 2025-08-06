<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @param callable<V,K>(V, K):mixed $callable
 * @return callable<V,K>(iterable<K, V>):void
 */
function it_foreach(callable $callable): callable
{
    return static function (iterable $iterable) use ($callable): void {
        foreach ($iterable as $key => $value) {
            $callable($value, $key);
        }
    };
}
