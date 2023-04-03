// Datepicker for date of birth
$(document).ready(function(){
  $('.dob').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
  });
});

// Search by name button enable once user inputs in the search box
const searchInputName = document.getElementById("inputName");
const searchBtn = document.getElementById('searchBtn')
const statusBtn = document.getElementById('statusBtn')


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
});

  // //Hide addProfileModal without refreshing the page
  // const medProviderNumber = document.getElementById('medProviderNumber')
  // const submitMedProviderBtn = document.getElementById('submitMedProviderBtn')
  // submitMedProviderBtn.addEventListener('click', function() {

  //     $("#addProfileModal").modal("hide"); // Hide the modal
  // });



// function for passing data without refreshing the page
$(document).ready(function() {
  $('.viewMedProviderBtn').click(function() {
      patient_id = $(this).attr('id')
      alert(patient_id)
      // $.ajax({
      //     url: "ajax.php",
      //     method: 'post',
      //     data: {
      //       patient_ID: patient_id
      //     },
      //     dataType: 'json',
          
      //     success: function(result) {     
      //         $("#viewingProviderName").text(result.providerDetail.mp_name);
      //         $("#viewingProviderNumber").text(result.providerDetail.med_number);
      //         $("#viewingProviderUser").text("Entered By: " + result.providerDetail.first_name + " " + result.providerDetail.last_name + " | " + result.providerDetail.profession);
      //         $("#viewingProviderUpdatedDate").text(result.providerDetail.updated_date);
              
      //     },
      //     error: function(xhr, status, error) {
      //         // Handle error
      //         console.log(error);
      //     }
      // });

      //  $('#viewProviderModal').modal("show");
      
  })
});

  