<?php
session_start();
include 'DB_connection.php';
$dbConnection = new DBConnection();
$conn = $dbConnection->conn;
$acc = $_SESSION['loggedCUS_in'];
$query = "SELECT * FROM T_CUSTOMER WHERE CUSTOMER_ACCOUNT = '$acc'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['CUSTOMER_NAME'];
    $email = $row['CUSTOMER_EMAIL'];
    $address = $row['CUSTOMER_ADDRESS'];
    $account = $row['CUSTOMER_ACCOUNT'];
    $phone = $row['CUSTOMER_PHONE'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg">
    <link rel="stylesheet" href="In4.css">
    <script src="CheckIn4.js"></script>
    <title>Account Information</title>
</head>

<body>
    <div class="container">
        <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Information &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
        <br /><br />
        <table>
            <tr>
                <td><strong>Name:</strong></td>
                <td id="name"><?php echo isset($name) ? $name : ''; ?></td>
                <td><button id="edit-name" class="edit-button" data-field="name">Edit</button></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td id="email"><?php echo isset($email) ? $email : ''; ?></td>
                <td><button id="edit-email" class="edit-button" data-field="email">Edit</button></td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td id="address"><?php echo isset($address) ? $address : ''; ?></td>
                <td><button id="edit-address" class="edit-button" data-field="address">Edit</button></td>
            </tr>
            <tr>
                <td><strong>User name:</strong></td>
                <td id="username"><?php echo isset($account) ? $account : ''; ?></td>
                <td><button id="edit-username" class="edit-button" data-field="username">Edit</button></td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td id="phone"><?php echo isset($phone) ? $phone : ''; ?></td>
                <td><button id="edit-phone" class="edit-button" data-field="phone">Edit</button></td>
            </tr>
        </table>
        <button class="cancel-button" onclick="window.location.href = 'index.php';">Đóng</button>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var editButtons = document.querySelectorAll("[id^='edit-']");
                editButtons.forEach(function(button) {
                    button.addEventListener("click", function() {
                        var fieldName = this.getAttribute("data-field");
                        openModal(fieldName);
                    });
                });
            });
        </script>
</body>

</html>