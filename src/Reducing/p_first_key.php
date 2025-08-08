<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):K2 : callable(iterable<K,V>):K)
 */
function p_first_key(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return array_key_first($iterable) ?? throw new OutOfBoundsException('Cannot get first key of an empty iterable');
            } else {
                foreach ($iterable as $key => $value) {
                    return $key;
                }
                throw new OutOfBoundsException('Cannot get first key of an empty iterable');
            }
        }
    : static function (iterable $iterable) use ($predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $key;
            }
        }
        throw new OutOfBoundsException('Key not found');
    };
}
