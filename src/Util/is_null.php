<?php

declare(strict_types=1);

namespace ImpartialPipes;

const is_null = __NAMESPACE__ . '\is_null';

function is_null(mixed $x): bool
{
    return null === $x;
}
