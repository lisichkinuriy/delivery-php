<?php

namespace App\Application;

use App\Domain\Services\IOrderDispatcher;
use App\Domain\Services\OrderDispatcher;
use DI\Definition\Source\MutableDefinitionSource;
use DI\Proxy\ProxyFactory;
use Psr\Container\ContainerInterface;

class Container extends \DI\Container
{
    public function __construct(MutableDefinitionSource|array $definitions = [], ?ProxyFactory $proxyFactory = null, ?ContainerInterface $wrapperContainer = null)
    {
        parent::__construct($definitions, $proxyFactory, $wrapperContainer);

        $this->set(IOrderDispatcher::class, function(ContainerInterface $container) {
            return new OrderDispatcher();
        });
    }
}