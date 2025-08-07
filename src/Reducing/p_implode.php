<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;
use Stringable;

/**
 * @return callable<K,V of null|scalar|Stringable>(iterable<K, V>):string
 */
function p_implode(string $separator = ''): callable
{
    return static function (iterable $iterable) use ($separator): string {
        if (is_array($iterable)) {
            return implode($separator, $iterable);
        } elseif ($iterable instanceof ArrayIterator) {
            return implode($separator, $iterable->getArrayCopy()); // get array copy is a 0(1) operation that does not copy the array immediately!
        }

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
