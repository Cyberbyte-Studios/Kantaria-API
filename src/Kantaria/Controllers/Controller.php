<?php

namespace Kantaria\Controllers;

use Psr\Http\Message\ResponseInterface;

abstract class Controller
{
    protected function showValidateErrors($model, ResponseInterface $response)
    {
        $messages = [];
        $failures = $model->getValidationFailures();
    
        foreach ($failures as $failure) {
            $messages[$failure->getPropertyPath()] = $failure->getMessage();
        }
        
        $data = ['success' => false, 'messages' => $messages];
        
        return $response->withJson($data);
    }
}
