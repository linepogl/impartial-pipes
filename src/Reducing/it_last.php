<?php

declare(strict_types=1);

namespace Pipes;

use OutOfBoundsException;

/**
 * @template V
 * @template K
 * @param ?callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):V
 */
function it_last(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return $iterable[count($iterable) - 1] ?? throw new OutOfBoundsException('Cannot get last element of empty array');
            } else {
                $found = false;
                $last = null;
                foreach ($iterable as $key => $value) {
                    $found = true;
                    $last = $value;
                }
                if (!$found) {
                    throw new OutOfBoundsException('Cannot get last element of empty iterable');
                }
                return $last;
            }
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
