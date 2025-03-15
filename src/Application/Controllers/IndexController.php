<?php

namespace App\Application\Controllers;

use App\Domain\Services\IOrderDispatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, IOrderDispatcher $orderDispatcher): ResponseInterface
    {
            $salute = "OK";
            $response->getBody()->write($salute);
            $response->getBody()->write("\nDispatcher is: " . $orderDispatcher::class);
            return $response;
    }
}