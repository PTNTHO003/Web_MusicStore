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

    <div class="section2">
        <?php
        include "Device.php";
        $device = new Device();

        $device_list = $device->get_device_list();
        $brand_list = $device->get_brand_list();
        $cate_list = $device->get_cate_list();
        ?>
        <div class="filter-container">
            <h2>Filters</h2>
            <h3>Brands: </h3>
            <?php
            foreach ($brand_list as $brand) {
                $name_brand = $brand['BRAND_NAME'];
                echo "<input type='checkbox' id='$name_brand-brand' class='filter-checkbox' 
                    data-filter='$name_brand'> <label for='$name_brand-brand'>$name_brand    </label>";
            }
            ?>
            <h3>Price: </h3>
            <div>
                <label for="min-price">Min Price:</label>
                <input type="number" id="min-price" class="filter-input" min="0">
            </div>
            <div>
                <label for="max-price">Max Price:</label>
                <input type="number" id="max-price" class="filter-input" min="0">
            </div>
            <button id="apply-price-filter">Apply Filter</button>
        </div>

        <div id="product-container">
            <ul id="product-list" class="product-list">
                <?php
                foreach ($device_list as $device) {
                    $dev_id = $device['DEV_ID'];
                    $dev_name = $device['DEV_NAME'];
                    $cate_id = $device['CATE_ID'];
                    $brand_id = $device['BRAND_ID'];
                    $dev_image = $device['DEV_IMAGEURL'];
                    $dev_price = $device['DEV_PRICE'];
                    $img_directory = "img/";

                    // Lấy tên thương hiệu từ danh sách thương hiệu
                    $brand_name = "";
                    foreach ($brand_list as $brand) {
                        if ($brand['BRAND_ID'] == $brand_id) {
                            $brand_name = $brand['BRAND_NAME'];
                            break;
                        }
                    }

                    // Lấy tên danh mục từ danh sách danh mục
                    $cate_name = "";
                    foreach ($cate_list as $category) {
                        if ($category['CATE_ID'] == $cate_id) {
                            $cate_name = $category['CATE_NAME'];
                            break;
                        }
                    }

                    $brand_name = strtoupper($brand_name);
                    switch ($brand_name) {
                        case "SONY":
                            $img_directory .= "SONY/";
                            break;
                        case "JBL":
                            $img_directory .= "JBL/";
                            break;
                        case "MARSHALL":
                            $img_directory .= "MARSHALL/";
                            break;
                        case "BOSE":
                            $img_directory .= "BOSE/";
                            break;
                        case "YAMAHA":
                            $img_directory .= "YAMAHA/";
                            break;
                    }

                    $img_directory = $img_directory . $dev_image;

                    // Hiển thị một mục món hàng trong danh sách
                    echo "<li class='product-item'>";
                    echo "<img class='product-img' src='$img_directory' alt='$dev_name'>";
                    echo "<h3>$dev_name</h3>";
                    echo "<p>Category: $cate_name</p>";
                    echo "<p>Brand: $brand_name</p>";
                    echo "<p class='product-price'>Price: $dev_price</p>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>

    </div>



</body>

</html>