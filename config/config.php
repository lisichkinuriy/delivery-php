<?php

use App\Domain\Services\IOrderDispatcher;
use App\Domain\Services\OrderDispatcher;
use Psr\Container\ContainerInterface;

return [

    "display_details" => DI\env('DISPLAY_ERROR_DETAILS', true),
    "log" => DI\env('LOG_ERRORS', true),
    "log_detail" => DI\env('LOG_ERROR_DETAIL', true),

    "salute" => DI\env('SALUTE', "hi!"),

    IOrderDispatcher::class => function (ContainerInterface $container) {
        return new OrderDispatcher();
    }
];