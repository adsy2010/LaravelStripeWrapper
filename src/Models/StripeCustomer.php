<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeCustomer extends Model implements StripeCrud
{
    use HasFactory;

    protected $guarded = ['id'];


    /**
     * @param array $data
     * @param bool $store
     * @return mixed|void
     */
    public function store(array $data, bool $store = false)
    {
        // TODO: Implement store() method.
    }

    /**
     * @param string $id
     * @param array $data
     * @param bool $store
     * @return mixed|void
     */
    public function change(string $id, array $data, bool $store = false)
    {
        // TODO: Implement change() method.
    }

    /**
     * @param string $id
     * @param bool $store
     * @return mixed|void
     */
    public function trash(string $id, bool $store = false)
    {
        // TODO: Implement trash() method.
    }

    /**
     * @param string $id
     * @param bool $store
     * @return mixed|void
     */
    public function retrieve(string $id, bool $store = false)
    {
        // TODO: Implement retrieve() method.
    }

    /**
     * @param array $params
     * @param bool $store
     * @return mixed|void
     */
    public function retrieveAll(array $params, bool $store = false)
    {
        // TODO: Implement retrieveAll() method.
    }
}
