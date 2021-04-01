<?php

namespace Adsy2010\LaravelStripeWrapper\Exceptions;

use Exception;
use Throwable;

class StripeVetCheckupApiUnknownException extends Exception
{
    public function __construct($message = "Stripe API specified is unknown.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
