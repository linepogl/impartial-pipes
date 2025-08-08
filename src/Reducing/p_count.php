<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Countable;

/**
 * @template K
 * @template V
 * @param ?callable(V,K):bool $predicate
 *
 * @return ($predicate is null ? callable<KK,VV>(iterable<KK, VV>|Countable):int<0,max> : callable(iterable<K, V>):int<0,max>)
 */
function p_count(?callable $predicate = null): callable
{
    return null === $predicate
        ? static function (iterable|Countable $input) {
            return $input instanceof Countable
                ? $input->count()
                : iterable_count($input);
        }
    : static function (iterable $iterable) use ($predicate) {
        $count = 0;
        foreach ($iterable as $key => $value) {
            if ($predicate($value, $key)) {
                $count++;
            }
        }
        return $count;
    };
}
