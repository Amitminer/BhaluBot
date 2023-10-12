<?php

declare(strict_types = 1);

namespace Bhalu;

include __DIR__.'/../vendor/autoload.php';

use Bhalu\Initializers\BotInitializer;

class BhaluBot {
    
    public function __construct() {
        // NOOP
    }

    /**
     * Run the Discord bot.
     *
     * @param bool $onOrOff Specifies whether the bot should be turned on or off.
     */
    public static function run(bool $onOrOff): void {
        $bhaluInit = new BotInitializer();
        try {
            if ($onOrOff) {
                $bhaluInit->connect();
                // Bot connected successfully
                echo "Bot connected!";
            } else {
                $bhaluInit->close();
                // Bot closed successfully
                echo "Bot closed.";
            }
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }
}

$bot = new BhaluBot();
$bot->run(true);