<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @template K of array-key
 * @template V
 * @extends LazyRewindableIterator<K,V>
 */
final class OrderedIterator extends LazyRewindableIterator
{
    /**
     * @var array<(callable(array<K,V>&):void)> $sorters
     */
    private readonly array $sorters;

    /**
     * @template TComparable
     * @param iterable<K,V> $inner
     * @param callable(V, K): TComparable $hasher
     * @param bool $descenting
     * @param array<(callable(array<K,V>&):void)> $sorters
     */
    public function __construct(private readonly iterable $inner, callable $hasher, bool $descenting = false, array $sorters = [])
    {
        $this->sorters = array_merge([static function (array &$a) use ($hasher, $descenting) {
            uksort(
                $a,
                $descenting
                // @phpstan-ignore argument.type (int|string $k1 cannot be subclassed), argument.type (int|string $k2 cannot be subclassed)
                ? static fn (int|string $k1, int|string $k2) => $hasher($a[$k2], $k2) <=> $hasher($a[$k1], $k1)
                // @phpstan-ignore argument.type (int|string $k1 cannot be subclassed), argument.type (int|string $k2 cannot be subclassed)
                : static fn (int|string $k1, int|string $k2) => $hasher($a[$k1], $k1) <=> $hasher($a[$k2], $k2),
            );
        }], $sorters);

        parent::__construct(function () {
            $a = iterator_to_array($this->inner);
            foreach ($this->sorters as $sorter) {
                $sorter($a);
                /** @var array<K,V> $a -- stating that the sorter won't change the type of the passed-by-ref argument */
            }
            foreach ($a as $key => $value) {
                yield $key => $value;
            }
        });
    }

    /**
     * @template TComparable
     * @param callable(V, K): TComparable $hasher
     * @return OrderedIterator<K, V>
     */
    public function thenBy(callable $hasher, bool $descenting = false): self
    {
        return new self($this->inner, $hasher, $descenting, $this->sorters);
    }
}
