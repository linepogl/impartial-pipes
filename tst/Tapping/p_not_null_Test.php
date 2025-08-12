<?php

declare(strict_types=1);

namespace Tests\Tapping;

use DateTime;
use PHPUnit\Framework\TestCase;
use TypeError;

use function ImpartialPipes\p_not_null;
use function ImpartialPipes\pipe;
use function Should\shouldBeIdenticalTo;
use function Should\shouldThrow;

/**
 * @internal
 */
final class p_not_null_Test extends TestCase
{
    public function test_p_not_null(): void
    {
        $test = new DateTime();
        pipe($test)
        ->to(p_not_null())
        ->to(shouldBeIdenticalTo($test));

        shouldThrow(TypeError::class)(
            fn () =>
            pipe(null)
            ->to(p_not_null())
        );
    }
}
