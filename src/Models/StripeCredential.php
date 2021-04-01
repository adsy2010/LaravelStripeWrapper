<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeCredential extends Model
{
    use HasFactory;


    public static function create(array $data)
    {
        $key = $data['key']; //friendly name for key
        $value = $data['value']; //encrypted here

        $encrypted = encrypt($value);

        return parent::create(['key' => $key, 'value' => $encrypted]);
    }


}
