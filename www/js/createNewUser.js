const firstName = document.getElementById("firstName");
const lastName = document.getElementById("lastName");
const userName = document.getElementById("userName");
const email = document.getElementById("email");
const password = document.getElementById("password");
const contactNumber = document.getElementById("contactNumber");
const profession = document.getElementById("profession");
const userLevel = document.getElementById("userLevel");
const institutionName = document.getElementById("institutionName");
const institutionAddress = document.getElementById("institutionAddress");

const btnSignin = document.getElementById("create-btn");


// Validate user input
const validInput = () => {
    if ((firstName == null || firstName.value.trim().length > 0) && (lastName == null || lastName.value.trim().length > 0) && (userName == null || userName.value.trim().length > 0) && (email == null || email.value.trim().length > 0) && (password == null || password.value.trim().length >= 8) && (contactNumber == null || contactNumber.value.trim().length > 0) && (profession == null || profession.value.trim().length > 0) && (userLevel == null || userLevel.value.trim().length > 0) && (institutionName == null || institutionName.value.trim().length > 0) && (institutionAddress == null || institutionAddress.value.trim().length > 0)) {
        return true;
    } else {
        return false;
    }
}

//Enabled create button once valid input was met
const userInput = () => {
    if(validInput()) { 
        document.getElementById('create-btn').disabled = false;
        btnSignin.setAttribute('class', 'btn btn-primary mt-3')
        //btnSignin.setAttribute('disabled', 'removeAttribute()') 
       
    } else { 
        document.getElementById('create-btn').disabled = true;
        btnSignin.setAttribute('class', 'btn btn-secondary mt-3')
        // btnSignin.setAttribute('disabled', 'true')          
    }
}

