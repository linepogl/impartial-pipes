<?php

declare(strict_types=1);

namespace ImpartialPipes;

const is_not_null = __NAMESPACE__ . '\is_not_null';

function is_not_null(mixed $x): bool
{
    return null !== $x;
}
