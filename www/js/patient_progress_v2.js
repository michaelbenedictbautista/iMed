// Progress note modal function
$(document).ready(function() {
    $('.viewProgNoteBtn').click(function() { 
      prog_id = $(this).attr('id')
      //alert(prog_id)
      $.ajax({
          url: "ajax.php",
          method: 'post',
          data: {
            prog_ID: prog_id
          },
          dataType: 'json',
          
          success: function(result) {     
              $("#viewingProgText").text(result.progressNoteDetail.prog_text);
              $("#viewingSourceUser").text("Entered By: " + result.progressNoteDetail.first_name + " " + result.progressNoteDetail.last_name + " | " + result.progressNoteDetail.profession);            
              $("#viewingDate").text("Updated Date: " + result.progressNoteDetail.updated_date);
              
          },
          error: function(xhr, status, error) {
              // Handle error
              console.log(error);
          }
      });
  
        $('#viewProgNoteModal').modal("show");
    });
  });


                