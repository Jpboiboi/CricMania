<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait AjaxResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'status' => $code], $code);
    }

    public function showAll(Collection $collection, int $code = 200)
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    public function showOne(Model $model, int $code = 200)
    {
        return $this->successResponse(['data' => $model], $code);
    }

    public function showMessage(string $message, int $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

}
