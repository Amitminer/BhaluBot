<?php

declare(strict_types = 1);

namespace Bhalu\Manager;

use AmitxD\LibConfig\LibConfig;

class ConfigManager
{
    private const CONFIG_FILE_PATH = '/config.yml';

    private function __construct() {
        // NOOP
    }

    /**
    * @return LibConfig|null
    */
    private static function getYamlConfig(): ?LibConfig
    {
        $configFilePath = dirname(__DIR__) . '/../' . self::CONFIG_FILE_PATH;

        try {
            return new LibConfig($configFilePath);
        } catch (\Exception $e) {
            error_log('Error loading config file: ' . $e->getMessage());
            return null;
        }
    }

    /**
    * @param string $value
    * @return string|int|array<string, string>|null
    */
    public static function getConfigValue(string $value): string|int|array|null
    {
        $config = self::getYamlConfig();
        return $config ? $config->get($value) : null;
    }

    /**
    * @return string|null
    */
    public static function getPrefix(): ?string {
        return ConfigManager::getConfigValue("prefix");
    }

    /**
    * @return array<string, string>
    * @phpstan-return array<string, string>
    */
    public static function getAuthors(): array
    {
        $authors = self::getConfigValue("author-Id");
        // @phpstan-ignore-next-line
        return is_array($authors) ? $authors : [];
    }

    /**
    * @return string|null
    */
    public static function getChatGPTAPI(): ?string
    {
        return $_ENV['CHATGPT_ACCESS_TOKEN'] ?? null;
    }

    /**
    * @return string|null
    */
    public static function getOpenAiKey(): ?string
    {
        return $_ENV['OPENAI_API_KEY'] ?? null;
    }

    /**
    * @return string|null
    */
    public static function getUnSplashKey(): ?string
    {
        return $_ENV['UNSPLASH_ACCESS_KEY'] ?? null;
    }

    /**
    * @return string|null
    */
    public static function getBotToken(): ?string
    {
        return $_ENV['DISCORD_BOT_TOKEN'] ?? null;
    }
}