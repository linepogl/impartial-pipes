<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_to_array;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_to_array_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_to_array(): void
    {
        pipe([])
        ->to(p_to_array())
        ->to(self::is([]));

        pipe([1,2])
        ->to(p_to_array())
        ->to(self::is([1,2]));

        pipe(new SimpleIterator([1,2,3]))
        ->to(p_to_array())
        ->to(self::is([1,2,3]));

        pipe(new UniterableArrayIterator([1,2,3,4]))
        ->to(p_to_array())
        ->to(self::is([1,2,3,4]));
    }
}
