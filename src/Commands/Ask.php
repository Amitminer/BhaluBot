<?php

namespace Bhalu\Commands;

include dirname(__DIR__) . '/../vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Bhalu\Manager\BhaluManager;
use Bhalu\Manager\ChatManager;
use vennv\vapm\simultaneous\Promise;
use vennv\vapm\simultaneous\Async;

class Ask {

    /**
    * Ask constructor.
    * @param Discord $discord
    */
    public function __construct($discord) {
        $this->run($discord);
    }

    /**
    * Set up event listener for 'message' event
    * @param Discord $discord
    */
    private function run($discord) {
        $discord->on('message', function (Message $message) {
            $prefix = BhaluManager::getPrefix();
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

    private static function startsWith($haystack,
        $needle) {
        return strncmp($haystack,
            $needle,
            strlen($needle)) === 0;
    }

    /**
    * Method to get an answer asynchronously
    * @param string|null $question
    * @param Message $message
    * @return Promise
    */
    public static function getAnswer(?string $question,
        $message): Promise
    {
        return new Promise(function (callable $resolve, callable $reject) use ($question, $message) {
            // Perform asynchronous operation inside Async block
            new Async(function () use ($question, $resolve, $reject, $message) {
                // Await the ChatGPT response asynchronously
                $result = Async::await(ChatManager::getChatGPT($question));
                if ($result) {
                    $resolve($result);
                    $message->reply($result)->done();
                } else {
                    // If failed, reject the promise
                    $reject('Failed to get answer from ChatGPT');
                }
            });
        });
    }
}