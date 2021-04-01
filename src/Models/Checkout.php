<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    private $checkout_session_id;
    private $checkout_session;

    public function retrieve()
    {

    }
}
