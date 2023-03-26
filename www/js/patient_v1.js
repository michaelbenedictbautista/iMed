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
    // Prevent the default form submission behavior
    //event.preventDefault();
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

  

// $(document).ready(function() {
//   $('.statusSelected').on('change', function() {
//     var selectedValue = $(this).val();
//     $.ajax({
//       url: 'ajax.php',
//       type: 'POST',
//       data: {value: selectedValue},
//       dataType: 'json',
//       success: function(results) {
//         // handle the response from the server
        
//         $("#patient-name").text(result.resultStatus.first_name);
//       },
//         error: function(xhr, status, error) {
//           // Handle error
//           console.log(error);
//       }
//     });
//   });
// });

