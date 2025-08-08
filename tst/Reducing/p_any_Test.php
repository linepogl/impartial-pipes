<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_any;

/**
 * @internal
 */
final class p_any_Test extends UnitTestCase
{
    public function test_p_any_with_arrays(): void
    {
        $this
            ->expect([])
            ->pipe(p_any(static fn (int $x) => $x % 2 === 1))
            ->toBe(false);

        $this
            ->expect([])
            ->pipe(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
            ->toBe(false);

        $this
            ->expect([2, 3, 4])
            ->pipe(p_any(static fn (int $x) => $x % 2 === 1))
            ->toBe(true);

        $this
            ->expect([2, 4, 6])
            ->pipe(p_any(static fn (int $x) => $x % 2 === 1))
            ->toBe(false);

        $this
            ->expect(['aa' => 1, 'bb' => 2, 'cc' => 3])
            ->pipe(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
            ->toBe(true);

        $this
            ->expect(['aa' => 1, 'bb' => 2, 'cc' => 3])
            ->pipe(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
            ->toBe(false);
    }

    public function test_p_any_with_iterators(): void
    {
        $this
            ->expect(new ArrayIterator([]))
            ->pipe(p_any(static fn (int $x) => $x % 2 === 1))
            ->toBe(false);

        $this
            ->expect(new ArrayIterator([]))
            ->pipe(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
            ->toBe(false);

        $this
            ->expect(new ArrayIterator([2, 3, 4]))
            ->pipe(p_any(static fn (int $x) => $x % 2 === 1))
            ->toBe(true);

        $this
            ->expect(new ArrayIterator([2, 4, 6]))
            ->pipe(p_any(static fn (int $x) => $x % 2 === 1))
            ->toBe(false);

        $this
            ->expect(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
            ->pipe(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
            ->toBe(true);

        $this
            ->expect(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
            ->pipe(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
            ->toBe(false);
    }

    public function test_p_any_without_a_predicate(): void
    {
        $this
            ->expect([])
            ->pipe(p_any())
            ->toBe(false);
        $this
            ->expect([1, 2])
            ->pipe(p_any())
            ->toBe(true);
        $this
            ->expect(new UniterableArrayIterator([]))
            ->pipe(p_any())
            ->toBe(false);
        $this
            ->expect(new UniterableArrayIterator([1, 2]))
            ->pipe(p_any())
            ->toBe(true);
        $this
            ->expect(new SimpleIterator([]))
            ->pipe(p_any())
            ->toBe(false);
        $this
            ->expect(new SimpleIterator([1, 2]))
            ->pipe(p_any())
            ->toBe(true);
    }
}
