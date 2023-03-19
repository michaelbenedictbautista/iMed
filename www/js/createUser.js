// Validate user input
const firstName = document.getElementById("firstName");
const lastName = document.getElementById("lastName");
const userName = document.getElementById("userName");
const newEmail = document.getElementById("email");
const newPassword = document.getElementById("password");
const contactNumber = document.getElementById("contactNumber");
const profession = document.getElementById("profession");
const userLevel = document.getElementById("userLevel");
const institutionName = document.getElementById("institutionName");
const institutionAddress = document.getElementById("institutionAddress");

// Create button
const btnCreate = document.getElementById("create-btn");

// Validate user input
const isValid = () => {
    if ((firstName.value.trim().length <=0 || firstName == null) || (lastName.value.trim().length <= 0 || lastName == null) || (userName.value.trim().length <= 0 || userName == null) || (newEmail.value.trim().length <= 0 || newEmail == null) || (newPassword.value.trim().length < 8 || newPassword == null) || (contactNumber.value.trim().length <= 0 || contactNumber == null) || (profession.value.trim().length <= 0 || profession == null) || (userLevel.value.trim().length <= 0 || userLevel == null) || (institutionName.value.trim().length <= 0 || institutionName == null) || (institutionAddress.value.trim().length <= 0 || institutionAddress == null)) {
        return false;
    } else {
        return true;
    }
}

//Enabled create button once valid input was met
const userInputValid = () => {
    if(isValid()) { 
        document.getElementById('create-btn').disabled = false;
        btnCreate.setAttribute('class', 'btn btn-primary mt-3')
        //btnCreate.setAttribute('disabled', 'removeAttribute()')

    } else { 
        document.getElementById('create-btn').disabled = true;
        btnCreate.setAttribute('class', 'btn btn-secondary mt-3')
        // btnCreate.setAttribute('disabled', 'true') 
    }
}

