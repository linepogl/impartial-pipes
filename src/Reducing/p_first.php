<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * TODO: docs
 *
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):V2 : callable(iterable<K,V>):V)
 */
function p_first(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                $firstKey = array_key_first($iterable);
                if (null === $firstKey) {
                    throw new OutOfBoundsException('Cannot get first element of an empty iterable');
                }
                return $iterable[$firstKey];
            }
            foreach ($iterable as $value) {
                return $value;
            }
            throw new OutOfBoundsException('Cannot get first element of an empty iterable');

        }
    : static function (iterable $iterable) use ($predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $value;
            }
        }
        throw new OutOfBoundsException('Element not found');
    };
}
