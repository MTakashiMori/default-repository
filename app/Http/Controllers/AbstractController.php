<?php

namespace App\Http\Controllers;

use App\Constants\StatusCode;
use App\Services\ServiceAbstract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbstractController extends Controller
{

    /**
     * @var ServiceAbstract $service
     */
    protected $service;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $response = $this->service->all($request->all());

        return response()->json([
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    protected function show($id)
    {
        return response()->json([
            'message' => __('messages.list'),
            'data' => $this->service->find($id)
        ], StatusCode::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json([
            'message' => __('messages.deleted'),
            'data' => $this->service->destroy($id)
        ], StatusCode::HTTP_OK);
    }
}
