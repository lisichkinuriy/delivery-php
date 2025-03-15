<?php
// create_product.php <name>
use App\Domain\Courier\Courier;

require_once "bootstrap.php";


$courier = Courier::createHobo();

$couriers = $entityManager->getRepository(Courier::class)->findAll();

foreach ($couriers as $courier) {
    echo "courier: " . $courier->getName() . "\n";
}

