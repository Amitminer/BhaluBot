<?php

namespace Bhalu;

include __DIR__.'/../vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Parts\User\Activity;
use bhalu\Manager\BhaluManager;
use bhalu\libs\LibConfig;
use bhalu\Manager\StatusManager;
use bhalu\Manager\CommandManager;

class BhaluBot {
    
    private $discord;

    public function __construct() {
        $token = BhaluManager::getConfig("token");
        $this->discord = new Discord([
            'token' => $token,
            'intents' => Intents::getDefaultIntents(),
        ]);

        $this->discord->on('ready', function (Discord $discord) {
            echo "Bot is ready!";
            CommandManager::registerAll($discord);
            $this->setActivity();
        });
    }

    public function connect(): void {
        $this->discord->run();
    }

    private function setActivity(): void{
        $playerData = StatusManager::getServerData();
        $players = $playerData['players']['online'] ?? -1;
        $activity = new Activity($this->discord, [
            'name' => "Playing With {$players} players.",
            'type' => Activity::TYPE_PLAYING,
        ]);

        $this->discord->updatePresence($activity);
    }
}

$bot = new BhaluBot();
$bot->connect();