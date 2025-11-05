<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Tapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_map;
use function ImpartialPipes\p_take;
use function ImpartialPipes\p_unfold;
use function ImpartialPipes\p_while_not_null;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_unfold_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_tap(): void
    {
        pipe(0)
        ->to(p_unfold(static fn (int $x) => $x + 1))
        ->to(p_take(5))
        ->to(self::iteratesLike([0, 1, 2, 3, 4], rewind: true));

        pipe(new TestUnfoldNode(0, new TestUnfoldNode(1, new TestUnfoldNode(2, new TestUnfoldNode(3, new TestUnfoldNode(4))))))
        // @phpstan-ignore argument.type
        ->to(p_unfold(static fn (?TestUnfoldNode $x) => $x?->next))
        ->to(p_while_not_null())
        // @phpstan-ignore argument.type
        ->to(p_map(static fn (TestUnfoldNode $x) => $x->x))
        ->to(self::iteratesLike([0, 1, 2, 3, 4], rewind: true));
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
