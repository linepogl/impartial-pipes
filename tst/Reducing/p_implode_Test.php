<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function ImpartialPipes\p_implode;

/**
 * @internal
 */
final class p_implode_Test extends UnitTestCase
{
    public function test_p_implode(): void
    {
        $this->assertEquals(
            '',
            [] |> p_implode(),
        );
        $this->assertEquals(
            '',
            [] |> p_implode('-'),
        );
        $this->assertEquals(
            '123',
            [1, 2, 3] |> p_implode(),
        );
        $this->assertEquals(
            '1-2-3',
            [1, 2, 3] |> p_implode('-'),
        );
        $this->assertEquals(
            '1-a--3.3-',
            [1, 'a', -3.3, null] |> p_implode('-'),
        );
    }
}
