<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):V2 : callable(iterable<K,V>):V)
 */
function p_last(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                $lastKey = array_key_last($iterable);
                if (null === $lastKey) {
                    throw new OutOfBoundsException('Cannot get last element of an empty iterable');
                }
                return $iterable[$lastKey];
            }
            $found = false;
            $last = null;
            foreach ($iterable as $value) {
                $found = true;
                $last = $value;
            }
            if (!$found) {
                throw new OutOfBoundsException('Cannot get last element of an empty iterable');
            }
            return $last;

        }
    : static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            for ($value = end($iterable); null !== ($key = key($iterable)); $value = prev($iterable)) {
                // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
                if ($predicate($value, $key)) {
                    return $value;
                }
            }
            throw new OutOfBoundsException('Element not found');
        } else {
            $found = false;
            $last = null;
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    $found = true;
                    $last = $value;
                }
            }
            if (!$found) {
                throw new OutOfBoundsException('Element not found');
            }
            return $last;
        }
    };
}
