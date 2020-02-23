<?php

declare(strict_types=1);

namespace Undepend\Graph;

use function strtolower;

final class Dependency
{
    /** @var string */
    public $from;

    /** @var string */
    public $to;

    public function __construct(string $from, string $to)
    {
        $this->from = strtolower($from);
        $this->to   = strtolower($to);
    }
}
