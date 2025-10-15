<?php

declare(strict_types=1);

namespace Tests\Util;

use ArrayIterator;
use ImpartialPipes\LazyRewindableIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class LazyRewindableIteratorTest extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_rewindable_iterator(): void
    {
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });

        pipe($it->valid())->to(self::is(true));
        pipe($it->key())->to(self::is(0));
        pipe($it->current())->to(self::is(1));
        $it->next();
        pipe($it->valid())->to(self::is(true));
        pipe($it->key())->to(self::is(1));
        pipe($it->current())->to(self::is(2));
        $it->rewind();
        pipe($it->valid())->to(self::is(true));
        pipe($it->key())->to(self::is(0));
        pipe($it->current())->to(self::is(1));
        $it->rewind();
        pipe($it->valid())->to(self::is(true));
        pipe($it->key())->to(self::is(0));
        pipe($it->current())->to(self::is(1));
        $it->next();
        pipe($it->valid())->to(self::is(true));
        pipe($it->key())->to(self::is(1));
        pipe($it->current())->to(self::is(2));
        $it->next();
        pipe($it->valid())->to(self::is(false));
        pipe($it->key())->to(self::is(null));
        pipe($it->current())->to(self::is(null));
        $it->rewind();
        pipe($it->valid())->to(self::is(true));
        pipe($it->key())->to(self::is(0));
        pipe($it->current())->to(self::is(1));
    }

    public function test_rewinds(): void
    {
        $it = new LazyRewindableIterator(static fn () => [1,2,3]);
        iterator_to_array($it);
        iterator_to_array($it);
        pipe(iterator_to_array($it))->to(self::is([1,2,3]));

        $it = new LazyRewindableIterator(static fn () => new ArrayIterator([1,2,3]));
        iterator_to_array($it);
        iterator_to_array($it);
        pipe(iterator_to_array($it))->to(self::is([1,2,3]));

        $it = new LazyRewindableIterator(static function () { yield from [1, 2, 3]; });
        iterator_to_array($it);
        iterator_to_array($it);
        pipe(iterator_to_array($it))->to(self::is([1,2,3]));
    }

    public function test_init(): void
    {
        // test calling rewind() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->rewind();
        pipe($it->key())->to(self::is(0));

        // test calling next() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->next();
        pipe($it->key())->to(self::is(1));

        // test calling valid() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        pipe($it->valid())->to(self::is(true));

        // test calling key() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        pipe($it->key())->to(self::is(0));

        // test calling current() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        pipe($it->current())->to(self::is(1));
    }

    public function test_counting_with_countables(): void
    {
        $it = new LazyRewindableIterator(static fn () => [1,2,3]);
        pipe($it->count())->to(self::is(3));

        $it = new LazyRewindableIterator(static fn () => new SimpleIterator([1]));
        pipe($it->count())->to(self::is(1));

        $it = new LazyRewindableIterator(static fn () => new UniterableArrayIterator([1,2]));
        pipe($it->count())->to(self::is(2));

        $it = new LazyRewindableIterator(static fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3])));
        pipe($it->count())->to(self::is(3));

        $it = new LazyRewindableIterator(static fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4])));
        pipe($it->count())->to(self::is(4));
    }
}
