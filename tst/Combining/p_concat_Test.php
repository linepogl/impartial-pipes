<?php

declare(strict_types=1);

namespace Tests\Combining;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use Tests\ConcatIterator;

use function ImpartialPipes\p_concat;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_concat_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_concat(): void
    {
        pipe([])
        ->to(p_concat([]))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_concat([], preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe([1,2])
        ->to(p_concat([3,4]))
        ->to(self::iteratesLike([1,2,3,4], rewind: true));

        pipe([1,2])
        ->to(p_concat([3,4], preserveKeys: true))
        ->to(self::iteratesLike(new ConcatIterator([0 => 1], [1 => 2], [0 => 3], [1 => 4]), rewind: true));

        pipe(['a' => 1,'b' => 2,'c' => 3])
        ->to(p_concat(['b' => 22,'c' => 33,'d' => 4]))
        ->to(self::iteratesLike([1,2,3,22,33,4], rewind: true));

        pipe(['a' => 1,'b' => 2,'c' => '3'])
        ->to(p_concat(['b' => 2,'c' => 3,'d' => 4], preserveKeys: true))
        ->to(self::iteratesLike(new ConcatIterator(['a' => 1,'b' => 2,'c' => '3'], ['b' => 2,'c' => 3,'d' => 4]), rewind: true));
    }
}
