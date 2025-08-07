<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_to_array;

/**
 * @internal
 */
final class p_to_array_Test extends UnitTestCase
{
    public function test_p_to_array(): void
    {
        $this
            ->expect([])
            ->pipe(p_to_array())
            ->toBe([]);
        $this
            ->expect([1,2])
            ->pipe(p_to_array())
            ->toBe([1,2]);
        $this
            ->expect(new SimpleIterator([1,2,3]))
            ->pipe(p_to_array())
            ->toBe([1,2,3]);
        $this
            ->expect(new UniterableArrayIterator([1,2,3,4]))
            ->pipe(p_to_array())
            ->toBe([1,2,3,4]);
    }
}
