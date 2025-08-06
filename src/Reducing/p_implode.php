<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Stringable;

/**
 * @return callable<K,V of null|scalar|Stringable>(iterable<K, V>):string
 */
function p_implode(string $separator = ''): callable
{
    return static function (iterable $iterable) use ($separator): string {
        $sum = '';
        if ('' === $separator) {
            /** @var null|scalar|Stringable $value */
            foreach ($iterable as $value) {
                $sum .= $value;
            }
        } else {
            /** @var null|scalar|Stringable $value */
            foreach ($iterable as $value) {
                if ('' === $sum) {
                    $sum .= $value;
                } else {
                    $sum .= $separator . $value;
                }
            }
        }
        return $sum;
    };
}
