<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\RepositoryInterface;
use Carbon\Carbon;

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
        return $this->_model->paginate(30);
    }

    /**
     * Get one
     * @param $id
     * @return mixed|void
     */
    public function find($slug)
    {
        return $this->_model->where('slug',$slug)->firstOrFail();
    }

    public function findByID($id)
    {
        return $this->_model->where('id',$id)->firstOrFail();
    }

    /**Create
     * @param array $attribute
     * @return mixed|void
     */
    public function create(array $attribute)
    {
        $attribute['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $attribute['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        return $this->_model->create($attribute);
    }

    /**Update
     * @param $id
     * @param array $attribute
     * @return mixed|void
     */
    public function update($slug, array $attribute)
    {
        $result = $this->find($slug);

        if ($result) {
            $attribute['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
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
