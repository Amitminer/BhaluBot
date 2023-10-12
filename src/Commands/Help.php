<?php

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
                // im soo lazzy to update help command..
                $helpMessage = "List of available commands:\n";
                $helpMessage .= "{$prefix}say give command to say something...\n";
                $helpMessage .= "{$prefix}purge user total - Purge messages sent by a specific user.\n";
                $helpMessage .= "{$prefix}purge 10 - Purge the last 10 messages in the channel.\n";
                $helpMessage .= "{$prefix}purge all - Purge all messages in the channel.\n";
                $helpMessage .= "{$prefix}purge bot all - Purge all messages sent by the bot in the channel.\n";
                $helpMessage .= "{$prefix}shutdown - Shutdown the bot (only accessible to bot owners).\n";

                $message->channel->sendMessage($helpMessage);
            }
        });
    }
}
