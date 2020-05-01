<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 01.05.2020
 */

namespace App\Model;

class OrderItem
{
    /** @var Good $good */
    private $good;

    /** @var int $count */
    private $count = 1;

    /**
     * OrderItem constructor.
     *
     * @param Good $good
     * @param int $count
     */
    public function __construct(Good $good, int $count = 1)
    {
        $this->good = $good;
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->good->price * $this->count;
    }

    /**
     * @return int
     */
    public function getGoodPrice(): int
    {
        return $this->good->price;
    }

    public function addOne(): void
    {
        $this->count++;
    }

    public function removeOne(): void
    {
        $this->count--;
    }
}