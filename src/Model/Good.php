<?php
/**
 * Created by PhpStorm.
 * User: Grigoriy Sterin
 * Date: 01.05.2020
 */

namespace App\Model;

class Good
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $price;

    /**
     * Good constructor.
     *
     * @param int $id
     * @param int $price
     */
    public function __construct(int $id, int $price)
    {
        $this->id = $id;
        $this->price = $price;
    }
}