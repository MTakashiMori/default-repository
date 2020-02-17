<?php

namespace App\Services;


use App\Repository\RepositoryAbstract;
use Exception;

/**
 * Class Service
 * @package App\Services
 */
class ServiceAbstract
{
    /**
     * @var $repository RepositoryAbstract
     */
    protected $repository;

    /**
     * @param $request
     * @return Collection
     */
    public function all($request)
    {
        isset($request['size']) ?
            $size = $request['size'] :
            $size = 15;

        isset($request['sortBy']) ?
            $field = $request['sortBy'] :
            $field = null;

        isset($request['orderDesc']) ?
            $order = $request['orderDesc'] :
            $order = null;

        unset($request['page']);
        unset($request['size']);
        unset($request['sortBy']);
        unset($request['orderDesc']);

        $data = collect([
            'message' => __('messages.list'),
            'data' => null,
            'code' => 200
        ]);

        try {
            $data['data'] = $this->repository->all($request, $field, $order)->paginate($size);
            return $data;

        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['code'] = $e->getCode();
            return $data;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        return $this->repository->create($request);
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        return $this->repository->update($request, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
