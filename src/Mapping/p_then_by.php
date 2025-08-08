<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function that can be chained to `p_order_by`, to provide tie-breakers. Multiple `p_then_by` calls
 * can be chained to provide multiple tie-breakers.
 *
 * It works in the same way as `p_order_by`, using a projection for comparisons. The projection
 * must return a comparable value, that is any value that can be compared with the `<=>` operator.
 *
 * Key preservation is defined on the p_order_by function and propagated to the entire chain.
 *
 * ### Syntax
 *
 * ```
 * p_then_by(
 *   callable(TValue[, TKey]): TComparable
 *   [, descending: bool = false]
 * )
 * ```
 *
 * ### Examples
 * Order by ... then by a value projection
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'])
 * |> p_then_by(static fn (array $person) => $person['name'])
 * //= [
 * //    ['name' => 'Alice', 'age' => 30],
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'alice' => ['name' => 'Alice', 'age' => 30],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], preserveKeys: true)
 * |> p_then_by(static fn (array $person) => $person['name'])
 * //= [
 * //    'alice' => ['name' => 'Alice', 'age' => 30],
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'])
 * |> p_then_by(static fn (array $person) => $person['name'], descending: true)
 * //= [
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Alice', 'age' => 30],
 * //    ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], preserveKeys: true)
 * |> p_then_by(static fn (array $person) => $person['name'], descending: true)
 * //= [
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'alice' => ['name' => 'Alice', 'age' => 30],
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * Order by ... then by a value and key projection
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'])
 * |> p_then_by(static fn (array $person, string $key) => $key)
 * //= [
 * //    ['name' => 'Alice', 'age' => 30],
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], preserveKeys: true)
 * |> p_then_by(static fn (array $person, string $key) => $key)
 * //= [
 * //    'alice' => ['name' => 'Alice', 'age' => 30],
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'])
 * |> p_then_by(static fn (array $person, string $key) => $key, descending: true)
 * //= [
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Alice', 'age' => 30],
 * //    ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'alice' => ['name' => 'Alice', 'age' => 30],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], preserveKeys: true)
 * |> p_then_by(static fn (array $person, string $key) => $key, descending: true)
 * //= [
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'alice' => ['name' => 'Alice', 'age' => 30],
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //  ]
 *
 * @template K
 * @template V
 * @template TComparable
 * @param callable(V,K):TComparable $hasher
 * @param bool $descending
 * @return callable<K2,V2>(AssociativeOrderedIterator<K2,V2>|ListOrderedIterator<K2,V2>):(AssociativeOrderedIterator<K2,V2>|ListOrderedIterator<K2,V2>)
 */
function p_then_by(callable $hasher, bool $descending = false): callable
{
    // @phpstan-ignore return.type (Closure is a callable)
    return static fn (AssociativeOrderedIterator|ListOrderedIterator $iterable) =>
        // @phpstan-ignore argument.type ($iterable is in fact a XxxOrderedIterator<K,V>) */
        $iterable->thenBy($hasher, $descending);
}
