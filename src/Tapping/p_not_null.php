<?php

declare(strict_types=1);

namespace ImpartialPipes;

use TypeError;

/**
 * Returns a partial function that checks if the input is not null.
 *
 * ### Syntax
 * ```
 * p_not_null()
 * ```
 *
 * ### Examples
 *
 * 'test'
 * |> p_not_null()
 * //= 'test'
 *
 * null
 * |> p_not_null()
 * // throws TypeError
 *
 * @return callable<T>(?T):T
 */
function p_not_null(): callable
{
    return static function (mixed $input) {
        if (null === $input) {
            throw new TypeError('Expected a non-null value');
        }
        return $input;
    };
}
