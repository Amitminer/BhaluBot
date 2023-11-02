<?php

declare(strict_types=1);

namespace Bhalu\Manager;

use Discord\Parts\User\Activity;
use Discord\Discord as DiscordClient;

class BhaluManager {

    public function __construct() {
        // No operation (NOOP)
    }

    public static function connect(): void {
        echo "Connected\n";
    }
    
    public static function setActivity(DiscordClient $discord): void {
        $playerData = StatusManager::getServerData();
        $players = $playerData['players']['online'] ?? -1;
        $activity = new Activity($discord, [
            'status' => 'dnd',
            'name' => "Playing With {$players} players.",
            'type' => Activity::TYPE_PLAYING,
        ]);

        $discord->updatePresence($activity);
    }
}