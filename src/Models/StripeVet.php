<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiParameterException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeVetCheckupApiUnknownException;
use Illuminate\Database\Eloquent\Model;

class StripeVet extends Model
{

    const PRODUCTS = ['id', 'name', 'description', 'active', 'created', 'updated', 'images', 'livemode', 'metadata', 'package_dimensions', 'shippable', 'statement_descriptor', 'unit_label', 'url'];
    const PRODUCTS_PARAMS = ['active', 'created', 'ending_before', 'ids', 'limit', 'shippable', 'starting_after', 'url'];

    const CUSTOMERS = [
        'id',
        'description',
        'email',
        'metadata',
        'name',
        'phone',
        'balance',
        'created',
        'currency',
        'default_source',
        'delinquent',
        'discount',
        'invoice_prefix',
        'livemode',
        'next_invoice_sequence',
        'preferred_locales',
        'tax_exempt',
        'address'=>['line1','line2','city','state','country','postal_code'],
        'invoice_settings'=>['custom_fields','default_payment_method','footer']
    ];
    const CUSTOMERS_PARAMS = ['email', 'created', 'ending_before', 'limit', 'starting_after'];

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

            case 'customers':

                $haystack = self::CUSTOMERS;

                break;

            case 'customers-params':

                $haystack = self::CUSTOMERS_PARAMS;

                break;

            case 'products-params':

                $haystack = self::PRODUCTS_PARAMS;

                break;

            default:

                throw new StripeVetCheckupApiUnknownException();
        }

        foreach ($data as $key => $values) {

            //Check main haystack
            if (!in_array($key, $haystack)) {

                //If key does not exist as an array, throw an exception
                if(!array_key_exists($key, $haystack)) {

                    throw new StripeApiParameterException();

                } else {

                    //Check the inner key haystack array to ensure that the request is allowed or throw exception
                    if(is_array($values)) {

                        foreach ($values as $innerKey => $innerValues) {

                            if (!in_array($innerKey, $haystack[$key])) {

                                throw new StripeApiParameterException();

                            }

                        }

                    }

                }

            }

        }

        return $data;
    }
}
