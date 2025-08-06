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
        $this
            ->expect([])
            ->pipe(p_implode())
            ->toBe('');

        $this
            ->expect([])
            ->pipe(p_implode('-'))
            ->toBe('');


        $this
            ->expect([1, 2, 3])
            ->pipe(p_implode())
            ->toBe('123');

        $this
            ->expect([1, 2, 3])
            ->pipe(p_implode('-'))
            ->toBe('1-2-3');

        $this
            ->expect([1, 'a', 3.3, null])
            ->pipe(p_implode())
            ->toBe('1a3.3');

        $this
            ->expect([1, 'a', 3.3, null])
            ->pipe(p_implode('-'))
            ->toBe('1-a-3.3-');
    }
}
