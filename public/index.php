<?php

use App\Application\Controllers\IndexController;

require __DIR__ . '/../src/bootstrap.php';


$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions("../config/config.php");
$container = $containerBuilder->build();

$app = \DI\Bridge\Slim\Bridge::create($container);
$app->get('/', [IndexController::class, 'index']);
$app->addErrorMiddleware($container->get("display_details"), $container->get("log"), $container->get("log_detail"));

$app->run();
