<?php

declare(strict_types=1);

namespace Tests\Combining;

use ImpartialPipes\LazyRewindableIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_merge;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_merge_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_merge(): void
    {
        pipe([])
        ->to(p_merge([]))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_merge([], preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe([1,2])
        ->to(p_merge([3,4]))
        ->to(self::iteratesLike([1,2,3,4], rewind: true));

        pipe([1,2])
        ->to(p_merge([3,4], preserveKeys: true))
        ->to(self::iteratesLike(self::arrays_to_iterable([0 => 1], [1 => 2], [0 => 3], [1 => 4]), rewind: true));

        pipe(['a' => 1,'b' => 2,'c' => 3])
        ->to(p_merge(['b' => 22,'c' => 33,'d' => 4]))
        ->to(self::iteratesLike([1,2,3,22,33,4], rewind: true));

        pipe(['a' => 1,'b' => 2,'c' => '3'])
        ->to(p_merge(['b' => 2,'c' => 3,'d' => 4], preserveKeys: true))
        ->to(self::iteratesLike(self::arrays_to_iterable(['a' => 1,'b' => 2,'c' => '3'], ['b' => 2,'c' => 3,'d' => 4]), rewind: true));
    }

    /**
     * @template K
     * @template V
     * @param array<K, V> ...$arrays
     * @return iterable<K, V>
     */
    private static function arrays_to_iterable(array ...$arrays): iterable
    {
        return new LazyRewindableIterator(static function () use ($arrays) {
            foreach ($arrays as $array) {
                foreach ($array as $key => $value) {
                    yield $key => $value;
                }
            }
        });
    }
}
