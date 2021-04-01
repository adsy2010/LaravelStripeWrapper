<?php

namespace Adsy2010\LaravelStripeWrapper\Exceptions;

use Exception;
use Throwable;

class StripeApiParameterException extends Exception
{
    public function __construct($message = "Stripe parameter not accepted.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
