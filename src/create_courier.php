<?php
// create_product.php <name>
use App\Domain\Courier\Courier;

require_once "bootstrap.php";


$courier = Courier::createHobo();

$entityManager->persist($courier);
$entityManager->flush();

echo "Created courier " . $courier->getName() . "\n";