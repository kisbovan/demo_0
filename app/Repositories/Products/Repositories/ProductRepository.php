<?php

namespace App\Repositories\Products\Repositories;

use App\Repositories\Products\Product;
use App\Repositories\ProductDescriptions\Repositories\ProductDescriptionRepository;
use Exception;

class ProductRepository
{
    private $db;
    private $productDescriptionRepo;

    public function __construct($db)
    {
        $this->db = $db;
        $this->productDescriptionRepo = new ProductDescriptionRepository($db);
    }

    /**
     * @return Product[]
     */
    public function getAllProducts() : array
    {
        $allProducts = [];

        if ($result = $this->db->query("SELECT * FROM `products`;")) {
            while ($obj = $result->fetch_object()) {
                $allProducts[] = new Product($obj);
            }
        }

        return $allProducts;
    }

    /**
     * @param int $id
     * 
     * @return Product
     */
    public function getProductById(int $id) : Product
    {
        $result = $this->db->query(sprintf("SELECT * FROM `products` WHERE `products_id` = %d;", $id))->fetch_row();

        return new Product($this->createObject($result));
    }

    /**
     * @param array $data
     */
    public function saveProduct(array $data)
    {
        try {
            $reference = $data['reference'];
            $price = (float)$data['price'];
            $productId = $data['product_id'];

            for ($i = 0; $i < count($data['descriptionNames']); $i++) {
                $updateData = [
                    'descriptionName' => $data['descriptionNames'][$i]['value'],
                    'shortDescription' => $data['shortDescriptions'][$i]['value'],
                    'longDescription' => $data['longDescriptions'][$i]['value'],
                ];
                $this->productDescriptionRepo->updateProductDescriptionsByProductAndLanguageId($productId, $data['descriptionNames'][$i]['language_id'], $updateData);
            }

            $result = $this->db->query("UPDATE `products` SET `products_reference` = '$reference', `products_price` = $price WHERE `products_id` = $productId;");
        } catch (Exception $e) {
            die($e);
        }
    }

    /**
     * @param array $data
     */
    public function saveNewProduct(array $data)
    {
        try {
            $reference = $data['reference'];
            $price = (float)$data['price'];

            $product = $this->createProduct($reference, $price);

            for ($i = 0; $i < count($data['descriptionNames']); $i++) {
                $updateData = [
                    'descriptionName' => $data['descriptionNames'][$i]['value'],
                    'shortDescription' => $data['shortDescriptions'][$i]['value'],
                    'longDescription' => $data['longDescriptions'][$i]['value'],
                ];
                $this->productDescriptionRepo->createProductDescription($product->getProductId(), $data['descriptionNames'][$i]['language_id'], $updateData);
            }
        } catch (Exception $e) {
            die($e);
        }
    }

    /**
     * @param int $productId
     */
    public function deleteProduct(int $productId)
    {
        $this->productDescriptionRepo->deleteProductDescriptionsByProductId($productId);
        $this->db->query("DELETE FROM `products` where `products_id` = $productId;");
    }

    /**
     * @param string $reference
     * @param float $price
     * 
     * @return Product
     */
    private function createProduct(string $reference, float $price) : Product
    {
        $this->db->query("INSERT INTO `products` (`products_reference`, `products_price`) VALUES ('$reference', $price);");

        return $this->getProductById($this->db->insert_id);
    }

    private function createObject($result)
    {
        $productData->products_id = $result[0];
        $productData->products_reference = $result[1];
        $productData->products_price = $result[2];

        return $productData;
    }
}