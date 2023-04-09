// Datepicker only  for date of birth
$(document).ready(function() {
  flatpickr("#dob", {
    enableTime: false,
    dateFormat: "Y-m-d H:i",
  });
});

// Medical provider modal function
$(document).ready(function() {
  $('.viewMedProviderBtn').click(function() { 
      patient_id = $(this).attr('id')
      //alert(patient_id)
      $.ajax({
          url: "ajax.php",
          method: 'post',
          data: {
              patient_ID: patient_id
          },
          dataType: 'json',
          
          success: function(result) {     
              $("#viewingProviderName").text("Medical provider: " + result.providerDetail.mp_name);
              $("#viewingProviderNumber").text("Medical number: "+ result.providerDetail.med_number);
              $("#viewingProviderUser").text("Entered By: " + result.providerDetail.first_name + " " + result.providerDetail.last_name + " | " + result.providerDetail.profession);
              $("#viewingProviderUpdatedDate").text("Updated Date: " + result.providerDetail.updated_date);
              
          },
          error: function(xhr, status, error) {
              // Handle error
              console.log(error);
          }
      });

        $('#viewProviderModal').modal("show");
  });
});


// Diagnosis modal function
$(document).ready(function() {
  $('.viewDiagnosisBtn').click(function() { 
    patient_id = $(this).attr('id')
    //alert(patient_id)
    $.ajax({
        url: "ajax.php",
        method: 'post',
        data: {
            dx_patient_ID: patient_id
        },
        dataType: 'json',
        
        success: function(result) {     
            $("#viewingDiagnosis").text("Diagnosis: " + result.diagnosisDetail.dx_text);
            $("#viewingDoctor").text("Doctor: "+ result.diagnosisDetail.name_of_doctor);
            $("#viewingDiagnosisUser").text("Entered By: " + result.diagnosisDetail.first_name + " " + result.diagnosisDetail.last_name + " | " + result.diagnosisDetail.profession);
            $("#viewingDiagnosisUpdatedDate").text("Updated Date: " + result.diagnosisDetail.updated_date);
            
        },
        error: function(xhr, status, error) {
            // Handle error
            console.log(error);
        }
    });

      $('#viewDiagnosisModal').modal("show");
  });
});

// Diet modal function
$(document).ready(function() {
  $('.viewDietBtn').click(function() { 
    patient_id = $(this).attr('id')
    //alert(patient_id)
    $.ajax({
        url: "ajax.php",
        method: 'post',
        data: {
            diet_patient_ID: patient_id
        },
        dataType: 'json',
        
        success: function(result) {     
            $("#viewingDiet").text("Diet: " + result.dietDetail.diet_text);
            $("#viewingDietitian").text("Dietitian: "+ result.dietDetail.name_of_dietitian);
            $("#viewingDietUser").text("Entered By: " + result.dietDetail.first_name + " " + result.dietDetail.last_name + " | " + result.dietDetail.profession);
            $("#viewingDietUpdatedDate").text("Updated Date: " + result.dietDetail.updated_date);
            
        },
        error: function(xhr, status, error) {
            // Handle error
            console.log(error);
        }
    });

      $('#viewDietModal').modal("show");
  });
});

// $('#closeDiagnosisBtn').click(function() { 
//   $(this).find('.modal-body').empty();
//   $('#viewDiagnosisModal').modal("hide");
// });



// Search by name button enable once user inputs in the search box
const searchInputName = document.getElementById("inputName");
const searchBtn = document.getElementById('searchBtn');
const statusBtn = document.getElementById('statusBtn');


searchInputName.addEventListener('keyup', function(event) {
  if(searchInputName.value.length >= 2) { 
  
  // Re-enable the seach button and set button to primary
  searchBtn.disabled = false; 
  searchBtn.setAttribute('class', 'btn btn-primary');

  // Disable the status search button and set button to secondary
  statusBtn.disabled = true; 
  statusBtn.setAttribute('class', 'btn btn-secondary');
  
}else {
  // Disable the seach button and set button to primary
  searchBtn.disabled = true;
  searchBtn.setAttribute('class', 'btn btn-secondary');

  // Disable the status search button and set button to secondary
  statusBtn.disabled = false;
  statusBtn.setAttribute('class', 'btn btn-primary');

  }
})


  // //Hide addProfileModal without refreshing the page
  // const medProviderNumber = document.getElementById('medProviderNumber')
  // const submitMedProviderBtn = document.getElementById('submitMedProviderBtn')
  // submitMedProviderBtn.addEventListener('click', function() {

  //     $("#addProfileModal").modal("hide"); // Hide the modal
  // });






 






// function changeColor() {
//   var testButtonOnly = document.querySelector('.testButtonOnly');
//   var name = document.querySelector('#patient_id12345');
//   var h1Text = document.querySelector('#h1Text');
//   var nameValue=name.value;
//   //h1Text.textContent = nameValue
  
//   var modal_title = document.querySelector('#modal_title');

//   modal_title.textContent = nameValue
 
//   testButtonOnly.style.backgroundColor = 'green'; // working
 
//   // alert(nameValue)
//   $('#viewProviderModal').modal("show");
  
  
// }