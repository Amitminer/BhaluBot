<?php

declare(strict_types=1);

namespace Bhalu\Utils;

/**
 * Trait Colors
 *
 * This trait provides constants for ANSI escape codes
 * representing different colors for console output.
 */
trait Colors {
    // ANSI escape codes for text colors
    
    /** Reset color to default: Colors::RESET */
    public const RESET = "\033[0m";

    /** Black text: Colors::BLACK */
    public const BLACK = "\033[30m";

    /** Red text: Colors::RED */
    public const RED = "\033[31m";

    /** Green text: Colors::GREEN */
    public const GREEN = "\033[32m";

    /** Yellow text: Colors::YELLOW */
    public const YELLOW = "\033[33m";

    /** Blue text: Colors::BLUE */
    public const BLUE = "\033[34m";

    /** Magenta text: Colors::MAGENTA */
    public const MAGENTA = "\033[35m";

    /** Cyan text: Colors::CYAN */
    public const CYAN = "\033[36m";

    /** White text: Colors::WHITE */
    public const WHITE = "\033[37m";
}