<?php

declare(strict_types=1);

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\ConfigManager;

class Shutdown {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }

    private function execute(Discord $discord, ?string $prefix): void {
        $discord->on('message', function (Message $message) use ($discord,$prefix) {
            $shutdown = 'shutdown';
            $shut = 'shut';
            if (strpos($message->content, $prefix . $shutdown) === 0 || strpos($message->content, $prefix . $shut) === 0) {
                $authors = ConfigManager::getAuthors();
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