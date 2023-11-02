<?php

declare(strict_types=1);

namespace Bhalu\Manager;

use Discord\Discord;

class CommandManager {

    /**
    * Array of available commands.
    *
    * @var string[] List of available command names.
    */
    private static array $Commands = [
        "Shutdown",
        "Say",
        "Help",
        "Ask",
        "RandomImage",
        "Imagine",
        "Spam"
    ];

    public function __construct() {
        // NOOP (No operation)
    }

    public static function registerAll(Discord $discord): void {
        try {
            foreach (self::$Commands as $commandName) {
                $commandClass = "Bhalu\\Commands\\{$commandName}";
                $prefix = ConfigManager::getPrefix();
                new $commandClass($discord, $prefix);
            }
        } catch (\Exception $e) {
            echo 'Error while registering commands: ' . $e->getMessage();
        }
    }
}