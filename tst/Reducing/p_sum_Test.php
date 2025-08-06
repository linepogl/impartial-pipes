<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;

use function ImpartialPipes\p_sum;

/**
 * @internal
 */
final class p_sum_Test extends UnitTestCase
{
    public function test_p_sum(): void
    {
        $this
            ->expect([])
            ->pipe(p_sum())
            ->toBe(0);

        $this
            ->expect([1,2,3])
            ->pipe(p_sum())
            ->toBe(6);

        $this
            ->expect([1,-12.8,4.4])
            ->pipe(p_sum())
            ->toBe(-7.4);
    }
}
