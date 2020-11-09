<?php

require '../bootstrap.php';

use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;
use App\Controllers\MainController;

Router::get('/', function () {
    return (new MainController())->getAllProducts();
});

Router::get('/edit-product-view/([0-9]*)', function (Request $request) {
    return (new MainController())->renderEditProductView((int)$request->params[0]);
});

Router::post('/save-product/([0-9]*)', function (Request $request) {
    return (new MainController())->saveProduct((int)$request->params[0]);
});

Router::get('/create-product-view', function () {
    return (new MainController())->renderCreateProductView();
});

Router::post('/save-new-product', function (Request $request) {
    return (new MainController())->saveNewProduct();
});

Router::post('/delete-product/([0-9]*)', function (Request $request) {
    return (new MainController())->deleteProduct((int)$request->params[0]);
});

?>