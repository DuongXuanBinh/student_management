<?php
namespace App\Repositories\Repository_Interface;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attribute
     * @return mixed
     */
    public function create(array $attribute);

    /**
     * Update
     * @param $id
     * @param array $attribute
     * @return mixed
     */
    public function update($id, array $attribute);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);
}


