<?php

declare(strict_types=1);

namespace Tests;

use function Pipes\it_map_keys;

/**
 * @internal
 */
final class ItMapKeysTest extends UnitTestCase
{
    public function test_map_keys(): void
    {
        $this->assertIterEquals(['a' => 'a', 'b' => 'b'], it_map_keys(fn (string $x, int $k) => $x)(['a','b']));
    }
}
