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
        $this->assertEquals(
            0,
            [] |> p_sum(),
        );
        $this->assertEquals(
            6,
            [1, 2, 3] |> p_sum(),
        );
        $this->assertEquals(
            -5.5,
            ['a' => 10, 'b' => -15.5] |> p_sum(),
        );
    }
}
