<?php

declare(strict_types=1);

namespace Bhalu\Manager;

include dirname(__DIR__) . '/../vendor/autoload.php';

use Discord\Discord;
use HaoZiTeam\ChatGPT\V1 as ChatGPTV1;

class ChatManager {

    /**
     * ChatManager constructor.
     */
    public function __construct() {
        // NOOP (No operation)
    }

    /**
     * Method to get response from ChatGPT API
     * @param string|null $question
     * @return string|null
     */
    public static function getChatGPT(?string $question): ?string {
        try {
            $chatGPT = new ChatGPTV1();
            $chatGPT->addAccount(ConfigManager::getChatGPTAPI());
            $answers = $chatGPT->ask($question);
            $resolvedAnswers = '';

            foreach ($answers as $result) {
                $resolvedAnswers = $result['answer'];
            }

            return $resolvedAnswers;
        } catch (\Exception $e) {
            // Handle exceptions, return null for failure
            return null;
        }
    }
}