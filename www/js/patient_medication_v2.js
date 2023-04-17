$(document).ready(function() {
  flatpickr("#time_of_prescription", {
    enableTime: false,
    dateFormat: "d/m/Y h:iK",
    defaultDate: "today",
    allowInput: false,
  });
});

$(document).ready(function() {
    flatpickr("#start_date", {
      enableTime: true,
      dateFormat: "d/m/Y h:iK",
      defaultDate: "today",
      minDate: "today",
      allowInput: false,
    });
});

$(document).ready(function() {
    flatpickr("#end_date", {
      enableTime: true,
      dateFormat: "d/m/Y h:iK",
      defaultDate: "today",
      minDate: "today",
      allowInput: false,
    });
});

// Medication view modal function
$(document).ready(function() {
  $('.viewMedicationBtn').click(function() { 
    med_id = $(this).attr('id')
      //alert(med_ID)
      $.ajax({
          url: "ajax.php",
          method: 'post',
          data: {
            med_ID: med_id
          },
          dataType: 'json',
          
          success: function(result) {     
              $(".view_time_of_prescription").val(result.medicationDetail.time_of_prescription);
              $(".name_of_drug").val(result.medicationDetail.name_of_drug);
              $(".dose").val(result.medicationDetail.dose);             
              $(".route").val(result.medicationDetail.route);
              $(".frequency").val(result.medicationDetail.frequency);
              $(".view_start_date").val(result.medicationDetail.start_date);
              $(".view_end_date").val(result.medicationDetail.end_date);
              $(".name_of_doctor").val(result.medicationDetail.name_of_doctor);
              $(".status").val(result.medicationDetail.status);
              $(".med_text").val(result.medicationDetail.med_text);
              $(".viewMedicationsource").val(result.medicationDetail.first_name + " " +result.medicationDetail.last_name + " | " + result.medicationDetail.profession);
              $("#viewingMedicationDate").text("Updated Date: " + result.medicationDetail.updated_date);                                     
          },
          error: function(xhr, status, error) {
              // Handle error
              console.log(error);
          }
      });

       $('#viewMedicationModal').modal("show");
  });
});
