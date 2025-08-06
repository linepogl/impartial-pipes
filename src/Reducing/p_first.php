<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * @template V
 * @template K
 * @param ?callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):V
 */
function p_first(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return $iterable[0] ?? throw new OutOfBoundsException('Cannot get first element of empty array');
            } else {
                foreach ($iterable as $value) {
                    return $value;
                }
                throw new OutOfBoundsException('Cannot get first element of empty iterable');
            }
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
