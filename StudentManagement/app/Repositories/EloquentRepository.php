<?php

namespace App\Repositories;

use App\Repositories\Repository_Interface\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_model->paginate(50);
    }

    /**
     * Get one
     * @param $id
     * @return mixed|void
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**Create
     * @param array $attribute
     * @return mixed|void
     */
    public function create(array $attribute)
    {
        $result = $this->_model->create($attribute);

        return $result;
    }

    /**Update
     * @param $id
     * @param array $attribute
     * @return mixed|void
     */
    public function update($id, array $attribute)
    {
        $result = $this->find($id);

        if ($result) {
            $result->update($attribute);

            return $result;
        }

        return false;
    }

    /**Delete
     * @param $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $result = $this->find($id);

        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

}
