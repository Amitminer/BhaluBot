<?php

namespace Bhalu\Manager;

use Bhalu\libs\LibConfig;

class BhaluManager{
    
    public function __construct() {
        //NOOP
    }
    
    public  static function connect(){
        echo "connected\n";
    }
    
    public static function getConfig(mixed $value) {
        try {
            $srcDir = dirname(__DIR__) . '/../';
           // var_dump($srcDir);
            $configFilePath = $srcDir . '/config.yml' ?? null;
            $config = new LibConfig($configFilePath);
            $token = $config->get($value);
            $config->save();
            return $token;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }
    public static function getPrefix(): string{
        $prefix = self::getConfig("prefix");
        return $prefix;
    }
    public static function getAuthors(): array{
        $authors = self::getConfig("author-Id");
        return $authors;
    }
    
}