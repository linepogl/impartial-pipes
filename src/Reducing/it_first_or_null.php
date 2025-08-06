<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @template V
 * @template K
 * @param ?callable(V,K):bool $predicate
 * @return callable(iterable<K,V>):?V
 */
function it_first_or_null(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable $iterable) {
            if (is_array($iterable)) {
                return $iterable[0] ?? null;
            }
            foreach ($iterable as $value) {
                return $value;
            }
            return null;

        }
    : static function (iterable $iterable) use ($predicate) {
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                return $value;
            }
        }
        return null;
    };
}
