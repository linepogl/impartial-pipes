<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function Pipes\it_implode;

/**
 * @internal
 */
final class it_implode_Test extends UnitTestCase
{
    public function test_it_implode(): void
    {
        $this->assertEquals(
            '',
            [] |> it_implode(),
        );
        $this->assertEquals(
            '',
            [] |> it_implode('-'),
        );
        $this->assertEquals(
            '123',
            [1, 2, 3] |> it_implode(),
        );
        $this->assertEquals(
            '1-2-3',
            [1, 2, 3] |> it_implode('-'),
        );
        $this->assertEquals(
            '1-a--3.3-',
            [1, 'a', -3.3, null] |> it_implode('-'),
        );
    }
}
