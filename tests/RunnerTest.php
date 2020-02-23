<?php

declare(strict_types=1);

namespace Undepend;

use PHPUnit\Framework\TestCase;

final class RunnerTest extends TestCase
{
    public function testThisPackageHasNoUnusedDependencies() : void
    {
        $runner = Runner::fromFileLocation(__DIR__ . '/../composer.json', __DIR__ . '/../composer.lock');
        $this->assertSame([], $runner->run());
    }

    public function testItCanFindUnusedDependencies() : void
    {
        $runner = Runner::fromFileLocation(__DIR__ . '/Fixtures/fake_composer.json', __DIR__ . '/Fixtures/fake_composer.lock');
        $this->assertSame(['webmozart/path-util_2' => 'webmozart/path-util_2'], $runner->run());
    }
}
