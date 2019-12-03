<?php

namespace App\Repository;

use App\Model\ModelAbstract;

/**
 * Class Repository
 * @package App\Repositories
 */
class RepositoryAbstract
{
    /**
     * @var $relationship
     */
    protected $relationship;

    /**
     * @var $model ModelAbstract
     */
    protected $model;

    /**
     * @var $appends
     */
    protected $appends;

    /**
     * @param $request
     * @return mixed
     */
    public function all($request)
    {
        if($request)
        {
            return $this->model->like($request);
        }
        return $this->model->with($this->relationship);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->with($this->relationship)->find($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->model
            ->find($id)
            ->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
