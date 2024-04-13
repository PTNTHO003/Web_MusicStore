<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $errors = array();

    // Check if an image is uploaded
    if (empty($_FILES["dev_image"]["name"]) && !$_FILES['tree_pic']['error'] === UPLOAD_ERR_OK) {
        $errors[] = "Image is required";
    }

    // Validate price
    if (!isset($_POST["dev_price"]) || !is_numeric($_POST["dev_price"])) {
        $errors[] = "Invalid price";
    }

    // If there are errors, display them and redirect back to the form
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
        echo "<a href='javascript:history.back()'>Go back</a>";
        exit;
    }


    include "Device.php";
    $device = new Device();


    $old_directory = "img/";

    $old_brand_name = $device->get_brand($_POST["brand_id"]);
    $old_brand_name = strtoupper($old_brand_name);
    switch ($old_brand_name){
        case "SONY":
            $old_directory .= "SONY/";
        case "JBL":
            $old_directory .= "JBL/";
        case "MARSHALL":
            $old_directory .= "MARSHALL/";
        case "BOSE":
            $old_directory .= "BOSE/";
        case "YAMAHA":
            $old_directory .= "YAMAHA/";
    }

    $dev_info = $device->get_device($_POST["dev_id"]);

    if ($dev_info->num_rows > 0) {

        $row = $dev_info->fetch_assoc();
    
        $old_directory .= $row['DEV_IMAGEURL'];
    }

    // Delete the old image of the device
    if (file_exists($old_directory)) {
        unlink($old_directory);
        echo "<p>Old image deleted successfully</p>";
    } else {
        echo "<p>Old image does not exist</p>";
    }

    // update new information of device

    $new_dev_price = $_POST["dev_price"];

    $pic_name = $_FILES['dev_image']['name'];
    $file_tmp_name = $_FILES['dev_image']['tmp_name'];
    $file_size = $_FILES['dev_image']['size'];
    $file_type = $_FILES['dev_image']['type'];

    $upload_directory = "img/";
    $brand_name = $device->get_brand($_POST["brand_id"]);
    $brand_name = strtoupper($brand_name);
    switch ($brand_name){
        case "SONY":
            $upload_directory .= "SONY/";
        case "JBL":
            $upload_directory .= "JBL/";
        case "MARSHALL":
            $upload_directory .= "MARSHALL/";
        case "BOSE":
            $upload_directory .= "BOSE/";
        case "YAMAHA":
            $upload_directory .= "YAMAHA/";
    }
    $target_file = $upload_directory . basename($pic_name);

    if (move_uploaded_file($file_tmp_name, $target_file)) {
        echo "<p> Upload image successfully <p>";
    } else {
        echo "Error when uploading image.";
    }

    $device->update_device($_POST["dev_id"], $pic_name, $new_dev_price);

} else {
    // If the form is not submitted via POST method, redirect the user back to the form
    header("Location: UpdateDevice.php");
    exit;
}
?>