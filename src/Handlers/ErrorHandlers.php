<?php

declare(strict_types=1);

namespace Bhalu\Handlers;

use Exception;
use Throwable;

abstract class ErrorHandlers extends Exception {
    abstract public function setErrorMessage(): string;
    // TODO
}