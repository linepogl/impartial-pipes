<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Tapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_map;
use function ImpartialPipes\p_take;
use function ImpartialPipes\p_unfold;
use function ImpartialPipes\p_while_not_null;

/**
 * @internal
 */
final class p_unfold_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_tap(): void
    {
        0
        |> p_unfold(static fn (int $x) => $x + 1)
        |> p_take(5)
        |> self::iteratesLike([0, 1, 2, 3, 4], rewind: true);

        new TestUnfoldNode(0, new TestUnfoldNode(1, new TestUnfoldNode(2, new TestUnfoldNode(3, new TestUnfoldNode(4)))))
        |> p_unfold(static fn (?TestUnfoldNode $x) => $x?->next) // @phpstan-ignore argument.type
        |> p_while_not_null()
        |> p_map(static fn (TestUnfoldNode $x) => $x->x) // @phpstan-ignore argument.type
        |> self::iteratesLike([0, 1, 2, 3, 4], rewind: true);
    }
}

class TestUnfoldNode
{
    public function __construct(
        public readonly int $x,
        public readonly ?TestUnfoldNode $next = null,
    ) {
    }
}
