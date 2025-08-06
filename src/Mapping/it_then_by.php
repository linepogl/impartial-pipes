<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @template K of array-key
 * @template V
 * @template TComparable
 * @param callable(V,K):TComparable $valueProjection
 * @param bool $descenting
 * @return callable(OrderedIterator<K,V>):OrderedIterator<K,V>
 */
function it_then_by(callable $valueProjection, bool $descenting = false): callable
{
    // @phpstan-ignore return.type, argument.type
    return static fn (OrderedIterator $iterable): OrderedIterator => $iterable->thenBy($valueProjection, $descenting);
}
