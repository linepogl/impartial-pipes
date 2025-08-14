<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function unfolds an input into an iterable with a repetitive step function.
 *
 * ### Syntax:
 * ```
 * p_unfold(
 *     callable(TValue[, int]):TValue
 * )
 * ```
 *
 * ### Examples:
 *
 * Iterating a range, equivalent of `fpr($i = 0; $i < 5; $i++)`
 * ```
 * 0
 * |> p_unfold(static fn (int $x) => $x + 1)
 * |> p_take(5)
 * //= [0, 1, 2, 3, 4]
 * ```
 *
 * Iterating a linked list, equivalent of `fpr($node = $head; $node !== null; $node = $node->next())`
 * ```
 * $head
 * |> p_unfold(static fn (Node $node) => $node->next)
 * |> p_while_not_null()
 * ```
 *
 * @template V
 * @param callable(V,int):V $step
 * @return callable(V):iterable<int<0, max>, V>
 */
function p_unfold(callable $step): callable
{
    return static fn (mixed $input) => new LazyRewindableIterator(static function () use ($input, $step): iterable {
        $i = 0;
        for ($x = $input; ; $x = $step($x, $i++)) {
            yield $x;
        }
    });
}
