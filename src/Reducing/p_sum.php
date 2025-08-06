<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @return callable<K,V of float|int>(iterable<K, V>):V
 */
function p_sum(): callable
{
    return static function (iterable $iterable) {
        $sum = 0;
        /** @var float|int $value */
        foreach ($iterable as $value) {
            $sum += $value;
        }
        return $sum;
    };
}
