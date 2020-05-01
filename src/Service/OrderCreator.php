<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 01.05.2020
 */

namespace App\Service;

use App\Model\Order;
use App\Model\OrderItem;
use Exception;

class OrderCreator
{
    const MIN_COUNT_ITEMS = 2500;
    const MAX_COUNT_ITEMS = 3000;
    const MIN_ORDER_PRICE = 2600000;
    const MAX_ORDER_PRICE = 3000000;

    /** @var GoodCollection $goods */
    private $goods;

    /**
     * OrderCreator constructor.
     *
     * @param GoodCollection $goods
     */
    public function __construct(GoodCollection $goods)
    {
        $this->goods = $goods;
    }

    /**
     * @return Order
     * @throws Exception
     */
    public function prepareOrder(): Order
    {
        $delta = 0;
        $order = new Order();

        do {
            $count = self::MAX_COUNT_ITEMS - $delta++;

            if ($count < self::MIN_COUNT_ITEMS) {
                break;
            }

            $price = floor(self::MAX_ORDER_PRICE / $count);
            $good = $this->goods->findGoodLessPrice($price);

            if ($good) {
                $item = new OrderItem($good, $count);
                $order->addItem($item);
                $order->middleItem = $item;
            }
        } while ($good === null);

        if ($order->getPrice() === 0) {
            $delta = 0;

            do {
                $count = self::MAX_COUNT_ITEMS - $delta++;

                if ($count < self::MIN_COUNT_ITEMS) {
                    break;
                }

                $price = floor(self::MIN_ORDER_PRICE / $count);
                $good = $this->goods->findGoodMorePrice($price);

                if ($good) {
                    $item = new OrderItem($good, $count);
                    $order->addItem($item);
                    $order->middleItem = $item;
                }
            } while ($good === null);
        }

        if ($order->getPrice() === 0) {
            throw new Exception("Невозможно собрать заказ!!!");
        }

        return $order;
    }

    /**
     * @param Order $order
     *
     * @return Order
     */
    public function correctOrder(Order $order): Order
    {
        while ($order->getPrice() < self::MAX_ORDER_PRICE) {
            $delta = self::MAX_ORDER_PRICE - $order->getPrice();
            $price = $order->getMiddlePrice() + $delta;
            $good = $this->goods->findGoodLessPrice($price);

            if ($good && $good->price > $order->getMiddlePrice()) {
                $item = new OrderItem($good);
                $order->addItem($item);
                $order->middleItem->removeOne();
            } else {
                break;
            }
        }

        return $order;
    }
}