<?php

declare(strict_types=1);

namespace Tests\Util;

use ArrayIterator;
use ImpartialPipes\LazyRewindableIterator;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

/**
 * @internal
 */
final class LazyRewindableIteratorTest extends UnitTestCase
{
    public function test_rewindable_iterator(): void
    {
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });

        $this->expect($it->valid())->toBe(true);
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
        $it->next();
        $this->expect($it->valid())->toBe(true);
        $this->expect($it->key())->toBe(1);
        $this->expect($it->current())->toBe(2);
        $it->rewind();
        $this->expect($it->valid())->toBe(true);
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
        $it->rewind();
        $this->expect($it->valid())->toBe(true);
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
        $it->next();
        $this->expect($it->valid())->toBe(true);
        $this->expect($it->key())->toBe(1);
        $this->expect($it->current())->toBe(2);
        $it->next();
        $this->expect($it->valid())->toBe(false);
        $this->expect($it->key())->toBe(null);
        $this->expect($it->current())->toBe(null);
        $it->rewind();
        $this->expect($it->valid())->toBe(true);
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
    }

    public function test_rewinds(): void
    {
        $it = new LazyRewindableIterator(static fn () => [1,2,3]);
        iterator_to_array($it);
        iterator_to_array($it);
        $this->expect(iterator_to_array($it))->toBe([1,2,3]);

        $it = new LazyRewindableIterator(static fn () => new ArrayIterator([1,2,3]));
        iterator_to_array($it);
        iterator_to_array($it);
        $this->expect(iterator_to_array($it))->toBe([1,2,3]);

        $it = new LazyRewindableIterator(static function () { yield from [1, 2, 3]; });
        iterator_to_array($it);
        iterator_to_array($it);
        $this->expect(iterator_to_array($it))->toBe([1,2,3]);
    }

    public function test_init(): void
    {
        // test calling rewind() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->rewind();
        $this->expect($it->key())->toBe(0);

        // test calling next() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->next();
        $this->expect($it->key())->toBe(1);

        // test calling valid() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $this->expect($it->valid())->toBe(true);

        // test calling key() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $this->expect($it->key())->toBe(0);

        // test calling current() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $this->expect($it->current())->toBe(1);
    }

    public function test_counting_with_countables(): void
    {
        $it = new LazyRewindableIterator(static fn () => [1,2,3]);
        $this->expect($it->count())->toBe(3);

        $it = new LazyRewindableIterator(static fn () => new SimpleIterator([1]));
        $this->expect($it->count())->toBe(1);

        $it = new LazyRewindableIterator(static fn () => new UniterableArrayIterator([1,2]));
        $this->expect($it->count())->toBe(2);

        $it = new LazyRewindableIterator(static fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3])));
        $this->expect($it->count())->toBe(3);

        $it = new LazyRewindableIterator(static fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4])));
        $this->expect($it->count())->toBe(4);
    }
}
