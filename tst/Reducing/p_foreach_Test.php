<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;

use function ImpartialPipes\p_foreach;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;

/**
 * @internal
 */
final class p_foreach_Test extends UnitTestCase
{
    public function test_p_foreach(): void
    {
        $sum = 0;
        pipe([])->to(p_foreach(function (int $x) use (&$sum) { $sum += $x; }));
        pipe($sum)->to(p_assert_equals(0));

        $sum = 0;
        pipe([0])->to(p_foreach(function (int $x) use (&$sum) { $sum += $x; }));
        pipe($sum)->to(p_assert_equals(0));

        $sum = 0;
        pipe([1,2,3])->to(p_foreach(function (int $x) use (&$sum) { $sum += $x; }));
        pipe($sum)->to(p_assert_equals(6));

        $sum = '';
        pipe([])->to(p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; }));
        pipe($sum)->to(p_assert_equals(''));

        $sum = '';
        pipe([0])->to(p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; }));
        pipe($sum)->to(p_assert_equals('0'));

        $sum = '';
        pipe([1,2,3])->to(p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; }));
        pipe($sum)->to(p_assert_equals('012'));
    }

}
