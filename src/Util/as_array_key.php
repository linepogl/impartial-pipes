<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Ds\Hashable;
use InvalidArgumentException;

function as_array_key(mixed $input): int|string
{
    $hash = is_object($input)
        ? ($input instanceof Hashable ? $input->hash() : spl_object_hash($input))
        : $input;

    return match(true) {
        is_string($hash) || is_int($hash) => $hash,
        is_float($hash) => strval($hash),
        is_bool($hash) => $hash ? 1 : 0,
        default => throw new InvalidArgumentException('Cannot get a hash for input type: ' . get_debug_type($hash)),
    };
}
