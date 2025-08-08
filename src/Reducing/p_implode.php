<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;
use Stringable;

/**
 * Partial function to get a concatenation string of all the elements, all of which must be stringable.
 *
 * ### Syntax
 * ```
 * p_implode(
 *   [separator: string = '']
 * )
 * ```
 *
 * ### Examples
 * Implode without a separator
 * ```
 * []
 * |> p_implode()
 * //= ''
 * ```
 * ```
 * [1, null, 'test', 2.5]
 * |> p_implode()
 * //= '1test2.5'
 * ```
 * Implode with a separator
 * ```
 * []
 * |> p_implode('-')
 * //= ''
 * ```
 * ```
 * [1, null, 'test', 2.5]
 * |> p_implode('-')
 * //= '1--test-2.5'
 * ```
 *
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
