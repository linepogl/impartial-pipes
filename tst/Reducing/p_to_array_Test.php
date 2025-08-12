<?php

declare(strict_types=1);

namespace Tests\Reducing;

use PHPUnit\Framework\TestCase;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\p_to_array;
use function ImpartialPipes\pipe;
use function Should\shouldBe;

/**
 * @internal
 */
final class p_to_array_Test extends TestCase
{
    public function test_p_to_array(): void
    {
        pipe([])
        ->to(p_to_array())
        ->to(shouldBe([]));

        pipe([1,2])
        ->to(p_to_array())
        ->to(shouldBe([1,2]));

        pipe(new SimpleIterator([1,2,3]))
        ->to(p_to_array())
        ->to(shouldBe([1,2,3]));

        pipe(new UniterableArrayIterator([1,2,3,4]))
        ->to(p_to_array())
        ->to(shouldBe([1,2,3,4]));
    }
}
