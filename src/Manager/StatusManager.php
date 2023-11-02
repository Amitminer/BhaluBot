<?php

declare(strict_types=1);

namespace Bhalu\Manager;

use Bhalu\Manager\ConfigManager;
use file_get_contents;
use json_decode;
use in_array;

class StatusManager {

    public const URL = "https://api.mcstatus.io/v2/status/";

    public function __construct() {
        // NOOP (No operation)
    }

    /**
    * Gets server data from the API.
    *
    * @return array<string, mixed>|null The server data as an associative array, or null if there was an error.
    */
    public static function getServerData() : ?array {
        $type = self::getServerType() ?? 'bedrock';
        $ip = self::getServerIP() ?? 'cubecraft.net';
        $port = self::getServerPort() ?? 19132;
        $server = "{$type}/{$ip}:{$port}";
        //var_dump($server);
        $serverResponse = file_get_contents(self::URL . $server);
        // var_dump($serverResponse);
        if ($serverResponse === false) {
            return [];
        }

        $data = json_decode($serverResponse, true);

        if ($data !== null && is_array($data)) {
            return $data;
        } else {
            return [];
        }
    }

    public static function getServerType(): ?string {
        return strtolower(ConfigManager::getConfigValue("server-type"));
    }

    public static function getServerIP(): ?string {
        $ip = ConfigManager::getConfigValue("server-ip");
        return is_string($ip) ? $ip : null;
    }

    public static function getServerPort(): ?int {
        $port = ConfigManager::getConfigValue("server-port");
        return intval($port);
    }
}