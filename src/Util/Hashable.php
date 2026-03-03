<?php

declare(strict_types=1);

namespace Util;

interface Hashable
{
    public function hash(): int|string;
}
