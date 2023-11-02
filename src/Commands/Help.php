<?php

declare(strict_types=1);

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\ConfigManager;

class Help {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }

    private function execute(Discord $discord, ?string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if (strpos($message->content, $prefix . 'help') === 0) {
                $helpMessage = "List of available commands:\n";
                $helpMessage .= "**{$prefix}random (your query)** - Generates a random image based on your query.\n";
                $helpMessage .= "**{$prefix}imagine (count) (query.. what to imagine)** - Imagines the specified query and sends an image.\n";
                $helpMessage .= "**{$prefix}ask (what you want to ask)** - Responds to your query.\n";
                $helpMessage .= "**{$prefix}spam (count) (message to spam)** - Sends the specified message multiple times.\n";
                $helpMessage .= "**{$prefix}say (message)** - Sends the specified message.\n";
                $helpMessage .= "**{$prefix}shutdown** - Shuts down the bot for maintenance (bot owners only).\n";

                $message->channel->sendMessage($helpMessage);
            }
        });
    }
}