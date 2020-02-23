<?php

declare(strict_types=1);

namespace Undepend;

use function file_get_contents;

class FileSystem
{
    public static function getFile(string $fileName) : string
    {
        $content = @file_get_contents($fileName);
        if ($content === false) {
            throw FileSystemException::fromFileName($fileName);
        }

        return $content;
    }
}
