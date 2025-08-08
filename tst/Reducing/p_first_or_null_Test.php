<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_first_or_null;

/**
 * @internal
 */
final class p_first_or_null_Test extends UnitTestCase
{
    public function test_p_first_or_null_with_arrays(): void
    {
        $this
            ->expect([])
            ->pipe(p_first_or_null())
            ->toBe(null);
        $this
            ->expect([])
            ->pipe(p_first_or_null(static fn (int $x) => $x > 1))
            ->toBe(null);
        $this
            ->expect([1,2,3])
            ->pipe(p_first_or_null())
            ->toBe(1);
        $this
            ->expect([1,2,3])
            ->pipe(p_first_or_null(static fn (int $x) => $x > 1))
            ->toBe(2);
        $this
            ->expect([1,2,3])
            ->pipe(p_first_or_null(static fn (int $x) => $x > 3))
            ->toBe(null);
        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_first_or_null())
            ->toBe(1);
        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_first_or_null(static fn (int $x, string $k) => strlen($k) > 1))
            ->toBe(2);
        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_first_or_null(static fn (int $x, string $k) => strlen($k) > 3))
            ->toBe(null);
    }

    public function test_p_first_or_null_with_iterables(): void
    {
        $this
            ->expect(new ArrayIterator([]))
            ->pipe(p_first_or_null())
            ->toBe(null);
        $this
            ->expect(new ArrayIterator([]))
            ->pipe(p_first_or_null(static fn (int $x) => $x > 1))
            ->toBe(null);
        $this
            ->expect(new ArrayIterator([1,2,3]))
            ->pipe(p_first_or_null())
            ->toBe(1);
        $this
            ->expect(new ArrayIterator([1,2,3]))
            ->pipe(p_first_or_null(static fn (int $x) => $x > 1))
            ->toBe(2);
        $this
            ->expect(new ArrayIterator([1,2,3]))
            ->pipe(p_first_or_null(static fn (int $x) => $x > 3))
            ->toBe(null);
        $this
            ->expect(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->pipe(p_first_or_null())
            ->toBe(1);
        $this
            ->expect(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->pipe(p_first_or_null(static fn (int $x, string $k) => strlen($k) > 1))
            ->toBe(2);
        $this
            ->expect(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->pipe(p_first_or_null(static fn (int $x, string $k) => strlen($k) > 3))
            ->toBe(null);
    }
}
