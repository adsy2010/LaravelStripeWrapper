<?php


namespace Adsy2010\LaravelStripeWrapper\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class StripeCustomerAddress
 * @package Adsy2010\LaravelStripeWrapper\Models
 * @mixin Builder
 */
class StripeCustomerAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stripe_customers_address';

    protected $guarded = ['id'];

    protected $fillable = ['stripe_customer_id', 'line1', 'line2', 'city', 'state', 'postal_code', 'country', 'shipping'];

    protected $casts = ['shipping' => 'bool'];

    /**
     * The customer related to this customer address
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(StripeCustomer::class);
    }

    /**
     * The shipping details related to this customer address
     *
     * @return HasOne
     */
    public function shipping(): HasOne
    {
        return $this->hasOne(StripeCustomerShippingDetails::class);
    }
}
