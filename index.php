<!DOCTYPE html>
<html lang="en">
<head>
    <script>
    if (document.cookie != "") {
        window.location.href = "storefront.php"
    }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="styles.css">
    <title>Zake's</title>
</head>
<body>
    <div id="bodydiv">
        <div id="formdiv">
            <form action="storefront.php" method="post" id="userForm" onsubmit="setCookie('fullname', 'Name'); setCookie('studentid', 'StudentId')">
            <caption>Zakes Bibliotheque</caption><br>
                Name:<br><input name="name" id="fullname" required><br>
                Student ID:<br><input name="student-id" id="studentid" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>