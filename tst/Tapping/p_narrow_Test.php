<?php

declare(strict_types=1);

namespace Tests\Tapping;

use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use TypeError;

use function ImpartialPipes\p_narrow;
use function ImpartialPipes\pipe;
use function Should\shouldBeIdenticalTo;
use function Should\shouldThrow;

/**
 * @internal
 */
final class p_narrow_Test extends TestCase
{
    public function test_p_narrow(): void
    {
        $test = new DateTime();
        pipe($test)
        ->to(p_narrow(DateTime::class))
        ->to(shouldBeIdenticalTo($test));

        shouldThrow(TypeError::class)(
            fn () =>
            pipe(new DateTime())
            ->to(p_narrow(DateInterval::class))
        );
    }
}
