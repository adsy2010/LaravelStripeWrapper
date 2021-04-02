<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiParameterException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeVetCheckupApiUnknownException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\Product;

/**
 * Class StripeProduct
 * @package Adsy2010\LaravelStripeWrapper\Models
 * @mixin Builder
 */
class StripeProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = ['name','description','active','created','updated','images','livemode','metadata','package_dimensions','shippable','statement_descriptor','unit_label','url'];

    /**
     * Create a product on Stripe
     *
     * @param array $data The data to add to the product. Name is a required field
     * @param bool $store Store locally, default is false
     * @return Exception|Product
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function store(array $data, $store = false)
    {
        try {

            $data = StripeVet::checkup($data, 'products');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            $productItem = $stripe->products->create($data);

            if($store) {

                (new StripeProduct)->updateOrCreate(['id' => $productItem->id], $productItem->toArray());

            }

            return $productItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Updates a product on Stripe
     *
     * @param string $product The product id
     * @param array $data The data to update the product with
     * @param bool $store Store locally, default is false
     * @return Exception|ApiErrorException|Product
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function change(string $product, array $data, $store = false)
    {
        try {

            $data = StripeVet::checkup($data, 'products');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            $productItem = $stripe->products->update($product, $data);

            if($store) {

                (new StripeProduct)->updateOrCreate(['id' => $productItem->id], $productItem->toArray());

            }

            return $productItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }

    }

    /**
     * Delete a product from Stripe
     *
     * @param string $product The product id
     * @param bool $store Delete locally, default is false
     * @return Exception|ApiErrorException|Product
     * @throws StripeCredentialsMissingException
     */
    public function trash(string $product, $store = false)
    {
        try {

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            $productItem = $stripe->products->delete($product, []);

            if($store) {

                StripeProduct::where('id', '=', $productItem->id)->delete();

            }

            return $productItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Retrieves a product from Stripe
     *
     * @param string $product The product id
     * @param bool $store Store locally, default is false
     * @return Exception|ApiErrorException|Product
     * @throws StripeCredentialsMissingException
     */
    public function retrieve(string $product, $store = false)
    {
        try {

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET]);

            $productItem = $stripe->products->retrieve($product, []);

            if($store) {

                (new StripeProduct)->updateOrCreate(['id' => $productItem->id], $productItem->toArray());

            }

            return $productItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Retrieves all products from Stripe or a limited set based on supplied paramters
     *
     * @param array $params Parameters for finding products
     * @param bool $store Store locally, default is false
     * @return Exception|Collection|ApiErrorException
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function retrieveAll(array $params = [], $store = false)
    {
        try {
            $data = StripeVet::checkup($params, 'products-params');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET]);

            $productItems = $stripe->products->all($data);

            if($store) {

                foreach ($productItems as $productItem) {

                    $stripeProducts = (new StripeProduct)->updateOrCreate(['id' => $productItem->id], $productItem->toArray());

                }

            }

            return $productItems;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }
}
