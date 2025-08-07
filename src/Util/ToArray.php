<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @internal
 * @template K
 * @template V
 */
interface ToArray
{
    /**
     * @return array<K,V>
     */
    public function toArray(): array;
}
