<?php

namespace App\Repositories\ProductDescriptions;

class ProductDescription
{
    /**
     * @var int
     */
    private $products_description_id;

    /**
     * @var int
     */
    private $products_id;

    /**
     * @var int
     */
    private $languages_id;

    /**
     * @var string
     */
    private $products_description_name;

    /**
     * @var string
     */
    private $products_description_short_description;

    /**
     * @var string
     */
    private $products_description_description;

    public function __construct($data)
    {
        $this->products_description_id = $data->products_description_id;
        $this->products_id = $data->products_id;
        $this->languages_id = $data->languages_id;
        $this->products_description_name = $data->products_description_name;
        $this->products_description_short_description = $data->products_description_short_description;
        $this->products_description_description = $data->products_description_description;
    }

    /**
     * @return int
     */
    public function getProductDescriptionId() : int
    {
        return $this->products_description_id;
    }

    /**
     * @return int
     */
    public function getProductId() : int
    {
        return $this->products_id;
    }

    /**
     * @return int
     */
    public function getLanguageId() : int
    {
        return $this->languages_id;
    }

    /**
     * @return string
     */
    public function getProductDescriptionName() : string
    {
        return $this->products_description_name;
    }

    /**
     * @return string
     */
    public function getProductDescriptionShortDescription() : string
    {
        return $this->products_description_short_description;
    }

    /**
     * @return string
     */
    public function getProductDescriptionDescription() : string
    {
        return $this->products_description_description;
    }
}