<?php

declare(strict_types = 1);

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\ImageManager;

class RandomImage {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }

    private function execute(Discord $discord, ?string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if ($this->isRandomImageCommand($message, $prefix)) {
                $query = $this->extractQuery($message->content, $prefix);

                if (!empty($query)) {
                    $this->sendRandomImage($message, $query);
                } else {
                    $this->replyWithError($message, "You need to provide a query for the random image.");
                }
            }
        });
    }

    private function isRandomImageCommand(Message $message,
        ?string $prefix): bool {
        return strpos($message->content,
            $prefix . 'random') === 0;
    }

    private function extractQuery(string $messageContent,
        ?string $prefix): string {
        return trim(str_replace($prefix . 'random', '', $messageContent));
    }

    private function sendRandomImage(Message $message,
        string $query): void {
        $imagePath = ImageManager::getRandomImage($query);
        if ($imagePath !== null) {
            $this->replyWithImage($message, $imagePath);
        } else {
            ///$this->logError($error);
            $this->replyWithError($message, "Failed to fetch random image.");
        }
    }

    private function replyWithImage(Message $message,
        string $imagePath): void {
        $message->channel->broadcastTyping();
        $message->reply(MessageBuilder::new()->addFile($imagePath));
    }

    private function replyWithError(Message $message,
        string $error): void {
        $message->channel->broadcastTyping();
        $message->reply("Error: $error")->done();
    }
}