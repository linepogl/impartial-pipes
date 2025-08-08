<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):?V2 : callable(iterable<K,V>):?V)
 */
function p_last_or_null(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                $lastKey = array_key_last($iterable);
                if (null === $lastKey) {
                    return null;
                }
                return $iterable[$lastKey];
            }
            $last = null;
            foreach ($iterable as $key => $value) {
                $last = $value;
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
            return null;
        }
        $last = null;
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                $last = $value;
            }
        }
        return $last;

    };
}
