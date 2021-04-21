<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeApiParameterException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeVetCheckupApiUnknownException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stripe\Collection;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;

/**
 * Class StripeCustomer
 * @package Adsy2010\LaravelStripeWrapper\Models
 * @mixin Builder
 */
class StripeCustomer extends Model implements StripeCrud
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $fillable = ['id','description','email','metadata','name','phone','balance','created','currency','default_source','delinquent','discount','invoice_prefix','livemode','next_invoice_sequence','preferred_locales','tax_exempt'];

    protected $casts = [
        'preferred_locales' => 'json',
        'discount' => 'json',
        'metadata' => 'json',
        'created' => 'datetime',
        'updated' => 'datetime'
    ];

    /**
     * Create a customer on Stripe
     *
     * @param array $data The data to add to the customer. There are no required fields specified in the Stripe API Documentation.
     * @param bool $store Store locally, default is false
     * @return Exception|Customer
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function store(array $data, bool $store = false)
    {
        try {

            $data = StripeVet::checkup($data, 'customers');

            $stripe = StripeCredentialScope::client([StripeScope::CUSTOMERS, StripeScope::SECRET], 'w');

            $customerItem = $stripe->customers->create($data);

            if($store) {

                (new StripeCustomer)->updateOrCreate(['id' => $customerItem->id], $customerItem->toArray());
                (new StripeCustomerAddress)->updateOrCreate(['stripe_customer_id' => $customerItem->id], $customerItem->address->toArray());
                (new StripeCustomerInvoiceSettings)->updateOrCreate(['stripe_customer_id'=>$customerItem->id], $customerItem->invoice_settings->toArray());

                //TODO: Store Customers shipping details

            }

            return $customerItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Updates a product on Stripe
     *
     * @param string $id The customer id
     * @param array $data The data to update the customer with
     * @param bool $store Store locally, default is false
     * @return Exception|ApiErrorException|Customer
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function change(string $id, array $data, bool $store = false)
    {
        try {

            $data = StripeVet::checkup($data, 'customers');

            $stripe = StripeCredentialScope::client([StripeScope::CUSTOMERS, StripeScope::SECRET], 'w');

            $customerItem = $stripe->customers->update($id, $data);

            if($store) {

                (new StripeCustomer)->updateOrCreate(['id' => $customerItem->id], $customerItem->toArray());
                (new StripeCustomerAddress)->updateOrCreate(['stripe_customer_id' => $customerItem->id], $customerItem->address->toArray());
                (new StripeCustomerInvoiceSettings)->updateOrCreate(['stripe_customer_id'=>$customerItem->id], $customerItem->invoice_settings->toArray());

            }

            return $customerItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Delete a customer from Stripe
     *
     * @param string $id The customer id
     * @param bool $store Delete locally, default is false
     * @return Exception|ApiErrorException|Customer
     * @throws StripeCredentialsMissingException
     */
    public function trash(string $id, bool $store = false)
    {
        try{

            $stripe = StripeCredentialScope::client([StripeScope::CUSTOMERS, StripeScope::SECRET], 'w');

            $customerItem = $stripe->customers->delete($id, []);

            if($store) {

                StripeCustomer::where('id', '=', $customerItem->id)->delete();
                StripeCustomerAddress::where('stripe_customer_id', '=', $customerItem->id)->delete();
                StripeCustomerInvoiceSettings::where('stripe_customer_id', '=', $customerItem->id)->delete();

            }

            return $customerItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Retrieves a customer from Stripe
     *
     * @param string $id The customer id
     * @param bool $store Store locally, default is false
     * @return Exception|ApiErrorException|Customer
     * @throws StripeCredentialsMissingException
     */
    public function retrieve(string $id, bool $store = false)
    {
        try{

            $stripe = StripeCredentialScope::client([StripeScope::CUSTOMERS, StripeScope::SECRET]);

            $customerItem = $stripe->customers->retrieve($id, []);

            if($store) {

                (new StripeCustomer)->updateOrCreate(['id' => $customerItem->id], $customerItem->toArray());
                (new StripeCustomerAddress)->updateOrCreate(['stripe_customer_id' => $customerItem->id], $customerItem->address->toArray());
                (new StripeCustomerInvoiceSettings)->updateOrCreate(['stripe_customer_id'=>$customerItem->id], $customerItem->invoice_settings->toArray());

            }

            return $customerItem;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * Retrieves all customers from Stripe or a limited set based on supplied parameters
     *
     * @param array $params Parameters for finding customers
     * @param bool $store Store locally, default is false
     * @return Exception|Collection|ApiErrorException
     * @throws StripeApiParameterException
     * @throws StripeCredentialsMissingException
     * @throws StripeVetCheckupApiUnknownException
     */
    public function retrieveAll(array $params, bool $store = false)
    {
        try {

            $data = StripeVet::checkup($params, 'customers-params');

            $stripe = StripeCredentialScope::client([StripeScope::CUSTOMERS, StripeScope::SECRET]);

            $customerItems = $stripe->customers->all($data);

            if($store) {

                foreach ($customerItems as $customerItem) {

                    $stripeCustomers = (new StripeCustomer)->updateOrCreate(['id' => $customerItem->id], $customerItem->toArray());
                    (new StripeCustomerAddress)->updateOrCreate(['stripe_customer_id' => $customerItem->id], $customerItem->address->toArray());
                    (new StripeCustomerInvoiceSettings)->updateOrCreate(['stripe_customer_id'=>$customerItem->id], $customerItem->invoice_settings->toArray());

                }

            }

            return $customerItems;

        } catch (ApiErrorException $apiErrorException) {

            return $apiErrorException;

        }
    }

    /**
     * The customer address related to this customer
     *
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(StripeCustomerAddress::class);
    }

    /**
     * The customer invoice settings related to this customer
     *
     * @return HasOne
     */
    public function invoiceSettings(): HasOne
    {
        return $this->hasOne(StripeCustomerInvoiceSettings::class);
    }
}
