<?php

namespace Bhalu\Manager;

use Bhalu\libs\LibConfig;

class BhaluManager {

    public function __construct() {
        // No operation (NOOP)
    }

    public static function connect(): void {
        echo "Connected\n";
    }

    public static function getConfig(string $value): ?string {
        try {
            $config = self::getYamlFile("/config.yml");
            return $config->get($value);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    private static function getYamlFile(string $fileName): LibConfig {
        $srcDir = dirname(__DIR__) . '/../';
        $dataFilePath = $srcDir . $fileName;
        return new LibConfig($dataFilePath);
    }

    public static function saveChatBotChannelId(int $channelId): void {
        $config = self::getChannelConfig();
        $config->set("channels", $channelId);
        $config->save();
    }

    public static function getChannelConfig(): LibConfig {
        return self::getYamlFile("/channels.yml");
    }

    public static function getSavedChannel(): int {
        $config = self::getChannelConfig();
        return $config->get("channelID");
    }

    public static function getPrefix(): string {
        return self::getConfig("prefix");
    }

    public static function getAuthors(): array|string {
        $authors = self::getConfig("author-Id");
        return $authors;
    }

    public static function getChatGPTAPI(): ?string {
        return self::getConfig("chatGPT-api-token");
    }
}