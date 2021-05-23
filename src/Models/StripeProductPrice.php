<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiMethodUnavailableException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiParameterException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeVetCheckupApiUnknownException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;

/**
 * Class StripeProductPrice
 * @package Adsy2010\LaravelStripeWrapper\Models
 * @mixin Builder
 */
class StripeProductPrice extends Model implements StripeCrud
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $fillable = ['currency', 'product', 'active', 'metadata', 'nickname', 'recurring', 'type', 'billing_scheme', 'livemode', 'lookup_key', 'tiers', 'tiers_mode', 'transform_quantity', 'created', 'unit_amount', 'unit_amount_decimal'];

    protected $casts = [
        'metadata' => 'json',
        'recurring' => 'json',
        'tiers' => 'json',
        'transform_quantity' => 'json',
        'livemode' => 'bool',
        'active' => 'bool',
        'created' => 'datetime',
    ];

    /**
     * Create a product price on stripe
     *
     * @param array $data The product price data for a product. Required fields in the Stripe API documentation are: currency, product unless product data is provided, unit amount unless billing scheme is tiered, tiers if billing scheme is tiered, tiers mode if billing scheme is tiered
     * @param false $store Store locally, default is false
     * @return Exception|Price
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function store(array $data, $store = false)
    {
        try {

            $data = StripeVet::checkup($data, 'product-prices');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            $productPrice = $stripe->prices->create($data);

            if ($store) {

                (new StripeProductPrice)->updateOrCreate(['id' => $productPrice->id], $productPrice->toArray());

            }

            return $productPrice;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Updates a product price on stripe
     *
     * @param string $id The product id
     * @param array $data The data to update the product price with
     * @param false $store Store locally, default is false
     * @return Exception|ApiErrorException|Price
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function change(string $id, array $data, $store = false)
    {
        try {

            $data = StripeVet::checkup($data, 'product-prices');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');

            $productPrice = $stripe->prices->update($id, $data);

            if ($store) {

                (new StripeProductPrice)->updateOrCreate(['id' => $productPrice->id], $productPrice->toArray());

            }

            return $productPrice;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * !!! DO NOT USE THIS METHOD !!!
     * Method unavailable through stripe #Delete a price from stripe#. This method will always throw an exception at this time.
     *
     * @param string $id The product price ID
     * @param false $store Delete locally, default is false
     * @return void
     * @throws StripeApiMethodUnavailableException
     */
    public function trash(string $id, $store = false)
    {
        throw new StripeApiMethodUnavailableException();
    }

    /**
     * Retrieves a product price from Stripe
     *
     * @param string $id The product price ID
     * @param false $store Store locally, default is false
     * @return Exception|ApiErrorException|Price
     * @throws StripeCredentialsMissingException
     */
    public function retrieve(string $id, $store = false)
    {
        try {

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET]);

            $productPrice = $stripe->prices->retrieve($id, []);

            if ($store) {

                (new StripeProductPrice)->updateOrCreate(['id' => $productPrice->id], $productPrice->toArray());

            }

            return $productPrice;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Retrieves all product prices from Stripe or a limited set based on supplied parameters
     *
     * @param array $params Parameters for finding prices
     * @param false $store Store locally, default is false
     * @return Exception|Collection|ApiErrorException
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function retrieveAll(array $params = [], $store = false)
    {
        try {

            $data = StripeVet::checkup($params, 'product-prices-params');

            $stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET]);

            $productPrices = $stripe->prices->all($data);

            if ($store) {

                foreach ($productPrices as $productPrice) {

                    (new StripeProductPrice)->updateOrCreate(['id' => $productPrice->id], $productPrice->toArray());

                }

            }

            return $productPrices;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * The product related to this product price
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(StripeProduct::class, 'id', 'product');
    }
}
