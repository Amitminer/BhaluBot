<?php

declare(strict_types=1);

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\BhaluManager;

class Say {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }
    
    private function execute(Discord $discord, ?string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if (strpos($message->content, $prefix . 'say') === 0) {
                $args = explode(' ', $message->content);
                if (count($args) > 1) {
                    $response = substr($message->content, strlen($prefix . 'say '));
                    $message->channel->sendMessage($response)->done();
                } else {
                    $message->channel->sendMessage('Error: Please provide a message.')->done();
                }
            }
        });
    }
}