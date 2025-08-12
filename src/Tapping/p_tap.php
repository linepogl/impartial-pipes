<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function applies a function to an input and returns the input.
 *
 * ### Syntax:
 * ```
 * p_tap(
 *     callable $callable
 * )
 * ```
 *
 * ### Examples:
 * ```
 * $user = ['name' => 'John', 'age' => 30];
 * $user
 * |> p_tap(fn($user) => print_r($user))
 * //= ['name' => 'John', 'age' => 30]
 * ```
 *
 * @template T
 * @param callable(T):mixed $callable
 * @return callable(T):T
 */
function p_tap(callable $callable): callable
{
    return static function (mixed $input) use ($callable) {
        $callable($input);
        return $input;
    };
}
