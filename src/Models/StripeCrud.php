<?php


namespace Adsy2010\LaravelStripeWrapper\Models;


interface StripeCrud
{

    /**
     * Stores data
     *
     * @param array $data The data to add to the entity
     * @param bool $store Stores locally, default is false
     * @return mixed
     */
    public function store(array $data, bool $store = false);

    /**
     * Updates data
     *
     * @param string $id
     * @param array $data The data to updates the entity with
     * @param bool $store Stores locally, default is false
     * @return mixed
     */
    public function change(string $id, array $data, bool $store = false);

    /**
     * Deletes data
     *
     * @param string $id The id of the entity to delete
     * @param bool $store Stores locally, default is false
     * @return mixed
     */
    public function trash(string $id, bool $store = false);

    /**
     * Retrieves data
     *
     * @param string $id The id of the entity to retrieve
     * @param bool $store Stores locally, default is false
     * @return mixed
     */
    public function retrieve(string $id, bool $store = false);

    /**
     * Retrieves all data
     *
     * @param array $params Parameters for finding entities
     * @param bool $store Stores locally, default is false
     * @return mixed
     */
    public function retrieveAll(array $params, bool $store = false);
}
