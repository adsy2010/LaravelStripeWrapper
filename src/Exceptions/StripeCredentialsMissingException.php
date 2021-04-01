<?php

namespace Adsy2010\LaravelStripeWrapper\Exceptions;

use Exception;
use Throwable;

class StripeCredentialsMissingException extends Exception
{
    public function __construct($message = "Stripe Credentials could not be found for the scope/access combination supplied", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
