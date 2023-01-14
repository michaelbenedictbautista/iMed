const emailField = document.getElementById("email");
const pwField = document.getElementById("password");
const btnSignin = document.getElementById("signin-btn");

//btnSignin.setAttribute('class', 'btn btn-secondary mt-3')

//Enabled signin button once valid input was met
const userInput = () => {
    if(emailField.value.length > 2 && pwField.value.length > 8) { 
        document.getElementById('signin-btn').disabled = false;
        btnSignin.setAttribute('class', 'btn btn-primary mt-3')
        //btnSignin.setAttribute('disabled', 'removeAttribute()') 
       
    } else { 
        document.getElementById('signin-btn').disabled = true;
        // btnSignin.setAttribute('class', 'btn btn-secondary mt-3')
        // btnSignin.setAttribute('disabled', 'true')          
    }
}

