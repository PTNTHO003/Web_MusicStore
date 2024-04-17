<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Store</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg">
</head>

<body>
    <div class="section section1" id="section1">
        <div class="dropdown">
            <?php if (!isset($_SESSION['loggedEMP_in']) && !isset($_SESSION['loggedCUS_in'])) { ?>
                <div class="dropdown-content">
                    <a href="login.php">Đăng nhập</a>
                    <a href="signup.php">Đăng ký</a>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['loggedCUS_in'])) { ?>
                <div class="dropdown-content">
                    <a href="ViewIn4.php">Tài khoản</a>
                    <a href="logout.php">Đăng xuất</a>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['loggedEMP_in'])) { ?>
                <div class="dropdown-content">
                    <a href="logout.php">Đăng xuất</a>
                </div>
            <?php } ?>
        </div>
        <div id="formContainer"></div>
        <img class="logo" src="img/logo.png"></img>
        <img class="cart" src="img/cart.png"></img>
        <div class="navi">
            <table>
                <tr>
                    <td class="menu">
                        <a href="#section1"><img class="home-icon" src="img/home.png"></img></a>
                        <a href="#section2">SONY</a>
                        <a href="#section3">JBL</a>
                        <a href="#section4">BOSE</a>
                        <a href="#section5">MARSHALL</a>
                        <a href="#section6">YAMAHA</a>
                    </td>
                </tr>
            </table>
            <div class="search-bar">
                <img class="img" src="img/search.png"></img>
                <input type="text" placeholder="Search...">
            </div>
        </div>
        <img class="background" src="img/background1.jpg" alt="background-img"></img>
    </div>
    <div class="section section2" id="section2">
        <p>SONY</p>
    </div>
    <!-- ------xác nhận là Employee thì hiện fucntion----------- -->
    <?php
    // if (isset($_SESSION['loggedEMP_in'])) {
    //     echo '<script>';
    //     echo '...';
    //     echo '</script>';
    // }
    ?>


    <!-- ------xác nhận là Customer thì hiện fucntion----------- -->
    <?php
    // if (isset($_SESSION['loggedCUS_in'])) {
    //     echo '<script>';
    //     echo '...';
    //     echo '</script>';
    // }
    ?>



</body>

</html>