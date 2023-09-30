<?php

namespace Bhalu\Manager;

use Discord\Discord;

class CommandManager {
    
    private static $Commands = [
        "Shutdown",
        "Ping",
        "Help",
        "Ask"
    ];
    
    public function __construct() {
        // NOOP (No operation)
    }
    
    public static function registerAll(Discord $discord) {
        try {
            foreach (self::$Commands as $commandName) {
                $commandClass = "Bhalu\\Commands\\{$commandName}";
                new $commandClass($discord);
            }
        } catch (\Exception $e) {
            echo 'Error while registering commands: ' . $e->getMessage();
        }
    }
}