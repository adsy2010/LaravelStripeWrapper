<?php


namespace Adsy2010\LaravelStripeWrapper\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StripeCustomerShippingDetails extends Model
{

    protected $table = 'stripe_customers_shipping_details';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'phone', 'stripe_customers_address_id'];


    /**
     * The customer address related to the shipping details
     *
     * @return BelongsTo
     */
    public  function customerAddress(): BelongsTo
    {
        return $this->belongsTo(StripeCustomerAddress::class);
    }

}
