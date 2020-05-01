<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 01.05.2020
 */

namespace App\Model;

class Order
{
    /** @var OrderItem $middleItem */
    public $middleItem;

    /** @var OrderItem[] $items */
    private $items = [];

    /**
     * @param OrderItem $item
     */
    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        $price = 0;

        foreach ($this->items as $item) {
            $price += $item->getPrice();
        }

        return $price;
    }

    /**
     * @return int
     */
    public function getMiddlePrice(): int
    {
        return $this->middleItem->getGoodPrice();
    }
}