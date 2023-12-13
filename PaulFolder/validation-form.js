const form = document.getElementById('form');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const password = document.getElementById('password');
const email = document.getElementById('email');
const phone = document.getElementById('phone');
const birthday = document.getElementById('birthday');
const description = document.getElementById('description');


// Show input error message
function showError(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-control error';
    const small = formControl.querySelector('small');
    small.innerText = message;
}

// Show success outline
function showSuccess(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
}

// Check email is valid
function checkEmail(input) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(input.value.trim())) {
        showSuccess(input);
    } else {
        showError(input, 'Email non valide');
    }
}

// Check required fields
function checkRequired(inputArr) {
    inputArr.forEach(function(input) {
        if (input.value.trim() === '') {
            showError(input, `${getFieldName(input)} est nécessaire`);
        } else {
            showSuccess(input);
        }
    });
}

// Check input length
function checkLength(input, min, max) {
    if (input.value.length < min) {
        showError(
            input,
            `${getFieldName(input)} a besoin d'au moins ${min} caractères`
        );
    } else if (input.value.length > max) {
        showError(
            input,
            `${getFieldName(input)} a besoin de maximum ${max} caractères`
        );
    } else {
        showSuccess(input);
    }
}

// Get fieldname
function getFieldName(input) {
    return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

// Event listeners
form.addEventListener('submit', function(e) {
    e.preventDefault();

    checkRequired([firstname, lastname, password, email, phone, birthday, description]);
    checkLength(firstname, 3, 20);
    checkLength(lastname, 3, 20);
    checkLength(password, 8, 20);
    checkEmail(email);
});
