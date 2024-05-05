<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="stylesAddDevice.css" />
    <title>Add New Device</title>
</head>

<body>
    <h1> ADD NEW DEVICE </h1>
    <form action="AddingHandle.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Name of device </td>
                <td><input type="text" name="dev_name" required></td>
            </tr>
            <tr>
                <td>Category: </td>
                <td>
                    <select name="cate_id" required>
                        <?php
                        include "Device.php";
                        $device = new Device();
                        $categories = $device->get_cate_list();
                        if ($categories === false) {
                            echo "<option value=''>Error retrieving categories</option>";
                        } else {
                            foreach ($categories as $category) {
                                echo "<option value='" . $category['CATE_ID'] . "'>" . $category['CATE_NAME'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Brand: </td>
                <td>
                    <select name="brand_id" required>
                        <?php
                        $brands = $device->get_brand_list();

                        foreach ($brands as $brand) {
                            echo "<option value='" . $brand['BRAND_ID'] . "'>" . $brand['BRAND_NAME'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Image of device: </td>
                <td><input type="file" name="dev_image" accept="image/*" required></td>
            </tr>
            <tr>
                <td>Price: </td>
                <td><input type="text" name="dev_price" required></td>
            </tr>
            <tr>
                <td><input type="submit" name="add_device" value="Add Device"></td>
                <td><input type="reset" value="Reset"></td>
            </tr>
        </table>
    </form>
</body>

</html>