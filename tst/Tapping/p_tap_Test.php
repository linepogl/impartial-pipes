<?php

declare(strict_types=1);

namespace Tests\Tapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_tap;
use function ImpartialPipes\pipe;
use function Should\shouldBe;

/**
 * @internal
 */
final class p_tap_Test extends TestCase
{
    public function test_p_tap(): void
    {
        $test = '';
        pipe('test')
        ->to(p_tap(static function (string $x) use (&$test) { $test = $x; }))
        ->to(shouldBe('test'));
        pipe($test)->to(shouldBe('test'));
    }
}
