<?php

namespace Kantaria\Controllers;

use Slim\Container;
use Kantaria\Models\Hero;
use Kantaria\Services\HeroService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HeroController extends Controller
{
    protected $ci;
    
    public function __construct(Container $ci) {
       $this->ci = $ci;
    }
    
    public function viewAction(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        
        $q = new HeroQuery();
        $hero = $q->findPK($args['id']);
        
        return $response->withJson($hero);
    }
    
    public function createAction(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $input = $request->getParsedBody();
        
        $hero = new Hero();
        $hero->fromArray($input);

        $hero->setFirstName($input['first_name']);
        $hero->setLastName($input['last_name']);
        $hero->setUserId($input['user_id']);


        //$hero = HeroService::applyDefaults($hero);
        
        if (!$hero->validate()) {
            return $this->showValidateErrors($hero, $response);
        }
        
        $hero->save();
        
        return $response->withJson(['id' => $hero->getId()]);
    }
}
