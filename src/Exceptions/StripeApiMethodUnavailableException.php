<?php

namespace Adsy2010\LaravelStripeWrapper\Exceptions;

use Exception;
use Throwable;

class StripeApiMethodUnavailableException extends Exception
{
    public function __construct($message = "Stripe method is not available for this API interaction.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
