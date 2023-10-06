<?php

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\ConfigManager;
use Bhalu\Manager\ImageManager;

class RandomImage {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }

    private function execute(Discord $discord, ?string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if (strpos($message->content, $prefix . 'random') === 0) {
                $query = trim(str_replace($prefix . 'random', '', $message->content));

                if (!empty($query)) {
                    $this->generateRandomImage($query, $message);
                } else {
                    $message->reply("Error: You need to provide a query for the random image.")->done();
                }
            }
        });
    }

    private function generateRandomImage(?string $query,
        Message $message): void {
        ImageManager::getRandomImage($query)
        ->then(function ($imagePath) use ($message) {
            var_dump($imagePath);

            $message->channel->broadcastTyping();
            $message->reply(MessageBuilder::new()->addFile($imagePath));
        })
        ->catch(function ($error) use ($message) {

            $message->channel->broadcastTyping();
            $message->reply("Error: $error")->done();
        });
    }
}