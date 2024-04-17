<?php
include 'DB_connection.php';
$dbConnection = new DBConnection();
$conn = $dbConnection->conn;
$loginEMP_ok = false;
$loginCUS_ok = false;
$msg = "";
if (
    isset($_POST['login']) && !empty($_POST['account'])
    && !empty($_POST['password'])
) {
    $acc = $_POST['account'];
    $passwd = $_POST['password'];
    $sql_employee = "SELECT EMP_ACCOUNT, EMP_PASSWORD FROM T_EMPLOYEE WHERE EMP_ACCOUNT = '$acc'";
    $result_employee = $conn->query($sql_employee);
    $sql_customer = "SELECT CUSTOMER_ACCOUNT, CUSTOMER_PASSWORD FROM T_CUSTOMER WHERE CUSTOMER_ACCOUNT = '$acc'";
    $result_customer = $conn->query($sql_customer);

    if ($result_employee->num_rows > 0) {
        while ($row_employee = $result_employee->fetch_assoc()) {
            if ($passwd == $row_employee['EMP_PASSWORD']) {
                $loginEMP_ok = true;
                break;
            } else {
                $msg = "Wrong user name or password!";
            }
        }
    } elseif ($result_customer->num_rows > 0) {
        while ($row_customer = $result_customer->fetch_assoc()) {
            if ($passwd == $row_customer['CUSTOMER_PASSWORD']) {
                $loginCUS_ok = true;
                break;
            } else {
                $msg = "Wrong user name or password!";
            }
        }
    } else {
        $msg = "User not found!";
    }
}

if ($loginEMP_ok) {
    session_start();
    $_SESSION['loggedEMP_in'] = $acc;
    header('Refresh: 0.5; URL = index.php');
}

if ($loginCUS_ok) {
    session_start();
    $_SESSION['loggedCUS_in'] = $acc;
    header('Refresh: 0.5; URL = index.php');
}
$conn->close();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="close-button" onclick="window.location.href = 'index.php';">Close</div>
        <h2>Login to Your Account</h2>
        <h4 style="color:red;"><?php echo $msg; ?></h4>
        <br /><br />
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label for="account">Account:</label>
                <input type="text" name="account" id="account">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit" name="login">Log in</button>
        </form>
    </div>
</body>

</html>