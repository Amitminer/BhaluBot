<?php

declare(strict_types = 1);

namespace Bhalu\Manager;

include dirname(__DIR__) . '/../vendor/autoload.php';

use Krisciunas\OpenAi\Persist\ImagesPersist;
use Krisciunas\OpenAi\Api\ImagePrompt;
use Krisciunas\OpenAi\Api\GenerateImageCommand;
use Exception;

class ImageManager {

    /**
    * @param string $imagePrompt
    * @param int $limit
    * @return array<string, string>|null
    */
    public static function generateImage(string $imagePrompt, int $limit = 1): ?array {
        $authorizationToken = ConfigManager::getOpenAiKey();

        // Generate images
        $imagesGeneration = new GenerateImageCommand();
        $imagesData = $imagesGeneration->execute($authorizationToken,
            new ImagePrompt(
                strval($imagePrompt),
                $limit,
                ImagePrompt::SIZE_256x256,
                ImagePrompt::FORMAT_URL
            )
        );

        $srcDir = dirname(__DIR__) . '/../';
        $imagesPersistor = new ImagesPersist($srcDir . 'tmp' . DIRECTORY_SEPARATOR);
        return $imagesPersistor->persist($imagesData, 'Image_%s.png');
    }

    public static function getRandomImage(?string $query): ?string {
        try {
            $accessKey = ConfigManager::getUnSplashKey();
            $encodedQuery = urlencode($query);
            $url = "https://api.unsplash.com/photos/random?client_id=$accessKey&query=$encodedQuery";

            $response = file_get_contents($url);

            if ($response === false) {
                throw new Exception("Failed to fetch image");
            }

            $jsonData = json_decode($response, true);

            if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON response: " . json_last_error_msg());
            }

            if (!isset($jsonData['urls']['regular'])) {
                throw new Exception("Invalid JSON structure: 'urls' or 'regular' key not found");
            }
            $imagePath = ImageManager::saveRandomImage($jsonData);
            return $imagePath;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
    * @param array<string, mixed> $jsonData
    * @return string|null
    */
    private static function saveRandomImage(array $jsonData): ?string {
        $imageUrl = $jsonData['urls']['regular'];
        $srcDir = dirname(__DIR__) . '/../';
        $tmpDir = $srcDir . 'tmp' . DIRECTORY_SEPARATOR;

        $imageName = 'randomImage.png';
        $imagePath = $tmpDir . $imageName;

        try {
            $fileContent = file_get_contents($imageUrl);
            file_put_contents($imagePath,
                $fileContent);
            return $imagePath;
        } catch (Exception $e) {
            return null;
        }
    }
}