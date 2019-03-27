<?php

namespace App\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait{

    public function apiException($request,$e)
    {
        
        if ($this->isModel($e))
        {
            return response()->json([
                'errors'=>'Product Model not found'
            ],404);
        }

    if ($e instanceof NotFoundHttpException) //can make is Http Func Like Model see Commit"Customised Exception"
        {
            return response()->json([
                'errors'=>'Incorrect Route'
            ],404);
        }

        return parent::render($request, $e);
      
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }
}