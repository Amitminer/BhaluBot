<?php

declare(strict_types=1);

namespace Bhalu;

trait VersionInfo {

    private static string $version = '2.0.0';
    private static string $releaseDate = '2023-02-14';

    public static function getVersion(): string {
        return self::$version;
    }

    public static function getReleaseDate(): string {
        return self::$releaseDate;
    }
}