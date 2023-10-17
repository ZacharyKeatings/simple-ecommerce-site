
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
        include 'phpqrcode/qrlib.php';
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
                if (isset($_GET['id'])) {
                    $productId = $_GET['id'];
                
                    // Find the product details based on the product ID
                    $product = null;
                    foreach ($products as $item) {
                        if ($item['id'] == $productId) {
                            $product = $item;
                            break;
                        }
                    }
                
                    if ($product) {
                        $id = $product['id'];
                        $name = $product['product_name'];
                        $productprice;

                        $availableQuantity = $product['quantity'];

                        echo '<div class="product-title"><h2>' . $product['product_name'] . '</h2></div>';
                        echo '<div class="product-image"><img src="' . $product['image_url'] . '" width="250" alt="Image description"></div>';
                        echo '<div class="product-description">' . $product['description'] . '</div>';
                        if ($product['on_sale']) {
                            $productprice = number_format($product['sale_price'], 2);
                            echo '<div class="price-quantity-select"><div class="price-div">$<s>' . $product['regular_price'] . '</s> <span style="color: red; font-weight: bold;"> $' . number_format($productprice, 2) . '</span></div>';
                        } else {
                            $productprice = $product['regular_price'];
                            echo '<div class="price-quantity-select"><div class="price-div">$' . $productprice . '</div>';
                        }
                        if ($availableQuantity == 0) {
                            echo '<div class="out-of-stock">OUT OF STOCK</div>';
                        } else {
                            echo '<input type="number" id="quantityInput" value="1">';
                            echo '<button onclick="addToCart(' . $id . ', \'' . $name . '\', ' . $productprice . ',' . $availableQuantity . ')">Add To Cart</button></div>';
                        }
                        // Data to encode into the QR code
                        $data = "product_details.php?id=" . $product['id']; // Replace with your data (e.g., a URL)
                        $pnglocation = "qrcodepng/" . $product['id'] . ".png";
                        // Output the QR code as an image
                        QRcode::png($data, $pnglocation, 'L', 4, 2);

                        echo '<div class="qr-div"><img src="' . $pnglocation . '"></div>';
                        // echo '<button onclick="addToCart(\'\'' . $product['id'] .  '\', \'' . $product['product_name'] . '\', ' . $productprice . ', 1, \'' . $product['quantity'] . '\')">Add to cart</button>';
                    } else {
                        echo 'Product not found.';
                    }
                } else {
                    echo 'Product ID not provided.';
                }
            ?>
        </div>
    </main>

    <script src="scripts.js"></script>  
</body>
</html>