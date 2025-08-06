<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @return callable<K of array-key,V of float|int>(iterable<K, V>):array<K,V>
 */
function it_to_array(): callable
{
    // @phpstan-ignore return.type (iterator_to_array has an incomplete signature)
    return static fn (iterable $iterable) => iterator_to_array($iterable, preserve_keys: true);
}
