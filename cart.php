
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
            <div class="header-div"><h2>Your Shopping Cart:</h2></div>
        
        </div>
    </main>

    <script src="scripts.js"></script> 
</body>
</html>