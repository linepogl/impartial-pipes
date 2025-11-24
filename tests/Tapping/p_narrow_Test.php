<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Tapping;

use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use TypeError;

use function ImpartialPipes\p_narrow;

/**
 * @internal
 */
final class p_narrow_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_narrow(): void
    {
        $test = new DateTime();
        $test
        |> p_narrow(DateTime::class)
        |> self::identicalTo($test);

        self::throws(TypeError::class)(
            static fn () =>
            new DateTime() |> p_narrow(DateInterval::class)
        );
    }
}
