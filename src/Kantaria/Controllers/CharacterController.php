<?php

namespace Kantaria\Controllers;

use Slim\Container;
use Kantaria\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CharacterController extends Controller
{
    protected $ci;
    
    public function __construct(Container $ci) {
       $this->ci = $ci;
    }
    
    public function viewAction(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        
        $q = new CharacterQuery();
        $character = $q->findPK($args['id']);
        
        return $response->withJson($character);
    }
    
    public function createAction(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        
        $character = new Character();
        $character->fromArray($input);
        
        if (!$user->validate()) {
            return $this->showValidateErrors($character, $response);
        }
        
        $user->save();
        
        return $response->withJson(['id' => $character->getId()]);
    }
    
    
}
