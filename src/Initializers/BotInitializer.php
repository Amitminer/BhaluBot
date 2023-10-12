<?php

declare(strict_types = 1);

namespace Bhalu\Initializers;

require dirname(__DIR__) . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bhalu\Utils\Colors;
use Discord\Discord as DiscordClient;
use Discord\WebSockets\Intents;
use Discord\Parts\User\Activity;
use Bhalu\Manager\BhaluManager;
use Bhalu\Manager\CommandManager;
use Bhalu\Manager\ConfigManager;

/**
* Class BotInitializer
*/
class BotInitializer {
    use Colors;

    /**
    * Discord client instance.
    * @var DiscordClient
    */
    private DiscordClient $discord;

    /**
    * Initialize the bot.
    *
    * @throws \Exception If an error occurs during bot initialization.
    */
    private function init(): void {
        self::loadDotenv();
        $token = ConfigManager::getBotToken();
        $this->discord = new DiscordClient([
            'token' => $token,
            'intents' => Intents::getDefaultIntents(),
        ]);

        $this->discord->on('ready', function (DiscordClient $discord) {
            CommandManager::registerAll($discord);
            BhaluManager::setActivity($discord);
            self::sendLoginMessage($discord);
        });
       # $this->discord->run();
    }

    /**
    * Load environment variables from .env file.
    */
    private static function loadDotenv(): void {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__)  . '/../');
        $dotenv->load();
    }

    /**
    * Send login message to console.
    *
    * @param DiscordClient $discord Discord client instance.
    */
    private static function sendLoginMessage(DiscordClient $discord): void {
        $green = self::GREEN;
        $yellow = self::YELLOW;
        $blue = self::BLUE;
        $reset = self::RESET;

        echo $green . "Bot is Now Online!\n";
        echo $green . "Logged in as " . $yellow . $discord->user->username . $reset . "\n";
        echo $blue . "Made by AmitxD" . $reset . "\n";
    }
    
    public function connect(): void {
        $this->init();
        $this->discord->run();
    }

    public function close(): void {
        $this->discord->close();
    }
}