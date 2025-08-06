<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template K of array-key Ordering is done with php arrays, so it works only with array-keys
 * @template V
 * @template TComparable
 * @param callable(V,K):TComparable $valueProjection
 * @param bool $descending
 * @return callable(iterable<K,V>):OrderedIterator<K,V>
 */
function p_order_by(callable $valueProjection, bool $descending = false): callable
{
    // @phpstan-ignore return.type, argument.type, argument.type
    return static fn (iterable $iterable): iterable => new OrderedIterator($iterable, $valueProjection, $descending);
}

/**
 * @template K of array-key
 * @template V
 * @template TComparable
 * @param callable(V,K):TComparable $valueProjection
 * @param bool $descenting
 * @return callable(OrderedIterator<K,V>):OrderedIterator<K,V>
 */
function p_then_by(callable $valueProjection, bool $descenting = false): callable
{
    // @phpstan-ignore return.type, argument.type
    return static fn (OrderedIterator $iterable): OrderedIterator => $iterable->thenBy($valueProjection, $descenting);
}
