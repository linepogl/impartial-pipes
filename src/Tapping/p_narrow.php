<?php

declare(strict_types=1);

namespace ImpartialPipes;

use TypeError;

/**
 * Returns a partial function that checks if the input is an instance of the specified class.
 *
 * ### Syntax
 * ```
 * p_narrow(
 *   class-string
 * )
 * ```
 *
 * ### Examples
 *
 * ```
 * new DateTime()
 * |> p_narrow(DateTime::class)
 * //= new DateTime()
 * ```
 * ```
 * new DateTime()
 * |> p_narrow(DateInterval::class)
 * // throws TypeError
 * ```
 *
 * @template T
 * @param class-string<T> $class
 * @return callable(mixed):T
 */
function p_narrow(string $class): callable
{
    return static function (mixed $input) use ($class) {
        if (!is_object($input) || !is_a($input, $class)) {
            throw new TypeError(sprintf('Expected an instance of %s, got %s', $class, get_debug_type($input)));
        }
        return $input;
    };
}
