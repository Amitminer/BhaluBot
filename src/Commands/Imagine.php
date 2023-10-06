<?php

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\ConfigManager;
use Bhalu\Manager\ImageManager;

class Imagine {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord,$prefix);
    }

    private function execute(Discord $discord,?string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if (strpos($message->content, $prefix . 'imagine') === 0) {

                $parts = explode(' ', $message->content);
                if (count($parts) >= 3) {
                    $howmuchImage = (int) $parts[1];
                    $imagePrompt = implode(' ', array_slice($parts, 2));
                    if ($howmuchImage > 0) {
                        $message->channel->broadcastTyping();
                        $this->sendImage($message, $howmuchImage, $imagePrompt);
                    } else {
                        $message->reply('Invalid number of images. Please provide a positive integer.')->done();
                    }
                } else {
                    $message->reply('Invalid command format. Please use: ' . $prefix . 'imagine <number of images> <image prompt>')->done();
                }
            }
        });
    }

    private function sendImage(Message $message,
        int $count,
        string $imagePrompt): void {
        // Generate and get the images data
        if ($count > 5) {
            $message->reply('You cant generate image more than 5..')->done();
            return;
        }
        $imagesData = ImageManager::generateImage($imagePrompt, $count);

        if ($imagesData) {
            foreach ($imagesData as $imagePath) {

                $message->reply(MessageBuilder::new()->addFile($imagePath));
            }
        } else {
            $message->reply('Failed to generate images.')->done();
        }
    }
}