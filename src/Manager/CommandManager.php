<?php

namespace Bhalu\Manager;

use Bhalu\libs\LibConfig;
use Bhalu\Commands\Shutdown;
use Bhalu\Commands\Ping;

class CommandManager{
    
    public function __construct() {
       //NOOP
    }
    // I really hate slash cmds.._.
    public static function registerAll($discord){
        $shutdown = new shutdown($discord);
        $ping = new Ping($discord);
    }
}
