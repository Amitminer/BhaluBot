<?php

declare(strict_types = 1);

namespace Bhalu\Commands;

include dirname(__DIR__) . '/../vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\ChatManager;
use vennv\vapm\simultaneous\Promise;
use vennv\vapm\simultaneous\Async;

class Ask {

    /**
    * Ask constructor.
    *
    * @param Discord $discord The Discord instance.
    * @param string|null $prefix The command prefix.
    */
    public function __construct(Discord $discord, ?string $prefix) {
        $this->execute($discord, $prefix);
    }

    /**
    * Set up event listener for 'message' event.
    *
    * @param Discord $discord The Discord instance.
    * @param string $prefix The command prefix.
    */
    private function execute(Discord $discord, string $prefix): void {
        $discord->on('message', function (Message $message) use ($prefix) {
            if (self::startsWith($message->content, $prefix . 'ask')) {
                $question = trim(substr($message->content, strlen($prefix . 'ask')));
                if (!empty($question)) {
                    self::getAnswer($question, $message);
                } else {
                    $message->reply('Please provide a question.')->done();
                }
            }
        });
    }

    /**
    * Check if a string starts with a specific substring.
    *
    * @param string $haystack The string to search in.
    * @param string $needle The substring to search for.
    * @return bool True if $haystack starts with $needle, false otherwise.
    */
    private static function startsWith(string $haystack,
        string $needle): bool {
        return strncmp($haystack,
            $needle,
            strlen($needle)) === 0;
    }

    /**
    * Handle the response from ChatGPT.
    *
    * @param string $chatGPTResponse The response from ChatGPT.
    * @param Message $message The Discord message object.
    * @param callable $resolve The resolve function for the Promise.
    * @param callable $reject The reject function for the Promise.
    */
    private static function handleGPTResponse(string $chatGPTResponse,
        Message $message,
        callable $resolve,
        callable $reject): void {
        if ($chatGPTResponse) {
            // Split the response into chunks of 2000 characters
            $chunks = str_split($chatGPTResponse, 2000);

            // Send each chunk as a separate message
            foreach ($chunks as $chunk) {
                $message->reply($chunk)->done();
            }

            $resolve('Response sent successfully.');
        } else {
            $reject('Failed to get answer from ChatGPT');
        }
    }

    /**
    * Get an answer asynchronously from ChatGPT.
    *
    * @param string|null $question The question to ask ChatGPT.
    * @param Message $message The Discord message object.
    * @return Promise The Promise resolving with the response from ChatGPT.
    */
    public static function getAnswer(?string $question, Message $message): Promise {
        return new Promise(function (callable $resolve, callable $reject) use ($question, $message) {
            new Async(function () use ($question, $resolve, $reject, $message) {
                $chatGPTResponse = Async::await(ChatManager::getChatGPT($question));
                Ask::handleGPTResponse($chatGPTResponse, $message, $resolve, $reject);
            });
        });
    }
}
