<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
                if ($_GET['editProduct'] === null) {
                    echo 'Create product';
                } else {
                    echo 'Edit ' . $_GET['editProduct']['product_reference'];
                }
            ?>
            - Demo
        </title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container bg-light pt-2 pb-2">
            <h1 class="mb-4 mt-2">
                <?php
                    if ($_GET['editProduct'] === null) {
                        echo 'Create new product';
                    } else {
                        echo 'Edit product ' . $_GET['editProduct']['product_reference'];
                    }
                ?>
            </h1>

            <form class="mb-5" action=
                <?php
                    if ($_GET['editProduct'] === null) {
                        echo '"/save-new-product"';
                    } else {
                        echo '"/save-product/' . $_GET['editProduct']['product_id'] . '"';
                    }
                ?>
            method="POST">

                <div class="form-group">
                    <label for="reference">* Reference:</label>
                    <input type="text" class="form-control" name="reference" value="<?php echo $_GET['editProduct']['product_reference'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">* Price:</label>
                    <input type="text" class="form-control" name="price" value="<?php echo $_GET['editProduct']['product_price'] ?>" required>
                </div>

                <div class="pt-5">
                    <span class="mt-3"><b>Languages:</b></span>

                    <?php
                        $html = '';
                        $allLanguages = $_GET['allLanguages'];

                        foreach ($allLanguages as $language) {
                            $html .= '<div class="mt-4">';
                            $html .= '<span><b>' . $language->getLanguagesName() . '</b></span>';
                            $html .= '</div>';

                            $html .= '<div class="form-group">';
                            $html .= '<label for="description_name_' . $language->getLanguageId() . '">Description name:</label>';
                            $html .= '<input type="text" class="form-control" id="description_name_' . $language->getLanguageId() . '" name="description_name_' . $language->getLanguageId() . '">';
                            $html .= '</div>';

                            $html .= '<div class="form-group">';
                            $html .= '<label for="short_description_' . $language->getLanguageId() . '">Short description:</label>';
                            $html .= '<textarea rows=5 class="form-control" id="short_description_' . $language->getLanguageId() . '" name="short_description_' . $language->getLanguageId() . '"></textarea>';
                            $html .= '</div>';

                            $html .= '<div class="form-group">';
                            $html .= '<label for="long_description_' . $language->getLanguageId() . '">Long description:</label>';
                            $html .= '<textarea rows=5 class="form-control" id="long_description_' . $language->getLanguageId() . '" name="long_description_' . $language->getLanguageId() . '"></textarea>';
                            $html .= '</div>';
                        }
                    
                        echo $html;
                    ?>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/" class="btn btn-danger ml-2">Cancel</a>
            </form>
        </div>
    </body>

    <script>
        $(function() {
            let createPage = '<?php echo ($_GET['editProduct'] === null) ?>';

            if (createPage !== '1') {
                <?php
                    $productInfo = $_GET['editProduct'];

                    foreach ($productInfo['descriptions'] as $description) {
                        echo "$('#description_name_" . $description['language_id'] . "').val('" . $description['product_description_name'] . "');";
                        echo "$('#short_description_" . $description['language_id'] . "').html(`" . $description['product_description_short'] . "`);";
                        echo "$('#long_description_" . $description['language_id'] . "').html(`" . $description['product_description_long'] . "`);";
                    }
                ?>
            }
        });
    </script>
</html>