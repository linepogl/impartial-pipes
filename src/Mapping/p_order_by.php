<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to order an iterable using a projection for comparisons. The projection must return
 * a comparable value, that is any value that can be compared with the `<=>` operator.
 *
 * ### Syntax
 *
 * ```
 * p_order_by(
 *   callable(TValue[, TKey]): TComparable
 *   [, descending: bool = false]
 *   [, preserveKeys: bool = false]
 * )
 * ```
 *
 * ### Examples
 * Order by a value projection
 * ```
 * [
 *   'john' => ['name'=> 'John', 'age' => 30],
 *   'jane' => ['name' => 'Jane', 'age' => 25],
 *   'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'])
 * //= [
 * //    ['name' => 'Jane', 'age' => 25],
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], preserveKeys: true)
 * //= [
 * //    'jane' => ['name' => 'Jane', 'age' => 25],
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], descending: true)
 * //= [
 * //    ['name' => 'Bob', 'age' => 40],
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Jane', 'age' => 25],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person) => $person['age'], descending: true, preserveKeys: true)
 * //= [
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'jane' => ['name' => 'Jane', 'age' => 25],
 * //  ]
 * ```
 * Order by a value and key projection
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person, string $key) => $key)
 * //= [
 * //    ['name' => 'Bob', 'age' => 40],
 * //    ['name' => 'Jane', 'age' => 25],
 * //    ['name' => 'John', 'age' => 30],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person, string $key) => $key, preserveKeys: true)
 * //= [
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //    'jane' => ['name' => 'Jane', 'age' => 25],
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person, string $key) => $key, descending: true)
 * //= [
 * //    ['name' => 'John', 'age' => 30],
 * //    ['name' => 'Jane', 'age' => 25],
 * //    ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 * ```
 * [
 * 'john' => ['name'=> 'John', 'age' => 30],
 * 'jane' => ['name' => 'Jane', 'age' => 25],
 * 'bob' => ['name' => 'Bob', 'age' => 40]],
 * ]
 * |> p_order_by(static fn (array $person, string $key) => $key, descending: true, preserveKeys: true)
 * //= [
 * //    'john' => ['name' => 'John', 'age' => 30],
 * //    'jane' => ['name' => 'Jane', 'age' => 25],
 * //    'bob' => ['name' => 'Bob', 'age' => 40],
 * //  ]
 * ```
 *
 *
 * @template K
 * @template V
 * @template TComparable
 * @param callable(V,K):TComparable $hasher
 * @param bool $descending
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable(iterable<K,V>):AssociativeOrderedIterator<K,V> : callable(iterable<K,V>):ListOrderedIterator<K,V>)
 */
function p_order_by(callable $hasher, bool $descending = false, bool $preserveKeys = false): callable
{
    // @phpstan-ignore return.type (Closure is a callable)
    return $preserveKeys
        // @phpstan-ignore argument.type ($iterable is in fact iterable<K, V>)
        ? static fn (iterable $iterable): iterable => new AssociativeOrderedIterator($iterable, $hasher, $descending)
        // @phpstan-ignore argument.type ($iterable is in fact iterable<K, V>)
        : static fn (iterable $iterable): iterable => new ListOrderedIterator($iterable, $hasher, $descending)
    ;
}

/**
 * @internal
 * @template K
 * @template V
 */
trait OrderedIteratorUtils
{
    /**
     * @var array<(callable(array<array{V,K}>&):void)> $sorters
     */
    protected readonly array $sorters;

    /**
     * @template TComparable
     * @param callable(V, K): TComparable $hasher
     * @param bool $descending
     * @return callable(array<array{V,K}>&):void
     */
    private static function createSorter(callable $hasher, bool $descending): callable
    {
        return static function (array &$a) use ($hasher, $descending) {
            usort(
                $a,
                // @phpstan-ignore argument.type (Closure is a callable)
                $descending
                    ? static fn (array $x1, array $x2) => $hasher(...$x2) <=> $hasher(...$x1)
                    : static fn (array $x1, array $x2) => $hasher(...$x1) <=> $hasher(...$x2),
            );
        };
    }

    /**
     * @param iterable<K,V> $iterable
     * @param array<(callable(array<array{V,K}>&):void)> $sorters
     */
    private static function createLazy(iterable $iterable, array $sorters, bool $preserveKeys): callable
    {
        return static function () use ($iterable, $sorters, $preserveKeys): iterable {
            $a = [];
            foreach ($iterable as $key => $value) {
                $a[] = [$value, $key];
            }
            foreach ($sorters as $sorter) {
                $sorter($a);
                /** @var array<array{V,K}> $a -- stating that the sorter won't change the type of the passed-by-ref argument */
            }
            if ($preserveKeys) {
                foreach ($a as [$value, $key]) {
                    yield $key => $value;
                }
            } else {
                foreach ($a as [$value]) {
                    yield $value;
                }
            }
        };
    }
}

/**
 * @internal
 * @template K
 * @template V
 * @extends LazyRewindableIterator<K,V>
 */
final class AssociativeOrderedIterator extends LazyRewindableIterator
{
    /** @use OrderedIteratorUtils<K,V> */
    use OrderedIteratorUtils;

    /**
     * @template TComparable
     * @param iterable<K,V> $inner
     * @param callable(V, K): TComparable $hasher
     * @param bool $descending
     * @param array<(callable(array<array{V,K}>&):void)> $otherSorters
     */
    final public function __construct(
        protected readonly iterable $inner,
        callable $hasher,
        bool $descending = false,
        array $otherSorters = [],
    ) {
        $this->sorters = [self::createSorter($hasher, $descending), ...$otherSorters];
        parent::__construct($this->createLazy($this->inner, $this->sorters, preserveKeys: true));
    }

    /**
     * @template TComparable
     * @param callable(V, K): TComparable $hasher
     * @param bool $descending
     * @return AssociativeOrderedIterator<K,V>
     */
    public function thenBy(callable $hasher, bool $descending = false): self
    {
        return new self($this->inner, $hasher, $descending, $this->sorters);
    }
}

/**
 * @internal
 * @template K
 * @template V
 * @extends LazyRewindableIterator<int,V>
 */
final class ListOrderedIterator extends LazyRewindableIterator
{
    /** @use OrderedIteratorUtils<K,V> */
    use OrderedIteratorUtils;

    /**
     * @template TComparable
     * @param iterable<K,V> $inner
     * @param callable(V, K): TComparable $hasher
     * @param bool $descending
     * @param array<(callable(array<array{V,K}>&):void)> $otherSorters
     */
    final public function __construct(
        protected readonly iterable $inner,
        callable $hasher,
        bool $descending = false,
        array $otherSorters = [],
    ) {
        $this->sorters = [self::createSorter($hasher, $descending), ...$otherSorters];
        parent::__construct($this->createLazy($this->inner, $this->sorters, preserveKeys: false));
    }

    /**
     * @template TComparable
     * @param callable(V, K): TComparable $hasher
     * @param bool $descending
     * @return ListOrderedIterator<K,V>
     */
    public function thenBy(callable $hasher, bool $descending = false): self
    {
        return new self($this->inner, $hasher, $descending, $this->sorters);
    }
}
