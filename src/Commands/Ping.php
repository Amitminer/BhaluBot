<?php

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\BhaluManager;

class Ping {

    private $prefix;

    public function __construct($discord) {
        $this->run($discord);
        $this->prefix = BhaluManager::getPrefix();
    }
    
    private function run($discord) {
        $discord->on('message', function (Message $message) use ($discord) {
            if (strpos($message->content, $this->prefix . 'ping') === 0) {
                $message->channel->sendMessage('Pong!')->done();
            }
        });
    }
}
