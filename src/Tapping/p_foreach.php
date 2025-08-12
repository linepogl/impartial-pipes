<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that applies a function to all the elements of an iterable
 *
 * ### Syntax
 * ```
 * p_foreach(
 *   callable(TValue[, TKey]): mixed,
 * )
 * ```
 *
 * ### Examples
 * foreach value
 * ```
 * [1, 2, 3]
 * |> p_foreach(function (int $value) { echo $value . PHP_EOL; }
 * //= [1, 2, 3]
 * // 1
 * // 2
 * // 3
 * ```
 * foreach value and key
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_foreach(function (int $value, string $key) { echo $key . ': ' . $value . PHP_EOL; }
 * //= ['a' => 1, 'b' => 2, 'c' => 3]
 * // a: 1
 * // b: 2
 * // c: 3
 * ```
 *
 * @param callable<V,K>(V, K):mixed $callable
 * @return callable<V,K>(iterable<K, V>):iterable<K, V>
 */
function p_foreach(callable $callable): callable
{
    return static function (iterable $iterable) use ($callable) {
        foreach ($iterable as $key => $value) {
            $callable($value, $key);
        }
        return $iterable;
    };
}
