<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;

use function ImpartialPipes\p_all;

/**
 * @internal
 */
final class p_all_Test extends UnitTestCase
{
    public function test_p_all(): void
    {
        $this
            ->expect([])
            ->pipe(p_all(static fn (int $x) => $x % 2 === 1))
            ->toBe(true);

        $this
            ->expect([])
            ->pipe(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
            ->toBe(true);

        $this
            ->expect([1, 3, 5])
            ->pipe(p_all(static fn (int $x) => $x % 2 === 1))
            ->toBe(true);

        $this
            ->expect([1, 2, 5])
            ->pipe(p_all(static fn (int $x) => $x % 2 === 1))
            ->toBe(false);

        $this
            ->expect(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->pipe(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
            ->toBe(true);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3])
            ->pipe(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
            ->toBe(false);
    }
}
