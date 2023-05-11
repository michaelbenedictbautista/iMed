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
    if ((firstName.value.trim().length <=0 || firstName == null) || (lastName.value.trim().length <= 0 || lastName == null) || (userName.value.trim().length <= 0 || userName == null) || (newEmail.value.trim().length <= 0 || newEmail == null) || (newPassword.value.trim().length < 8 || newPassword == null) || (contactNumber.value.trim().length <= 0 || contactNumber == null) || (profession.value.trim().length <= 0 || profession == null) || (userLevel.value.trim().length <= 0 || userLevel == null) || (institutionName.value.trim().length <= 0 || institutionName == null)) {
        return false;
    } else {
        return true;
    }
}

//Enabled create button once valid input was met
const userInputValid = () => {
    if(isValid()) { 
        document.getElementById('create-btn').disabled = false;
        btnCreate.setAttribute('class', 'btn btn-primary')
        //btnCreate.setAttribute('disabled', 'removeAttribute()')

    } else { 
        document.getElementById('create-btn').disabled = true;
        btnCreate.setAttribute('class', 'btn btn-secondary')
        // btnCreate.setAttribute('disabled', 'true') 
    }
}

// Type new institution
const handleInstitutionChange = () => {
    var selectedInstitutionOption = document.getElementById("institutionName").value;
    var institutionName_wrapper = document.getElementById("institutionName-wrapper");
    var institutionAddress_wrapper = document.getElementById("institutionAddress-wrapper");

    var institutionNameOther = document.getElementById("institutionNameOther");
    var institutionAddressOther =  document.getElementById("institutionAddressOther");
   

    if (selectedInstitutionOption === "others") {
        institutionName_wrapper.style.display = "block";
        institutionAddress_wrapper.style.display = "block";
        institutionNameOther.required = true;
        institutionAddressOther.required = true;
    } else {
        institutionName_wrapper.style.display = "none";
        institutionAddress_wrapper.style.display = "none";
        institutionNameOther.required = false;
        institutionAddressOther.required = false;
    }
}

