<?php

namespace Bhalu\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\BhaluManager;
use vennv\vapm\simultaneous\Promise;

class Spam {

    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }

    private function execute(Discord $discord, ?string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if (strpos($message->content, $prefix . 'spam') === 0) {
                $args = explode(' ', $message->content);
                if (count($args) >= 3) {
                    $this->handleSpamRequest($message, $args, $prefix);
                } else {
                    $this->sendErrorMessage($message, 'Invalid usage. Correct format: ' . $prefix . 'spam (count) (message)');
                }
            }
        });
    }

    /**
    * Handles the spam request by sending multiple messages to the channel.
    *
    * @param Message $message The Discord message object.
    * @param array<int, string> $args An array containing the command arguments.
    * @param string|null $prefix The command prefix.
    *
    * @return void
    */
    private function handleSpamRequest(Message $message,
        array $args,
        ?string $prefix): void {
        $count = intval($args[1]);

        if ($count <= 0 || $count > 50) {
            $this->sendErrorMessage($message, 'Count must be a positive number and smaller than or equal to 50.');
            return;
        }

        $response = implode(' ', array_slice($args, 2));

        $promises = [];
        for ($i = 0; $i < $count; $i++) {
            $promises[] = $message->channel->sendMessage($response);
        }

        Promise::all($promises)->then(
            function () {
                //echo 'All messages sent successfully!';
            }
        );
    }

    private function sendErrorMessage(Message $message, string $error): void {
        $message->channel->sendMessage('Error: ' . $error)->done();
    }
}