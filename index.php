<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\Service\OrderCreator;
use App\Service\GoodCollection;

$goods = new GoodCollection();
$orderCreator = new OrderCreator($goods);

try {
    $order = $orderCreator->prepareOrder();
    $order = $orderCreator->correctOrder($order);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

var_dump($order, $order->getPrice());