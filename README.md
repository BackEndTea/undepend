# Undepend

Undepend lets you find orphaned dependencies in your composer lock file

## Installation

Installation is done trough [composer](https://getcomposer.org/)

```
$ composer require --dev backendtea/undepend
```

## Usage

```
$ vendor/bin/undepend
```
The command will exit with 0 if you have no orphaned dependencies.

If you do have some, it will exit with 1 and give you all dependencies that are orphaned.

You can specify another composer.json and lock file to use like so:

```
$ vendor/bin/undepend /path/to/composer.json /path/to/composer.lock
```
