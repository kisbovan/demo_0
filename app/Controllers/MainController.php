<?php

namespace App\Controllers;

use App\Repositories\Products\Repositories\ProductRepository;
use App\Repositories\Languages\Repositories\LanguageRepository;
use App\Repositories\ProductDescriptions\Repositories\ProductDescriptionRepository;
use App\System\DBConnection;
use App\Lib\Request;

class MainController {

    private $db;
    private $productRepo;
    private $languageRepo;
    private $productDescriptionRepo;

    public function __construct()
    {
        $this->db = (new DBConnection())->getConnection();
        $this->productRepo = new ProductRepository($this->db);
        $this->languageRepo = new LanguageRepository($this->db);
        $this->productDescriptionRepo = new ProductDescriptionRepository($this->db);
    }

    /**
     * @method GET
     */
    public function getAllProducts()
    {
        $products = $this->productRepo->getAllProducts();
        $productsInfo = [];

        foreach ($products as $product) {
            $productDescription = $this->productDescriptionRepo->getProductDescriptionByLanguageAndProductId($_ENV['DEFAULT_LANGUAGE_ID'], $product->getProductId());

            $productsInfo[] = [
                'product_id' => $product->getProductId(),
                'product_reference' => $product->getProductReference(),
                'product_price' => $product->getProductPrice(),
                'descriptions' => [
                    'description_name' => $productDescription->getProductDescriptionName(),
                    'short_description' => $productDescription->getProductDescriptionShortDescription(),
                    'long_description' => $productDescription->getProductDescriptionDescription(),
                ],
            ];
        }

        $_GET['productsInfo'] = $productsInfo;
        $_GET['allLanguages'] = $this->languageRepo->getAllLanguages();

        $this->db->close();
        include '../views/allProducts.php';
    }

    /**
     * @method GET
     */
    public function renderEditProductView(int $productId)
    {
        $product = $this->productRepo->getProductById($productId);
        $productDescriptions = $this->productDescriptionRepo->getAllProductDescriptionsByProductId($productId);
        $descriptionsData = [];

        foreach ($productDescriptions as $description) {
            $descriptionsData[] = [
                'product_description_id' => $description->getProductDescriptionId(),
                'language_id' => $description->getLanguageId(),
                'language_name' => $this->languageRepo->getLanguageById($description->getLanguageId())->getLanguagesName(),
                'product_description_name' => $description->getProductDescriptionName(),
                'product_description_short' => $description->getProductDescriptionShortDescription(),
                'product_description_long' => $description->getProductDescriptionDescription(),
            ];
        }

        $productData = [
            'product_id' => $product->getProductId(),
            'product_reference' => $product->getProductReference(),
            'product_price' => $product->getProductPrice(),
            'descriptions' => $descriptionsData,
        ];

        $_GET['allLanguages'] = $this->languageRepo->getAllLanguages();
        $_GET['editProduct'] = $productData;

        $this->db->close();
        include '../views/createEditProduct.php';
    }

    /**
     * @method POST
     */
    public function saveProduct(int $productId)
    {
        $this->productRepo->saveProduct($this->getProductSaveData($productId));

        $this->db->close();
        header('Location: ' . $_ENV['SITE_URL']);
        exit();
    }

    /**
     * @method GET
     */
    public function renderCreateProductView()
    {
        $_GET['allLanguages'] = $this->languageRepo->getAllLanguages();

        $this->db->close();
        include '../views/createEditProduct.php';
    }

    /**
     * @method POST
     */
    public function saveNewProduct()
    {
        $this->productRepo->saveNewProduct($this->getProductSaveData());

        $this->db->close();
        header('Location: ' . $_ENV['SITE_URL']);
        exit();
    }

    /**
     * @method POST
     */
    public function deleteProduct(int $productId)
    {
        $this->productRepo->deleteProduct($productId);

        $this->db->close();
        header('Location: ' . $_ENV['SITE_URL']);
        exit();
    }

    private function getProductSaveData(int $productId = null)
    {
        $reference = $_REQUEST['reference'];
        $price = (float)$_REQUEST['price'];

        $languages = $this->languageRepo->getAllLanguages();

        $descriptionNames = [];
        $shortDescriptions = [];
        $longDescriptions = [];

        foreach ($languages as $language) {
            $descriptionNames[] = [
                'language_id' => $language->getLanguageId(),
                'value' => $_REQUEST['description_name_' . $language->getLanguageId()],
            ];
            
            $shortDescriptions[] = [
                'language_id' => $language->getLanguageId(),
                'value' => $_REQUEST['short_description_' . $language->getLanguageId()],
            ];

            $longDescriptions[] = [
                'language_id' => $language->getLanguageId(),
                'value' => $_REQUEST['long_description_' . $language->getLanguageId()],
            ];
        }

        $saveData = [
            'product_id' => $productId,
            'reference' => $reference,
            'price' => $price,
            'descriptionNames' => $descriptionNames,
            'shortDescriptions' => $shortDescriptions,
            'longDescriptions' => $longDescriptions,
        ];

        return $saveData;
    }
}