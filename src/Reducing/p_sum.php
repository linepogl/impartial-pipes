<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;

/**
 * Returns a partial function that sums all the elements of an iterable.
 *
 * The elements must be ints or floats.
 *
 * ### Syntax
 * ```
 * p_sum()
 * ```
 *
 * ### Examples
 * ```
 * []
 * |> p_sum()
 * //= 0
 * ```
 * ```
 * [1, 2.5]
 * |> p_sum()
 * //= 3.5
 * ```
 *
 * @return callable<K,V of float|int>(iterable<K, V>):V
 */
function p_sum(): callable
{
    return static function (iterable $iterable) {
        if (is_array($iterable)) {
            return array_sum($iterable);
        } elseif ($iterable instanceof ArrayIterator) {
            return array_sum($iterable->getArrayCopy()); // get array copy is a 0(1) operation that does not copy the array immediately!
        }

        $sum = 0;
        /** @var float|int $value */
        foreach ($iterable as $value) {
            $sum += $value;
        }
        return $sum;
    };
}
