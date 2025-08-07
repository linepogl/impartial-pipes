<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Countable;

/**
 * @return callable<K,V>(iterable<K, V>):int
 */
function p_count(): callable
{
    return static function (iterable $iterable) {
        return match (true) {
            is_array($iterable) => count($iterable),
            $iterable instanceof Countable => $iterable->count(),
            default => iterator_count($iterable),
        };
    };
}
