<?php

namespace Adsy2010\LaravelStripeWrapper\Exceptions;

use Exception;
use Throwable;

class StripeScopeRequiredException extends Exception
{
    public function __construct($message = "Must specify at least one scope.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
