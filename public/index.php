<?php

use App\Application\Container;
use App\Domain\Services\IOrderDispatcher;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$app = \DI\Bridge\Slim\Bridge::create($container);

$app->get('/', function (Request $request, Response $response) use($app) {
    $orderDispatcher = $app->getContainer()->get(IOrderDispatcher::class);
    $response->getBody()->write("Hello world! Dispatcher is: " . $orderDispatcher::class);
    return $response;
});



$app->addErrorMiddleware(true, true, true);

$app->run();
