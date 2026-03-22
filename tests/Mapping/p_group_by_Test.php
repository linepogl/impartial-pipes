<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use Ds\Hashable;
use ImpartialPipes\LazyRewindableIterator;
use LogicException;
use Override;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_assoc_group_by;
use function ImpartialPipes\p_group_by;
use function ImpartialPipes\p_keys;
use function ImpartialPipes\p_map;
use function ImpartialPipes\p_to_array;

/**
 * @internal
 */
final class p_group_by_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_group_by(): void
    {
        []
        |> p_group_by(fn (int $x) => $x % 2)
        |> self::iteratesLike([], rewind: true);

        []
        |> p_assoc_group_by(fn (int $x) => $x % 2)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_group_by(fn (int $x) => $x % 2)
        |> self::iteratesLike([1 => [1, 3], 0 => [2, 4]], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_assoc_group_by(fn (int $x) => $x % 2)
        |> p_map(p_to_array())
        |> self::iteratesLike([1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]], rewind: true);

        ['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4]
        |> p_group_by(fn (int $x, string $k) => $k[0])
        |> self::iteratesLike(['a' => [1, 2], 'b' => [3, 4]], rewind: true);

        ['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4]
        |> p_assoc_group_by(fn (int $x, string $k) => $k[0])
        |> p_map(p_to_array())
        |> self::iteratesLike(['a' => ['a' => 1, 'aa' => 2], 'b' => ['b' => 3, 'bb' => 4]], rewind: true);

        ['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4]
        |> p_group_by(fn (int $x, string $k) => new TestHashableString(substr($k, 0, 1)))
        |> self::iteratesLike(new LazyRewindableIterator(function () {
            yield new TestHashableString('a') => [1, 2];
            yield new TestHashableString('b') => [3, 4];
        }), rewind: true);

        $x = new LazyRewindableIterator(function () {
            yield new TestHashableString('a') => 1;
            yield new TestHashableString('b') => 2;
            yield new TestHashableString('c') => 3;
            yield new TestHashableString('d') => 4;
        })
        |> p_assoc_group_by(fn (int $x) => $x % 2)
        |> p_to_array();

        $x[0] |> self::iteratesLike(new LazyRewindableIterator(function () {
            yield new TestHashableString('b') => 2;
            yield new TestHashableString('d') => 4;
        }), rewind: true);
        $x[1] |> self::iteratesLike(new LazyRewindableIterator(function () {
            yield new TestHashableString('a') => 1;
            yield new TestHashableString('c') => 3;
        }), rewind: true);
    }

    public function test_p_group_by_with_int_like_string_hashes(): void
    {
        ['a' => 1, 'b' => 2, 'c' => 1, 'd' => 2]
        |> p_group_by(fn (int $x) => strval($x))
        |> p_keys()
        |> self::iteratesLike(['1', '2']);

        ['a' => 1, 'b' => 2, 'c' => 1, 'd' => 2]
        |> p_assoc_group_by(fn (int $x) => strval($x))
        |> p_keys()
        |> self::iteratesLike(['1', '2']);
    }
}

class TestHashableString implements Hashable
{
    public function __construct(public readonly string $value)
    {
    }

    #[Override]
    public function hash(): string
    {
        return $this->value;
    }

    #[Override]
    public function equals($obj): bool
    {
        throw new LogicException('not implemented');
    }
}
