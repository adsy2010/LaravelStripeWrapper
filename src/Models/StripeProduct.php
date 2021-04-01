<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiParameterException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeVetCheckupApiUnknownException;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\Product;

class StripeProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    /**
     * @param array $data
     * @return Exception|Product
     * @throws StripeCredentialsMissingException
     * @throws StripeApiParameterException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function store(array $data)
    {
        try {

            $data = StripeVet::checkup($data, 'products');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            return $stripe->products->create($data);

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * @param $product
     * @param array $data
     * @return Exception|ApiErrorException|Product
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function change($product, array $data)
    {
        try {

            $data = StripeVet::checkup($data, 'products');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            return $stripe->products->update($product, $data);

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }

    }

    /**
     * @param $product
     * @return Exception|ApiErrorException|Product
     * @throws StripeCredentialsMissingException
     */
    public function trash($product)
    {
        try {

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            return $stripe->products->delete($product, []);

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * @param $product
     * @return Exception|ApiErrorException|Product
     * @throws StripeCredentialsMissingException
     */
    public function retrieve($product)
    {
        try {

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET]);

            return $stripe->products->retrieve($product, []);

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * @param array $data
     * @return Exception|Collection|ApiErrorException
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function retrieveAll(array $data = [])
    {
        try {
            $data = StripeVet::checkup($data, 'products-params');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET]);

            return $stripe->products->all($data);

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }
}
