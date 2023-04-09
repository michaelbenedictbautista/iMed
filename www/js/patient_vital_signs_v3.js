$(document).ready(function() {
  flatpickr("#time_of_obs", {
    enableTime: true,
    dateFormat: "d/m/Y h:iK",
    defaultDate: "today",
    maxDate: "today",
    allowInput: false,
  });
});

 
// Vital signs view modal function
$(document).ready(function() {
  $('.viewVitalSignsBtn').click(function() { 
    vs_id = $(this).attr('id')
      //alert(vs_id)
      $.ajax({
          url: "ajax.php",
          method: 'post',
          data: {
            vs_ID: vs_id
          },
          dataType: 'json',
          
          success: function(result) {     
              $(".time_of_obs").val(result.vitalSignsDetail.time_of_obs);
              $(".systolic").val(result.vitalSignsDetail.systolic);
              $(".diastolic").val(result.vitalSignsDetail.diastolic);             
              $(".temperature").val(result.vitalSignsDetail.temperature);
              $(".pulse_rate").val(result.vitalSignsDetail.pulse_rate);
              $(".respiratory_rate").val(result.vitalSignsDetail.respiratory_rate);
              $(".oxygen_saturation").val(result.vitalSignsDetail.oxygen_saturation);
              $(".vs_text").val(result.vitalSignsDetail.vs_text);
              $(".source").val(result.vitalSignsDetail.first_name + " " +result.vitalSignsDetail.last_name + " | " + result.vitalSignsDetail.profession);                                       
          },
          error: function(xhr, status, error) {
              // Handle error
              console.log(error);
          }
      });

       $('#viewVitalSignsModal').modal("show");
  });
});
