<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template V
 * @template K
 * @param callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):bool
 */
function p_all(callable $predicate): callable
{
    return static function (iterable $iterable) use ($predicate) {
        if (is_array($iterable)) {
            // @phpstan-ignore argument.type (since the $iterable is an array, $predicate accepts $key of type array-key)
            return array_all($iterable, static fn ($value, $key) => $predicate($value, $key));
        }
        foreach ($iterable as $key => $value) {
            if (!$predicate($value, $key)) {
                return false;
            }
        }
        return true;
    };
}
