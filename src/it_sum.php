<?php

declare(strict_types=1);

namespace Pipes;

if (!function_exists(__NAMESPACE__ . '\it_sum')) {
    /**
     * @no-named-arguments
     *
     * @return callable<K,V of float|int>(iterable<K, V>):V
     */
    function it_sum(): callable
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
}
