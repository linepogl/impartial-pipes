<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use ImpartialPipes\LazyRewindableIterator;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_implode;

/**
 * @internal
 */
final class p_implode_Test extends UnitTestCase
{
    public function test_p_implode_with_arrays(): void
    {
        $this
            ->expect([])
            ->pipe(p_implode())
            ->toBe('');
        $this
            ->expect([])
            ->pipe(p_implode('-'))
            ->toBe('');
        $this
            ->expect([1, 2, 3])
            ->pipe(p_implode())
            ->toBe('123');
        $this
            ->expect([1, 2, 3])
            ->pipe(p_implode('-'))
            ->toBe('1-2-3');
        $this
            ->expect([1, 'a', 3.3, null])
            ->pipe(p_implode())
            ->toBe('1a3.3');
        $this
            ->expect([1, 'a', 3.3, null])
            ->pipe(p_implode('-'))
            ->toBe('1-a-3.3-');
    }

    public function test_p_implode_with_array_iterators(): void
    {
        $this
            ->expect(new UniterableArrayIterator([]))
            ->pipe(p_implode())
            ->toBe('');
        $this
            ->expect(new UniterableArrayIterator([]))
            ->pipe(p_implode('-'))
            ->toBe('');
        $this
            ->expect(new UniterableArrayIterator([1, 2, 3]))
            ->pipe(p_implode())
            ->toBe('123');
        $this
            ->expect(new UniterableArrayIterator([1, 2, 3]))
            ->pipe(p_implode('-'))
            ->toBe('1-2-3');
        $this
            ->expect(new UniterableArrayIterator([1, 'a', 3.3, null]))
            ->pipe(p_implode())
            ->toBe('1a3.3');
        $this
            ->expect(new UniterableArrayIterator([1, 'a', 3.3, null]))
            ->pipe(p_implode('-'))
            ->toBe('1-a-3.3-');
    }

    public function test_p_implode_with_simple_iterators(): void
    {
        $this
            ->expect(new SimpleIterator([]))
            ->pipe(p_implode())
            ->toBe('');
        $this
            ->expect(new SimpleIterator([]))
            ->pipe(p_implode('-'))
            ->toBe('');
        $this
            ->expect(new SimpleIterator([1, 2, 3]))
            ->pipe(p_implode())
            ->toBe('123');
        $this
            ->expect(new SimpleIterator([1, 2, 3]))
            ->pipe(p_implode('-'))
            ->toBe('1-2-3');
        $this
            ->expect(new SimpleIterator([1, 'a', 3.3, null]))
            ->pipe(p_implode())
            ->toBe('1a3.3');
        $this
            ->expect(new SimpleIterator([1, 'a', 3.3, null]))
            ->pipe(p_implode('-'))
            ->toBe('1-a-3.3-');
    }
}
