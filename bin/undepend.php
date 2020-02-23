<?php

declare(strict_types=1);

use Undepend\Runner;

(static function (array $arguments, callable $autoload) : void {
    $autoload([
        __DIR__ . '/../../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/vendor/autoload.php',
    ]);

    $composerJson = $arguments[1] ?? 'composer.json';
    $copmoserLock = $arguments[2] ?? 'composer.lock';

    $result = Runner::fromFileLocation($composerJson, $copmoserLock)->run();

    if ($result === []) {
        exit(0);
    }

    foreach ($result as $unused) {
        echo sprintf(
            'Found unused dependency: "%s"%s',
            $unused,
            PHP_EOL
        );
    }

    exit(1);
})($argv, static function (array $files) : void {
    foreach ($files as $file) {
        if (file_exists($file)) {
            require_once $file;

            return;
        }
    }

    fwrite(
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );
    exit(1);
});
