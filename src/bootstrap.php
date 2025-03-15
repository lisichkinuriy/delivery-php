<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__],
    isDevMode: true,
);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_pgsql',
    'host' => 'db',
    'port' => '5432',
    'user' => 'delivery',
    'password' => 'secret',
    'dbname' => 'delivery',
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);