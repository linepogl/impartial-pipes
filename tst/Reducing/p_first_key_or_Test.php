<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_first_key_or;

/**
 * @internal
 */
final class p_first_key_or_Test extends UnitTestCase
{
    public function test_p_first_key_or_with_arrays(): void
    {
        $this
            ->expect([])
            ->pipe(p_first_key_or(null))
            ->toBe(null);
        $this
            ->expect([])
            ->pipe(p_first_key_or(null, static fn (int $x) => $x > 1))
            ->toBe(null);
        $this
            ->expect([1,2,3])
            ->pipe(p_first_key_or(null))
            ->toBe(0);
        $this
            ->expect([1,2,3])
            ->pipe(p_first_key_or(null, static fn (int $x) => $x > 1))
            ->toBe(1);
        $this
            ->expect([1,2,3])
            ->pipe(p_first_key_or(null, static fn (int $x) => $x > 3))
            ->toBe(null);
        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_first_key_or(null))
            ->toBe('a');
        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 1))
            ->toBe('aa');
        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 3))
            ->toBe(null);
    }

    public function test_p_first_key_or_with_iterables(): void
    {
        $this
            ->expect(new ArrayIterator([]))
            ->pipe(p_first_key_or(null))
            ->toBe(null);
        $this
            ->expect(new ArrayIterator([]))
            ->pipe(p_first_key_or(null, static fn (int $x) => $x > 1))
            ->toBe(null);
        $this
            ->expect(new ArrayIterator([1,2,3]))
            ->pipe(p_first_key_or(null))
            ->toBe(0);
        $this
            ->expect(new ArrayIterator([1,2,3]))
            ->pipe(p_first_key_or(null, static fn (int $x) => $x > 1))
            ->toBe(1);
        $this
            ->expect(new ArrayIterator([1,2,3]))
            ->pipe(p_first_key_or(null, static fn (int $x) => $x > 3))
            ->toBe(null);
        $this
            ->expect(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->pipe(p_first_key_or(null))
            ->toBe('a');
        $this
            ->expect(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->pipe(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 1))
            ->toBe('aa');
        $this
            ->expect(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->pipe(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 3))
            ->toBe(null);
    }
}
