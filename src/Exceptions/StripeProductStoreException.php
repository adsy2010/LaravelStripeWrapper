<?php

namespace Adsy2010\LaravelStripeWrapper\Exceptions;

use Exception;
use Throwable;

class StripeProductStoreException extends Exception
{
    public function __construct($message = "Stripe product could not be stored.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
