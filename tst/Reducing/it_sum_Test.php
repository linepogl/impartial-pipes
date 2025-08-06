<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function Pipes\it_sum;

/**
 * @internal
 */
final class it_sum_Test extends UnitTestCase
{
    public function test_it_sum(): void
    {
        $this->assertEquals(
            0,
            [] |> it_sum(),
        );
        $this->assertEquals(
            6,
            [1, 2, 3] |> it_sum(),
        );
        $this->assertEquals(
            -5.5,
            ['a' => 10, 'b' => -15.5] |> it_sum(),
        );
    }
}
