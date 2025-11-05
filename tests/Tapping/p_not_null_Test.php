<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Tapping;

use DateTime;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Throws;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use TypeError;

use function ImpartialPipes\p_not_null;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_not_null_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_not_null(): void
    {
        $test = new DateTime();
        pipe($test)
        ->to(p_not_null())
        ->to($this->identicalTo($test));

        new Throws(TypeError::class)(
            fn () =>
            pipe(null)
            ->to(p_not_null())
        );
    }
}
