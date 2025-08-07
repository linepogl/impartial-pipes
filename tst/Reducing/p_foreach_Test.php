<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;

use function ImpartialPipes\p_foreach;

/**
 * @internal
 */
final class p_foreach_Test extends UnitTestCase
{
    public function test_p_foreach(): void
    {
        $sum = 0;
        $foreach = p_foreach(function (int $x) use (&$sum) { $sum += $x; });

        $sum = 0;
        $foreach([]);
        $this->expect($sum)->toBe(0);

        $sum = 0;
        $foreach([0]);
        $this->expect($sum)->toBe(0);

        $sum = 0;
        $foreach([1,2,3]);
        $this->expect($sum)->toBe(6);

        $sum = '';
        $foreach = p_foreach(function (int $x, int $key) use (&$sum) { $sum .= $key; });

        $sum = '';
        $foreach([]);
        $this->expect($sum)->toBe('');

        $sum = '';
        $foreach([0]);
        $this->expect($sum)->toBe('0');

        $sum = '';
        $foreach([1,2,3]);
        $this->expect($sum)->toBe('012');
    }

}
