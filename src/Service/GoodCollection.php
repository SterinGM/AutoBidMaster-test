<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 01.05.2020
 */

namespace App\Service;

use App\Model\Good;

class GoodCollection
{
    const COUNT_GOODS = 10000;
    const MAX_PRICE = 10000;

    /** @var Good[] $goods */
    private $goods = [];

    /** @var array $goodsByPrice */
    private $goodsByPrice = [];

    /**
     * GoodCollection constructor.
     */
    public function __construct()
    {
        for ($i = 1; $i <= self::COUNT_GOODS; $i++) {
            $good = new Good($i, mt_rand(0, self::MAX_PRICE));
            $this->addGood($good);
        }
    }

    /**
     * @param Good $good
     */
    public function addGood(Good $good): void
    {
        $this->goods[$good->id] = $good;
        $this->goodsByPrice[$good->price][] = $good->id;
    }

    /**
     * @return Good
     */
    public function getRandomGood(): Good
    {
        /** @var int $key */
        $key = array_rand($this->goods);

        return $this->goods[$key];
    }

    /**
     * @param int $price
     *
     * @return Good|null
     */
    function findGoodMorePrice(int $price): ?Good
    {
        for ($i = $price; $i <= self::MAX_PRICE; $i++) {
            if (isset($this->goodsByPrice[$i])) {
                $goods = $this->goodsByPrice[$i];
                $id = $goods[array_rand($goods)];

                return $this->goods[$id];
            }
        }

        return null;
    }

    /**
     * @param int $price
     *
     * @return Good|null
     */
    function findGoodLessPrice(int $price): ?Good
    {
        for ($i = $price; $i > 0; $i--) {
            if (isset($this->goodsByPrice[$i])) {
                $goods = $this->goodsByPrice[$i];
                $id = $goods[array_rand($goods)];

                return $this->goods[$id];
            }
        }

        return null;
    }
}