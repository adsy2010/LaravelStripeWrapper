<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StripeCredentialScope extends Model
{
    use HasFactory;

    /**
     * Retrieves all credentials which match the scope and access level
     *
     * @param array $scopes
     * @param string $access r (read), w (write)
     * @return Builder[]|Collection
     */
    public static function retrieve(array $scopes, $access = 'r')
    {
        return StripeCredentialScope::with(['stripeCredential', 'stripeScope' => function ($query) use ($scopes) {
            $query->whereIn('name', $scopes);
        }])->where('access', '=', $access)->get();
    }

    /**
     * @return BelongsTo
     */
    public function stripeScope()
    {
        return $this->belongsTo(StripeScope::class);
    }

    /**
     * @return BelongsTo
     */
    public function stripeCredential()
    {
        return $this->belongsTo(StripeCredential::class);
    }
}
