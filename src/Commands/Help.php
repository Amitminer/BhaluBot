<?php

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\BhaluManager;

class Help {

    private $prefix;

    public function __construct($discord) {
        $this->run($discord);
        $this->prefix = BhaluManager::getPrefix();
    }

    private function run($discord) {
        $discord->on('message', function (Message $message){
            if (strpos($message->content, $this->prefix . 'help') === 0) {
                $helpMessage = "List of available commands:\n";
                $helpMessage .= "{$this->prefix}ping - Check if the bot is online.\n";
                $helpMessage .= "{$this->prefix}purge user total - Purge messages sent by a specific user.\n";
                $helpMessage .= "{$this->prefix}purge 10 - Purge the last 10 messages in the channel.\n";
                $helpMessage .= "{$this->prefix}purge all - Purge all messages in the channel.\n";
                $helpMessage .= "{$this->prefix}purge bot all - Purge all messages sent by the bot in the channel.\n";
                $helpMessage .= "{$this->prefix}shutdown - Shutdown the bot (only accessible to bot owners).\n";

                $message->channel->sendMessage($helpMessage);
            }
        });
    }
}
