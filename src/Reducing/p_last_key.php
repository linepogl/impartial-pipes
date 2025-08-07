<?php

declare(strict_types=1);

namespace ImpartialPipes;

use OutOfBoundsException;

/**
 * @template V
 * @template K
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):V2 : callable(iterable<K,V>):V)
 */
function p_last_key(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return array_key_last($iterable) ?? throw new OutOfBoundsException('Cannot get last element of an empty iterable');
            } else {
                $found = false;
                $lastKey = null;
                foreach ($iterable as $key => $value) {
                    $found = true;
                    $lastKey = $key;
                }
                if (!$found) {
                    throw new OutOfBoundsException('Cannot get last element of an empty iterable');
                }
                return $lastKey;
            }
        }
    : static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            for ($value = end($iterable); null !== ($key = key($iterable)); $value = prev($iterable)) {
                // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
                if ($predicate($value, $key)) {
                    return $key;
                }
            }
            throw new OutOfBoundsException('Key not found');
        } else {
            $found = false;
            $lastKey = null;
            foreach ($iterable as $key => $value) {
                if ($predicate($value, $key)) {
                    $found = true;
                    $lastKey = $key;
                }
            }
            if (!$found) {
                throw new OutOfBoundsException('Key not found');
            }
            return $lastKey;
        }
    };
}
