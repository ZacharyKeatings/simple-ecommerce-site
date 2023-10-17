
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="styles.css">
    <title>Zake's</title>
</head>
<body>
    <?php 
        include 'products.php';
        include 'functionlibrary.php';
    ?>
    
    <header>
        <nav class="navbar">
            <div class="left-links">
                 <?php echo topLeftNavBar() ?>
            </div>
            <div id="site-logo">
                <div id="site-title">
                    <?php echo siteTitle() ?>
                </div>
                <div id="site-slogan">
                    <?php echo siteSlogan() ?>
                </div>
            </div>
            <div class="right-content">
                <div class="nav-user-info-text">
                    <?php 
                    echo topRightNavBar($userName, $userStudentId);
                    ?>
                </div>
            </div>
    </header>

    <main>
        <div class="right-column">
        <?php
            $onSaleProducts = '';
            $regularProducts = '';
            $productCount = count($products);

            foreach ($products as $index => $product) {
                // Extract product details
                $id = $product['id'];
                $name = $product['product_name'];
                $imageUrl = $product['image_url'];
                $availableQuantity = $product['quantity'];
                

                // Construct the HTML structure for the current product
                $productHTML = '<div class="product">';
                $productHTML .= '<div class="name"><a href="product_details.php?id='. $id .'">' . $name . '</div>';
                $productHTML .= '<div class="product-image"><img src="' . $imageUrl . '" width="175" height="275" alt="Image description"></a></div>';
                if ($product['on_sale']){
                    $productprice = number_format($product['sale_price'], 2);
                    $productHTML .= '<div class="price-quantity-select"><div class="price-div">$<s>' . $product['regular_price'] . '</s> <span style="color: red; font-weight: bold;"> $' . $productprice . '</span></div>';
                } else {
                    $productprice = number_format($product['regular_price'], 2);
                    $productHTML .= '<div class="price-quantity-select"><div class="price-div">$' . $productprice . '</div>';
                }

                if ($availableQuantity == 0) {
                    $productHTML .= '<div class="out-of-stock">OUT OF STOCK</div>';
                } else {
                    $productHTML .= '<input type="number" id="quantityInput' . $id . '" value="1">';
                    $productHTML .= '<button onclick="addToCart(' . $id . ', \'' . $name . '\', ' . $productprice . ',' . $availableQuantity . ')">Add To Cart</button>';
                }

                $productHTML .= '</div></div>';

                // Determine if it's the last product
                $isLastProduct = ($index === $productCount - 1);

                // Append the product HTML to the appropriate products variable
                if ($product['on_sale']) {
                    if (!$isLastProduct) {
                        $onSaleProducts .= $productHTML;
                    }
                } else {
                    if (!$isLastProduct) {
                        $regularProducts .= $productHTML;
                    }
                }
            }

            // Echo the products
            echo '<div class="header-div"><h2>Currently On Sale:</h2></div>';
            echo $onSaleProducts;
            echo '<div class="header-div"><h2>Regular Price Products:</h2></div>';
            echo $regularProducts;
        ?>

        </div>
    </main>

    <script src="scripts.js"></script>  
</body>
</html>