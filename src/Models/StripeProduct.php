<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\StripeClient;

class StripeProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function push(array $data)
    {

    }
}
