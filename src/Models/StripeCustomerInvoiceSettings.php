<?php


namespace Adsy2010\LaravelStripeWrapper\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StripeCustomerInvoiceSettings
 * @package Adsy2010\LaravelStripeWrapper\Models
 * @mixin Builder
 */
class StripeCustomerInvoiceSettings extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stripe_customers_invoice_settings';

    protected $guarded = ['id'];

    protected $fillable = ['stripe_customer_id', 'custom_fields', 'default_payment_method', 'footer'];

    protected $casts = [
        'custom_fields' => 'json'
    ];

    /**
     * The customer related to this customers invoice settings
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(StripeCustomer::class);
    }

}
