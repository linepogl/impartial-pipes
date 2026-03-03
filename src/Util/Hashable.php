<?php

declare(strict_types=1);

namespace ImpartialPipes;

interface Hashable
{
    public function hash(): int|string;
}
