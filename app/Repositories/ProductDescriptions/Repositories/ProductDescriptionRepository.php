<?php

namespace App\Repositories\ProductDescriptions\Repositories;

use App\Repositories\ProductDescriptions\ProductDescription;

class ProductDescriptionRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return ProductDescription[]
     */
    public function getAllProductDescriptions() : array
    {
        $allProducts = [];

        if ($result = $this->db->query("SELECT * FROM `products_description`;")) {
            while ($obj = $result->fetch_object()) {
                $allProducts[] = new ProductDescription($obj);
            }
        }

        return $allProducts;
    }

    /**
     * @param int $id
     * 
     * @return ProductDescription
     */
    public function getProductDescriptionById(int $id) : ProductDescription
    {
        $result = $this->db->query(sprintf("SELECT * FROM `products_description` WHERE `products_description_id` = %d;", $id))->fetch_row();
        
        return new ProductDescription($this->createObject($result));
    }

    /**
     * @param int $languageId
     * @param int $productId
     * 
     * @return ProductDescription|null
     */
    public function getProductDescriptionByLanguageAndProductId(int $languageId, int $productId)
    {
        $result = $this->db->query(sprintf("SELECT * FROM `products_description` WHERE `languages_id` = %d and `products_id` = %d;", $languageId, $productId))->fetch_row();

        if (is_null($result)) {
            return null;
        }

        return new ProductDescription($this->createObject($result));
    }

    /**
     * @param int $id
     * 
     * @return ProductDescription[]
     */
    public function getAllProductDescriptionsByProductId(int $id) : array
    {
        $descriptions = [];

        if ($result = $this->db->query(sprintf("SELECT * FROM `products_description` WHERE `products_id` = %d;", $id))) {
            while ($obj = $result->fetch_object()) {
                $descriptions[] = new ProductDescription($obj);
            }
        }

        return $descriptions;
    }

    /**
     * @param int $productId
     * @param int $languageId
     * @param array $data
     */
    public function updateProductDescriptionsByProductAndLanguageId(int $productId, int $languageId, array $data)
    {
        $productDescription = $this->getProductDescriptionByLanguageAndProductId($languageId, $productId);

        if ($productDescription) {
            $this->db->query(sprintf("UPDATE `products_description` SET `products_description_name` = '%s', `products_description_short_description` = '%s', `products_description_description` = '%s' WHERE `products_id` = %d and `languages_id` = %d;", 
                    $data['descriptionName'],
                    $data['shortDescription'],
                    $data['longDescription'],
                    $productId,
                    $languageId
            ));
        } else {
            $this->createProductDescription($productId, $languageId, $data);
        }
    }

    /**
     * @param int $productId
     * @param int $languageId
     * @param array $data
     * 
     * @return ProductDescription
     */
    public function createProductDescription(int $productId, int $languageId, array $data) : ProductDescription
    {
        $this->db->query(sprintf("INSERT INTO `products_description` (`products_id`, `languages_id`, `products_description_name`, `products_description_short_description`, `products_description_description`)
                                            VALUES (%d, %d, '%s', '%s', '%s');", 
                                            $productId,
                                            $languageId,
                                            $data['descriptionName'],
                                            $data['shortDescription'],
                                            $data['longDescription'],
        ));

        return $this->getProductDescriptionById($this->db->insert_id);
    }

    /**
     * @param int $productId
     */
    public function deleteProductDescriptionsByProductId(int $productId)
    {
        $this->db->query(sprintf("DELETE FROM `products_description` WHERE `products_id` = %d", $productId));
    }

    private function createObject($result)
    {
        $descriptionData->products_description_id = $result[0];
        $descriptionData->products_id = $result[1];
        $descriptionData->languages_id = $result[2];
        $descriptionData->products_description_name = $result[3];
        $descriptionData->products_description_short_description = $result[4];
        $descriptionData->products_description_description = $result[5];

        return $descriptionData;
    }
}