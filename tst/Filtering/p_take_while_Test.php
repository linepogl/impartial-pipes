<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_take_while;

/**
 * @internal
 */
final class p_take_while_Test extends UnitTestCase
{
    public function test_p_take_while(): void
    {
        $this
            ->expect([])
            ->pipe(p_take_while(fn (int $x) => $x % 2 === 1))
            ->toIterateLike([]);

        $this
            ->expect([])
            ->pipe(p_take_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take_while(fn (int $x) => $x % 2 === 1))
            ->toIterateLike([1]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
            ->toIterateLike(['a' => 1]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take_while(fn (int $x, string $k) => $k === 'a'))
            ->toIterateLike([1]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
            ->toIterateLike(['a' => 1]);
    }
}
