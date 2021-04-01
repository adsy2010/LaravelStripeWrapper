<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiParameterException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeVetCheckupApiUnknownException;
use Illuminate\Database\Eloquent\Model;

class StripeVet extends Model
{

    const PRODUCTS = ['id', 'name', 'description', 'active', 'created', 'updated', 'images', 'livemode', 'metadata', 'package_dimensions', 'shippable', 'statement_descriptor', 'unit_label', 'url'];
    const PRODUCTS_PARAMS = ['active', 'created', 'ending_before', 'ids', 'limit', 'shippable', 'starting_after', 'url'];

    /**
     * @param array $data
     * @param $api
     * @return array
     * @throws StripeApiParameterException
     * @throws StripeVetCheckupApiUnknownException
     */
    public static function checkup(array $data, $api): array
    {
        switch ($api) {

            case 'products':

                $haystack = self::PRODUCTS;

                break;

            case 'products-params':

                $haystack = self::PRODUCTS_PARAMS;

                break;

            default:

                throw new StripeVetCheckupApiUnknownException();
        }

        foreach ($data as $key => $values) {

            if (!in_array($key, $haystack)) {

                throw new StripeApiParameterException();

            }
        }

        return $data;
    }
}
