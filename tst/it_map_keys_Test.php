<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

use function pipes\it_map_keys;

/**
 * @internal
 */
final class it_map_keys_Test extends TestCase
{
    public function test_map_keys(): void
    {
        $this->assertEquals(['a' => 'a', 'b' => 'b'], iterator_to_array(it_map_keys(fn (string $x, int $k) => $x)(['a','b'])));
    }
}
