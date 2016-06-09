<?php

namespace Kantaria\Controllers;

use Slim\Container;
use Kantaria\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
    protected $ci;
    
    public function __construct(Container $ci) {
       $this->ci = $ci;
    }
    
    public function view(ServerRequestInterface $request, ResponseInterface $response, $args) {
        
    }
    
    /**
     * @SWG\Post(
     *     path="/user/create",
     *     @SWG\Response(response="200", description="An example resource")
     * )
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        
        $user = new User();
        $user->setUsername($input['username']);
        $user->setPassword($input['password']);
        
        if (!$user->validate()) {
            return $this->showValidateErrors($user, $response);
        }
        
        $user->save();
        
        return $response->withJson(['id' => $user->getId()]);
    }
}
