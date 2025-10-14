<?php

declare(strict_types=1);

namespace Tests\Tapping;

use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Throws;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;
use TypeError;

use function ImpartialPipes\p_narrow;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_narrow_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_narrow(): void
    {
        $test = new DateTime();
        pipe($test)
        ->to(p_narrow(DateTime::class))
        ->to($this->identicalTo($test));

        new Throws(TypeError::class)(
            fn () =>
            pipe(new DateTime())
            ->to(p_narrow(DateInterval::class))
        );
    }
}
