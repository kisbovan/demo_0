<!DOCTYPE html>
<html>
    <head>
        <title>All products - Demo</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container bg-light pt-2 pb-2">
            <h1 class="mb-4 mt-2">All Products</h1>
            <div class="row">
                <div class="col">
                    <a href="/create-product-view" class="btn btn-warning mb-5">Create new product</a>
                </div>
            </div>
            <?php 
                $productsInfo = $_GET['productsInfo'];
                $html = '';

                foreach ($productsInfo as $productInfo) {
                    $html .= '<div class="card mb-4">';
                    $html .= '<h5 class="card-header">' . $productInfo['descriptions']['description_name'] . ' (' . $productInfo['product_reference'] . ') - ' . $productInfo['product_price'] . '</h5>';
                    $html .= '<div class="card-body">';
                    $html .= '<h5 class="card-title">' . $productInfo['descriptions']['short_description'] . '</h5>';
                    $html .= '<p class="card-text">' . $productInfo['descriptions']['long_description'] . '</p>';
                    $html .= '<a href="/edit-product-view/' . $productInfo['product_id'] . '" class="btn btn-primary mr-3">' . Edit . '</a>';
                    $html .= '<form action="/delete-product/' . $productInfo['product_id'] . '" method="POST" class="pt-2 delete_product_form"><button type="submit" class="btn btn-danger">Delete</button></form>';
                    $html .= '</div>';
                    $html .= '</div>';
                }

                echo $html;
            ?>
        </div>
    </body>

    <script>
        $(function() {
            $('.delete_product_form').submit(function (event) {
                let answer = confirm('Are you sure?');

                if (!answer) {
                    event.preventDefault();
                }
            });
        });
    </script>
</html>