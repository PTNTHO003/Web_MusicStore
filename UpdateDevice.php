<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesUpdateDevice.css" />
    <title>UPDATE DEVICE INFORMATION</title>
</head>

<body>
    <header>
        <h1>UPDATE DEVICE INFORMATION</h1>
    </header>

    <?php
        include "Device.php";
        $device = new Device();
        $dev_result = $device->get_device($_GET['DEV_ID']);
    ?>

    <form name="update" method="post" action="UpdateHandle.php" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Properties</th>
                <th>Values</th>
            </tr>
            <tr>
                <td> Device ID </td>
                <td>
                    <input type="text" name="dev_id" value="<?php echo $dev_id; ?>" disabled="disabled" />
                    <input type="hidden" name="dev_id" value="<?php echo $dev_id; ?>" />
                </td>
            </tr>
            <tr>
                <td> Device Name </td>
                <td>
                    <input type="text" name="dev_name" value="<?php echo $dev_result['DEV_NAME']; ?>" disabled="disabled" />
                </td>
            </tr>
            <tr>
                <td> Brand </td>
                <td>
                    <input type="text" name="brand_id" value="<?php echo $dev_result['BRAND_NAME']; ?>" disabled="disabled" />
                </td>
            </tr>
            <tr>
                <td> Category </td>
                <td>
                    <input type="text" name="cate_id" value="<?php echo $dev_result['CATE_NAME']; ?>" disabled="disabled" />
                </td>
            </tr>
            <tr>
                <td> Price </td>
                <td>
                    <input type="text" name="dev_price" value="" />
                </td>
            </tr>
            <tr>
                <td>New image of device: </td>
                <td><input type="file" name="dev_image" accept="image/*" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="save" value="SAVE UPDATES" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>