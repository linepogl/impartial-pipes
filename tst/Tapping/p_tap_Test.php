<?php

declare(strict_types=1);

namespace Tests\Tapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_tap;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_tap_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_tap(): void
    {
        $test = '';
        pipe('test')
        ->to(p_tap(static function (string $x) use (&$test) { $test = $x; }))
        ->to(self::is('test'));
        pipe($test)->to(self::is('test'));
    }
}
