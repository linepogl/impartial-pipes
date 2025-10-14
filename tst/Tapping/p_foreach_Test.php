<?php

declare(strict_types=1);

namespace Tests\Tapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_foreach;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_foreach_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_foreach(): void
    {
        $sum = 0;
        pipe([])->to(p_foreach(function (int $x) use (&$sum) { $sum += $x; }));
        pipe($sum)->to(self::is(0));

        $sum = 0;
        pipe([0])->to(p_foreach(function (int $x) use (&$sum) { $sum += $x; }));
        pipe($sum)->to(self::is(0));

        $sum = 0;
        pipe([1,2,3])->to(p_foreach(function (int $x) use (&$sum) { $sum += $x; }));
        pipe($sum)->to(self::is(6));

        $sum = '';
        pipe([])->to(p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; }));
        pipe($sum)->to(self::is(''));

        $sum = '';
        pipe([0])->to(p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; }));
        pipe($sum)->to(self::is('0'));

        $sum = '';
        pipe([1,2,3])->to(p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; }));
        pipe($sum)->to(self::is('012'));
    }
}
