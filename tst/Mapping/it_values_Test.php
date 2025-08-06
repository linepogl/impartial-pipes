<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;
use function Pipes\it_values;

/**
 * @internal
 */
final class it_values_Test extends UnitTestCase
{
    public function test_it_values(): void
    {
        $this->assertIterEquals(
            [],
            [] |> it_values(),
        );
        $this->assertIterEquals(
            [1, 2, 3],
            [1, 2, 3] |> it_values(),
        );
        $this->assertIterEquals(
            [1, 2, 3],
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_values(),
        );
    }

    public function test_it_values_is_rewindable(): void
    {
        $a = [1, 2, 3] |> it_values();
        $this->assertIterEquals([1, 2, 3], $a);
        $this->assertIterEquals([1, 2, 3], $a); // again to see if $a is rewindable
    }
}
