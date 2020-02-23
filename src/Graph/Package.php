<?php

declare(strict_types=1);

namespace Undepend\Graph;

use function strtolower;

final class Package
{
    /** @var string */
    public $name;
    /** @var bool  */
    public $visited = false;

    public function __construct(string $name)
    {
        $this->name = strtolower($name);
    }
}
