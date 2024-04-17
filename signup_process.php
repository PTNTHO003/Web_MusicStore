<?php
include 'DB_connection.php';
$dbConnection = new DBConnection();
$conn = $dbConnection->conn;
$loginCUS_ok = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $acc = $_POST['account'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO `T_CUSTOMER` (CUSTOMER_PHONE,CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_ADDRESS, CUSTOMER_ACCOUNT, CUSTOMER_PASSWORD)
VALUES('$phone', '$name', '$email', '$address', '$acc', '$password')";

    if ($conn->query($sql) === TRUE) {
        header('Refresh: 0.5; URL = index.php');
        session_start();
        $_SESSION['loggedCUS_in'] = $acc;
    } else {
        echo "Đã xảy ra lỗi khi đăng ký: " . $conn->error;
    }

    $conn->close();
}
