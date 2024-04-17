<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="stylelogin.css">
    <script src="CheckIn4.js"></script>
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg">

</head>

<body>
    <div class="container">
        <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign Up For An Account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
        <div class="close-button" onclick="window.location.href = 'index.php';">Close</div>
        <br /><br />
        <form action="signup_process.php" method="post">
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
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" onkeydown="checkPass()">
                <input type="checkbox" id="show" onclick="showPass();">Show Password
                <span id="pass-error-msg" style="color:red;"></span>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" onkeydown="checkPassConfirm()">
            </div>
            <button type="submit" id="signupButton" name="signup">Sign up</button>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', checkPhone());
        document.addEventListener('DOMContentLoaded', checkName());
        document.addEventListener('DOMContentLoaded', checkEmail());
        document.addEventListener('DOMContentLoaded', checkAddress());
        document.addEventListener('DOMContentLoaded', checkAccount());
        document.addEventListener('DOMContentLoaded', checkPass());
        document.addEventListener('DOMContentLoaded', checkPassConfirm());
        document.getElementById('signupButton').addEventListener('click', function(event) {
            validateForm();
        });
    </script>

</body>


</html>