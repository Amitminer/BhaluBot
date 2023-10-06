<?php

declare(strict_types = 1);

namespace Bhalu\Manager;

include dirname(__DIR__) . '/../vendor/autoload.php';

use Krisciunas\OpenAi\Persist\ImagesPersist;
use Krisciunas\OpenAi\Api\ImagePrompt;
use Krisciunas\OpenAi\Api\GenerateImageCommand;
use vennv\vapm\System;
use vennv\vapm\simultaneous\Promise;

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

    /**
    * @param string|null $query
    * @return Promise|null
    */
    public static function getRandomImage(?string $query): ?Promise {
        return new Promise(function (callable $resolve, callable $reject) use ($query) {
            $accessKey = ConfigManager::getUnSplashKey();
            $encodedQuery = urlencode($query);
            $url = "https://api.unsplash.com/photos/random?client_id=$accessKey&query=$encodedQuery";

            System::fetch($url)
            ->then(function($response) use ($resolve, $reject) {
                $jsonData = json_decode($response, true);
                // Debug: Print JSON data for inspection
                var_dump($jsonData);

                if (!isset($jsonData['urls']['regular'])) {
                    $reject("Invalid JSON response");
                } else {
                    $imagePath = self::saveRandomImg($jsonData);
                    // Debug: Print image path for inspection
                    var_dump($imagePath);

                    if (!$imagePath) {
                        $reject("Failed to save image");
                    } else {
                        $resolve($imagePath);
                    }
                }
            })
            ->catch(function($reason) use ($reject) {
                // Debug: Print reason for rejection
                var_dump($reason);

                $reject($reason);
            });
        });
    }

    /**
    * @param array<string, mixed> $jsonData
    * @return string|null
    */
    private static function saveRandomImg(array $jsonData): string|null {
        $imageUrl = $jsonData['urls']['regular'];

        $srcDir = dirname(__DIR__) . '/../';
        $tmpDir = $srcDir . 'tmp' . DIRECTORY_SEPARATOR;

        $imageName = 'randomImage.png';
        $imagePath = $tmpDir . $imageName;

        if (copy($imageUrl, $imagePath)) {
            return $imagePath;
        } else {
            return null;
        }
    }
}