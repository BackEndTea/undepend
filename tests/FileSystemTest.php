<?php

declare(strict_types=1);

namespace Undepend;

use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{
    public function testItGetsContent() : void
    {
        $this->assertSame("foo\n", FileSystem::getFile(__DIR__ . '/Fixtures/fake.txt'));
    }

    public function testItThrowsWhenFileNotfound() : void
    {
        $this->expectException(FileSystemException::class);
        FileSystem::getFile('asdfasdf');
    }
}
