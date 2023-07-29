<?php

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\BhaluManager;

class Shutdown {

    private $prefix;

    public function __construct($discord) {
        $this->run($discord);
        $this->prefix = BhaluManager::getPrefix();
    }
    
    private function run($discord) {
        $discord->on('message', function (Message $message) use ($discord) {
            if (strpos($message->content, $this->prefix . 'shutdown') === 0) {
                $authors = BhaluManager::getAuthors();
                if (in_array($message->author->id, $authors)) {
                    $message->channel->sendMessage('Shutting down...')->done(function () use ($discord) {
                        $discord->close();
                        exit;
                    });
                } else {
                    $message->channel->sendMessage('You do not have permission to use this command.');
                }
            }
        });
    }
}