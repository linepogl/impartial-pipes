<?php

declare(strict_types=1);

namespace Tests\Reducing;

use PHPUnit\Framework\TestCase;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\p_implode;
use function ImpartialPipes\pipe;
use function Should\shouldBe;

/**
 * @internal
 */
final class p_implode_Test extends TestCase
{
    public function test_p_implode_with_arrays(): void
    {
        pipe([])
        ->to(p_implode())
        ->to(shouldBe(''));

        pipe([])
        ->to(p_implode('-'))
        ->to(shouldBe(''));

        pipe([1, 2, 3])
        ->to(p_implode())
        ->to(shouldBe('123'));

        pipe([1, 2, 3])
        ->to(p_implode('-'))
        ->to(shouldBe('1-2-3'));

        pipe([1, 'a', 3.3, null])
        ->to(p_implode())
        ->to(shouldBe('1a3.3'));

        pipe([1, 'a', 3.3, null])
        ->to(p_implode('-'))
        ->to(shouldBe('1-a-3.3-'));
    }

    public function test_p_implode_with_array_iterators(): void
    {
        pipe(new UniterableArrayIterator([]))
        ->to(p_implode())
        ->to(shouldBe(''));

        pipe(new UniterableArrayIterator([]))
        ->to(p_implode('-'))
        ->to(shouldBe(''));

        pipe(new UniterableArrayIterator([1, 2, 3]))
        ->to(p_implode())
        ->to(shouldBe('123'));

        pipe(new UniterableArrayIterator([1, 2, 3]))
        ->to(p_implode('-'))
        ->to(shouldBe('1-2-3'));

        pipe(new UniterableArrayIterator([1, 'a', 3.3, null]))
        ->to(p_implode())
        ->to(shouldBe('1a3.3'));

        pipe(new UniterableArrayIterator([1, 'a', 3.3, null]))
        ->to(p_implode('-'))
        ->to(shouldBe('1-a-3.3-'));
    }

    public function test_p_implode_with_simple_iterators(): void
    {
        pipe(new SimpleIterator([]))
        ->to(p_implode())
        ->to(shouldBe(''));

        pipe(new SimpleIterator([]))
        ->to(p_implode('-'))
        ->to(shouldBe(''));

        pipe(new SimpleIterator([1, 2, 3]))
        ->to(p_implode())
        ->to(shouldBe('123'));

        pipe(new SimpleIterator([1, 2, 3]))
        ->to(p_implode('-'))
        ->to(shouldBe('1-2-3'));

        pipe(new SimpleIterator([1, 'a', 3.3, null]))
        ->to(p_implode())
        ->to(shouldBe('1a3.3'));

        pipe(new SimpleIterator([1, 'a', 3.3, null]))
        ->to(p_implode('-'))
        ->to(shouldBe('1-a-3.3-'));
    }
}
