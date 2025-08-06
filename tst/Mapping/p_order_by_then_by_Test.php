<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_order_by;

/**
 * @internal
 */
final class p_order_by_then_by_Test extends UnitTestCase
{
    public function test_p_order_by(): void
    {
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x) => $x))
            ->toIterateLike([]);

    }
}
