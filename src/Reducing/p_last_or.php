<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * TODO: docs
 *
 * @template K
 * @template V
 * @template D
 * @param D $default
 * @param ?callable(V,K):bool $predicate
 * @return ($predicate is null ? callable<K2,V2>(iterable<K2,V2>):(V2|D) : callable(iterable<K,V>):(V|D))
 */
function p_last_or(mixed $default, ?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) use ($default) {
            if (is_array($iterable)) {
                $lastKey = array_key_last($iterable);
                if (null === $lastKey) {
                    return $default;
                }
                return $iterable[$lastKey];
            }
            $last = $default;
            foreach ($iterable as $value) {
                $last = $value;
            }
            return $last;
        }
    : static function (iterable $iterable) use ($default, $predicate) {
        if (is_array($iterable)) {
            for ($value = end($iterable); null !== ($key = key($iterable)); $value = prev($iterable)) {
                // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
                if ($predicate($value, $key)) {
                    return $value;
                }
            }
            return $default;
        }
        $last = $default;
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                $last = $value;
            }
        }
        return $last;
    };
}
