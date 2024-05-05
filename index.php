<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg">
    <script type="text/javascript" src="function.js"></script>
    <title>Store</title>
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
            <h3>Brands</h3>
            <div id="btnBrands">
                <?php
                //echo "<button class='btn active' id=showallbutton onclick=\"filterBrands(\"all\")\">SHOW ALL</button>";
                ?>
                <button class="btn active" onclick="filterBrands('all')">ALL</button>
                <?php
                foreach ($brand_list as $brand) {
                    $name_brand = $brand['BRAND_NAME'];
                    echo "<button class='btn' onclick=\"filterBrands('$name_brand')\">$name_brand</button>";
                }
                ?>
            </div>

            <h3>Category</h3>
            <div>
                <tr>
                    <td>
                        <select name="cate_id" id="cate-filter" title="Select category">
                            <?php
                            $categories = $device->get_cate_list();
                            if ($categories === false) {
                                echo "<option value=''>Error retrieving categories</option>";
                            } else {
                                // Display each category as an option in the select dropdown
                                echo "<option value='all'>All</option>";
                                foreach ($categories as $category) {
                                    echo "<option>" . $category['CATE_NAME'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </div>

            <h3>Price</h3>
            <div>
                <label for="min-price">Min Price:</label>
                <input type="number" id="min-price" class="filter-input" min="0">
            </div>
            <div>
                <label for="max-price">Max Price:</label>
                <input type="number" id="max-price" class="filter-input" min="0">
            </div>
            <button id="apply-price-filter">Apply Price Range</button>
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
                    echo "<p class='product-cate' data-cate='$cate_name'>Category: $cate_name</p>";
                    echo "<p class='product-brand' data-brand='$brand_name'>Brand: $brand_name</p>";
                    echo "<p class='product-price' data-price='$dev_price'>Price: $dev_price</p>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>

    </div>



</body>

</html>