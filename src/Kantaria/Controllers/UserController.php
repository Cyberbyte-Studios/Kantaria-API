<?php

namespace Kantaria\Controllers;

use Slim\Container;
use Kantaria\Models\User;
use Kantaria\Models\UserQuery;
use Kantaria\Services\PasswordService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
    protected $ci;
    
    public function __construct(Container $ci) {
       $this->ci = $ci;
    }
    
    public function viewAction(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        
        $q = new UserQuery();
        $user = $q->findPK($args['id']);
        
        return $response->withJson($user->toArray());
    }
    
    /**
     * @SWG\Post(
     *      path="/user/create",
     *      operationId="addUser",
     *      description="Add's a new user to the database",
     *      produces={"application/json"},
     *      @SWG\Parameter(ref="#/parameters/username"),
     *      @SWG\Response(
     *          response=200,
     *          description="User created successfully response",
     *          @SWG\Schema(ref="#/definitions/user")
     *      ),
     * )
     */
    public function createAction(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        $passwordService = new PasswordService();
        
        $user = new User();
        $user->setUsername($input['username']);
        var_dump($input['password']);
        $user->setPassword($passwordService->hash($input['password']));
        
        if (!$user->validate()) {
            return $this->showValidateErrors($user, $response);
        }
        
        $user->save();
        
        return $response->withJson(['id' => $user->getId()]);
    }
}
