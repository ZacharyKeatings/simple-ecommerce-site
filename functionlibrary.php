<?php
    function topLeftNavBar(){
        $html = '';
        $html .= "<a href='storefront.php'>Home</a>";
        $html .= "<a href='#'>Link 2</a>";
        $html .= "<a href='#'>Link 3</a>";

        return $html;
    }
?>

<?php
    function siteTitle(){
        $html = '';
        $html .= "ZAKES";

        return $html;
    }
?>

<?php
    function siteSlogan(){
        $html = '';
        $html .='B&nbsp;&nbsp;I&nbsp;&nbsp;B&nbsp;&nbsp;L&nbsp;&nbsp;I&nbsp;&nbsp;O&nbsp;&nbsp;T&nbsp;&nbsp;H&nbsp;&nbsp;É&nbsp;&nbsp;Q&nbsp;&nbsp;U&nbsp;&nbsp;E';

        return $html;
    }
?>

<?php
    $userName = $_COOKIE['Name'];
    $userStudentId = $_COOKIE['StudentId'];
    function topRightNavBar($userName, $userStudentId) {
        $html = '';

        $html .= "User: " . $userName . "<br>";
        $html .= "Student Id: " . $userStudentId;
        $html .= "<br><div class='cart-icon'><a href='cart.php'><img src='images/cart.png' alt='Cart icon' width='40' height='40'>";
        $html .= "<span id='cart-item-count'></span></a></div>";

        return $html;
    }
?>