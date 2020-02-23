<?php

declare(strict_types=1);

namespace Undepend;

use Exception;
use Undepend\Graph\Dependency;
use Undepend\Graph\DependencyTree;
use Undepend\Graph\Package;
use function array_keys;
use function array_merge;
use function file_get_contents;
use function json_decode;
use const JSON_THROW_ON_ERROR;

final class Runner
{
    /** @var string */
    private $composerJson;
    /** @var string */
    private $composerLock;

    public function __construct(string $composerJson, string $composerLock)
    {
        $this->composerJson = $composerJson;
        $this->composerLock = $composerLock;
    }

    public static function fromFileLocation(string $json, string $lock) : self
    {
        $json = file_get_contents($json);
        $lock = file_get_contents($lock);

        if ($json === false || $lock === false) {
            throw new Exception('Unable to read the composer.json or lock file.');
        }

        return new self($json, $lock);
    }

    /**
     * @return array<string>
     */
    public function run() : array
    {
        /** @var array{require: array<string,string>, require-dev: array<string,string>} $json */
        $json     = json_decode($this->composerJson, true, 512, JSON_THROW_ON_ERROR);
        $packages = array_keys(array_merge($json['require'] ?? [], $json['require-dev'] ?? []));

        $graph = new DependencyTree();
        $graph->addPackage(new Package('__ROOT__'));

        foreach ($packages as $package) {
            $graph->addDependency(new Dependency('__ROOT__', $package));
        }

        /** @var array{
         *     packages: array<array{name:string, require:array<string,string>}>,
         *     packages-dev: array<array{name:string, require:array<string,string>}>
         * } $locked
         */
        $locked         = json_decode($this->composerLock, true, 512, JSON_THROW_ON_ERROR);
        $lockedPackages = array_merge($locked['packages'] ?? [], $locked['packages-dev'] ?? []);

        foreach ($lockedPackages as $lockedPackage) {
            $graph->addPackage(new Package($lockedPackage['name']));
            foreach ($lockedPackage['require'] ?? [] as $req => $val) {
                $graph->addDependency(new Dependency($lockedPackage['name'], $req));
            }
        }

        return $graph->findUnvisited();
    }
}
