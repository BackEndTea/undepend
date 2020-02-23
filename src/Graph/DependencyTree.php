<?php

declare(strict_types=1);

namespace Undepend\Graph;

use function array_filter;
use function array_map;

final class DependencyTree
{
    /** @var array<string, Package> */
    public $packages = [];
    /** @var array<int, Dependency> */
    public $dependencies = [];

    public function addPackage(Package $node) : void
    {
        $this->packages[$node->name] = $node;
    }

    public function addDependency(Dependency $edge) : void
    {
        $this->dependencies[] = $edge;
    }

    /**
     * @return array<string>
     */
    public function findUnvisited() : array
    {
        $this->doVisit('__root__');

        return array_map(
            static function (Package $node) : string {
                return $node->name;
            },
            array_filter($this->packages, static function (Package $package) : bool {
                return ! $package->visited;
            })
        );
    }

    private function doVisit(string $node) : void
    {
        if (! isset($this->packages[$node]) || $this->packages[$node]->visited) {
            return;
        }

        $this->packages[$node]->visited = true;
        foreach ($this->dependencies as $edge) {
            if ($edge->from !== $node) {
                continue;
            }

            $this->doVisit($edge->to);
        }
    }
}
