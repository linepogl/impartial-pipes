<?php

declare(strict_types=1);

namespace Tests\Filtering;

use ImpartialPipes\LazyRewindableIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_unique_keys;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_unique_keys_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_unique_keys(): void
    {
        pipe([])
        ->to(p_unique_keys())
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_unique_keys(preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(self::arrays_to_iterable(['a' => 1], ['a' => 2], ['b' => 3], ['b' => 4]))
        ->to(p_unique_keys())
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(self::arrays_to_iterable(['a' => 1], ['a' => 2], ['b' => 3], ['b' => 4]))
        ->to(p_unique_keys(preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'cc' => 3, 'dd' => 4])
        ->to(p_unique_keys(static fn (string $k) => strlen($k)))
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'cc' => 3, 'dd' => 4])
        ->to(p_unique_keys(static fn (string $k) => strlen($k), preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'cc' => 3], rewind: true));
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
