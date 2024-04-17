<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="stylesheet" href="In4.css">
    <script src="signup.js"></script>
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg">

</head>

<body>

    <div class="container">
        <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update your information &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
        <br /><br />
        <form action="UpdateIn4_process.php" method="post">
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" onkeydown="checkPhone()">
                <span id="phone-error-msg" style="color:red;"></span>
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" onkeydown="checkInput(name,name-error-msg)">
                <span id="name-error-msg" style="color:red;"></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" onkeydown="checkEmail()">
                <span id="email-error-msg" style="color:red;"></span>
            </div>
            <div>
                <label for="address">Address(số nhà/xã phường/Quận/tỉnh TP):</label>
                <input type="text" id="address" name="address" onkeydown="checkAddress()">
                <span id="address-error-msg" style="color:red;"></span>
            </div>
            <div>
                <label for="account">User name:</label>
                <input type="text" id="account" name="account" onkeydown="checkAccount()">
                <span id="account-error-msg" style="color:red;"></span>
            </div>
            <button class="cancel-button" onclick="window.location.href = 'index.php';">Cancel</button>
            <button id="signupButton" class="edit-button" id="signupButton" name="UpdateIn4">Sửa thông tin</button>
    </div>
    <script>
        document.getElementById('signupButton').addEventListener('click', function(event) {
            validateForm();
        });
    </script>

</body>



</html>