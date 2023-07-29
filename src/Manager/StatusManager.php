<?php

namespace Bhalu\Manager;

use Bhalu\Manager\BhaluManager;
use file_get_contents;
use json_decode;
use in_array;

class StatusManager {
    
    public const URL = "https://api.mcstatus.io/v2/status/";

    public function __construct() {
        // NOOP (No operation)
    }

    public static function getServerData() : array {
        $type = self::getServerType() ?? 'bedrock';
        $ip = self::getServerIP() ?? 'cubecraft.net';
        $port = self::getServerPort() ?? 19132;
        $server = "{$type}/{$ip}:{$port}";
       // var_dump($server);
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
        return strtolower(BhaluManager::getConfig("server-type")) ?? null;
    }

    public static function getServerIP(): ?string {
        $ip = BhaluManager::getConfig("server-ip");
        return is_string($ip) ? $ip : null;
    }

    public static function getServerPort(): ?int {
        $port = BhaluManager::getConfig("server-port");
        return is_int($port) ? $port : null;
    }
}
