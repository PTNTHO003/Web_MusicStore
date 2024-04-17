//------------check Phone-------------//
function checkPhone() {
    var phoneInput = document.getElementById('phone');
    var phoneRegex = /^(84|0)?[0-9]{9,10}$/;
    phoneInput.addEventListener('input', function () {
        var phoneValue = phoneInput.value.trim();
        if (phoneValue === '') {
            document.getElementById('phone-error-msg').textContent = 'Vui lòng nhập số điện thoại.';
        } else if (!phoneRegex.test(phoneValue)) {
            document.getElementById('phone-error-msg').textContent = 'Số điện thoại không hợp lệ.';
        } else {
            document.getElementById('phone-error-msg').textContent = '';
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_field.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.responseText === 'phoneExists') {
                    document.getElementById('phone-error-msg').textContent = 'Số điện thoại đã tồn tại.';
                } else {
                    document.getElementById('phone-error-msg').textContent = '';
                }
            };
            xhr.send('phone=' + phoneValue);
        }
    });
}

//------------check name-------------//
function checkName() {
    var nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function () {
        var nameValue = nameInput.value.trim();
        if (nameValue === '') {
            document.getElementById('name-error-msg').textContent = 'Vui lòng nhập tên.';
        } else {
            document.getElementById('name-error-msg').textContent = '';
        }
    });
}

//------------check email-------------//
function checkEmail() {
    var emailInput = document.getElementById('email');
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailInput.addEventListener('input', function () {
        var emailValue = emailInput.value.trim();
        if (emailValue === '') {
            document.getElementById('email-error-msg').textContent = 'Vui lòng nhập email.';
        } else if (!emailRegex.test(emailValue)) {
            document.getElementById('email-error-msg').textContent = 'Email không hợp lệ.';
        } else {
            document.getElementById('email-error-msg').textContent = '';
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_field.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.responseText === 'emailExists') {
                    document.getElementById('email-error-msg').textContent = 'Email đã tồn tại.';
                } else {
                    document.getElementById('email-error-msg').textContent = '';
                }
            };
            xhr.send('email=' + emailValue);
        }
    });
}

//------------check address-------------//
function checkAddress() {
    var addressInput = document.getElementById('address');

    addressInput.addEventListener('input', function () {
        var addressValue = addressInput.value.trim();
        if (addressValue === '') {
            document.getElementById('address-error-msg').textContent = 'Vui lòng nhập tên địa chỉ.';
        } else {
            document.getElementById('address-error-msg').textContent = '';
        }
    });

}

//------------check username-------------//
function checkAccount() {
    var accountInput = document.getElementById('account');
    var accountValue;

    accountInput.addEventListener('input', function () {
        accountValue = accountInput.value.trim();
        if (accountValue === '') {
            document.getElementById('account-error-msg').textContent = 'Vui lòng nhập tên người dùng.';
        } else {
            document.getElementById('account-error-msg').textContent = '';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_field.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.responseText === 'accountExists') {
                    document.getElementById('account-error-msg').textContent = 'Tên người dùng đã tồn tại.';
                } else {
                    document.getElementById('account-error-msg').textContent = '';
                }
            };
            xhr.send('account=' + accountValue);
        }
    });
}

//------------check password-------------//
function checkPass() {
    var passInput = document.getElementById('password');

    passInput.addEventListener('input', function () {
        var passValue = passInput.value.trim();
        if (passValue === '') {
            document.getElementById('pass-error-msg').textContent = 'Vui lòng nhập mật khẩu.';
        }
        else {
            document.getElementById('pass-error-msg').textContent = '';
        }
    });

    passInput.addEventListener('focus', function () {
        document.getElementById('pass-error-msg').textContent = '';
    });

}

function showPass() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
//------------check password Confirm-------------//
function checkPassConfirm() {
    var passInput = document.getElementById('password');
    var confirmPassInput = document.getElementById('confirm_password');
    var passErrorMsg = document.getElementById('pass-error-msg');

    confirmPassInput.addEventListener('input', function () {
        var passValue = passInput.value.trim();
        var confirmPassValue = confirmPassInput.value.trim();

        if (confirmPassValue === '') {
            passErrorMsg.textContent = 'Vui lòng nhập mật khẩu xác nhận.';
        } else if (confirmPassValue !== passValue) {
            passErrorMsg.textContent = 'Mật khẩu xác nhận chưa đúng.';
        } else {
            passErrorMsg.textContent = '';
        }
    });
}

//------------SignUp button-------------//

document.addEventListener("DOMContentLoaded", function () {
    function validateForm() {
        var errorMessages = document.querySelectorAll('[id$="-error-msg"]');
        var inputFields = document.querySelectorAll('input');
        for (var i = 0; i < errorMessages.length; i++) {
            if (errorMessages[i].textContent !== '') {
                return false;
            }
        }
        for (var j = 0; j < inputFields.length; j++) {
            if (inputFields[j].value.trim() === '') {
                return false;
            }
        }
        return true;
    }
    document.getElementById('signupButton').addEventListener('click', function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
});

// -------------------------------------------
function closeModal() {
    var modal = document.getElementById("modal");
    modal.style.display = "none";
}

function openModal(fieldName) {
    var modal = document.getElementById("modal");
    var fieldLabel = document.getElementById(fieldName).textContent.trim();
    var currentValue = document.getElementById(fieldName).textContent.trim();

    var modalContent = document.getElementById("modal-content");
    modalContent.innerHTML = `
        <h2>Edit ${fieldLabel}</h2>
        <input type="text" id="new-value" value="${currentValue}">
        <button onclick="updateField('${fieldName}')">OK</button>
        <button onclick="closeModal()">Cancel</button>
    `;

    modal.style.display = "block";
}



// document.addEventListener("DOMContentLoaded", function () {
//     function modal() {
//         var editButtons = document.querySelectorAll("[id^='edit-']");
//         editButtons.forEach(function (button) {
//             button.addEventListener("click", function () {
//                 var fieldName = this.getAttribute("data-field");
//                 openModal(fieldName);
//             });
//         });
//     }
// });

