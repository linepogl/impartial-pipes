<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_implode;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_implode_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_implode_with_arrays(): void
    {
        pipe([])
        ->to(p_implode())
        ->to(self::is(''));

        pipe([])
        ->to(p_implode('-'))
        ->to(self::is(''));

        pipe([1, 2, 3])
        ->to(p_implode())
        ->to(self::is('123'));

        pipe([1, 2, 3])
        ->to(p_implode('-'))
        ->to(self::is('1-2-3'));

        pipe([1, 'a', 3.3, null])
        ->to(p_implode())
        ->to(self::is('1a3.3'));

        pipe([1, 'a', 3.3, null])
        ->to(p_implode('-'))
        ->to(self::is('1-a-3.3-'));
    }

    public function test_p_implode_with_array_iterators(): void
    {
        pipe(new UniterableArrayIterator([]))
        ->to(p_implode())
        ->to(self::is(''));

        pipe(new UniterableArrayIterator([]))
        ->to(p_implode('-'))
        ->to(self::is(''));

        pipe(new UniterableArrayIterator([1, 2, 3]))
        ->to(p_implode())
        ->to(self::is('123'));

        pipe(new UniterableArrayIterator([1, 2, 3]))
        ->to(p_implode('-'))
        ->to(self::is('1-2-3'));

        pipe(new UniterableArrayIterator([1, 'a', 3.3, null]))
        ->to(p_implode())
        ->to(self::is('1a3.3'));

        pipe(new UniterableArrayIterator([1, 'a', 3.3, null]))
        ->to(p_implode('-'))
        ->to(self::is('1-a-3.3-'));
    }

    public function test_p_implode_with_simple_iterators(): void
    {
        pipe(new SimpleIterator([]))
        ->to(p_implode())
        ->to(self::is(''));

        pipe(new SimpleIterator([]))
        ->to(p_implode('-'))
        ->to(self::is(''));

        pipe(new SimpleIterator([1, 2, 3]))
        ->to(p_implode())
        ->to(self::is('123'));

        pipe(new SimpleIterator([1, 2, 3]))
        ->to(p_implode('-'))
        ->to(self::is('1-2-3'));

        pipe(new SimpleIterator([1, 'a', 3.3, null]))
        ->to(p_implode())
        ->to(self::is('1a3.3'));

        pipe(new SimpleIterator([1, 'a', 3.3, null]))
        ->to(p_implode('-'))
        ->to(self::is('1-a-3.3-'));
    }
}
