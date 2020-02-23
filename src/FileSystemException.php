<?php

declare(strict_types=1);

namespace Undepend;

use RuntimeException;
use function sprintf;

final class FileSystemException extends RuntimeException
{
    public static function fromFileName(string $fileName) : self
    {
        return new self(sprintf(
            'Unable to open file %s, check that it exists and is readable.',
            $fileName
        ));
    }
}
