<?php

declare(strict_types = 1);

namespace Bhalu\Utils;

trait BhaluConsts
{
    /** Playing {name} */
    public const TYPE_GAME = 0;

    /** Streaming {details} */
    public const TYPE_STREAMING = 1;

    /** Listening to {name} */
    public const TYPE_LISTENING = 2;

    /** Watching {name} */
    public const TYPE_WATCHING = 3;

    /** {emoji} {name} */
    public const TYPE_CUSTOM = 4;

    /** Competing in {name} */
    public const TYPE_COMPETING = 5;
    
    /** Fetch Online Players from mc server */
    public const TYPE_SERVER_STATUS = self::TYPE_GAME;
}