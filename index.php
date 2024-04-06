<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="function.js"></script>
    <title>Store</title>
</head>

<body>
    <div class="section section1" id="section1">
        <img class="user" src="img/user-avt.png"></img>
        <img class="logo" src="img/logo.jpg"></img>
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

    <div class="section section3" id="section3">
        <p>JBL</p>
    </div>

    <div class="section section4" id="section4">
        <p>BOSE</p>
    </div>

    <div class="section section5" id="section5">
        <p>MARSHALL</p>
    </div>

    <div class="section section6" id="section6">
        <p>YAMAHA</p>
    </div>



</body>

</html>