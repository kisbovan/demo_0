<?php

namespace App\Repositories\Products;

class Product
{
    /**
     * @var int
     */
    private $products_id;

    /**
     * @var string
     */
    private $products_reference;

    /**
     * @var float
     */
    private $products_price;

    public function __construct($data)
    {
        $this->products_id = $data->products_id;
        $this->products_reference = $data->products_reference;
        $this->products_price = $data->products_price;
    }

    /**
     * @return int
     */
    public function getProductId() : int
    {
        return $this->products_id;
    }

    /**
     * @return string
     */
    public function getProductReference() : string
    {
        return $this->products_reference;
    }

    /**
     * @return float
     */
    public function getProductPrice() : float
    {
        return $this->products_price;
    }
}