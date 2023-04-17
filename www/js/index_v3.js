// function for passing data without refreshing the page
$(document).ready(function() {
    $('.noteDetailBtn').click(function() {
        note_id = $(this).attr('id')
        // alert(note_id)
        $.ajax({
            url: "ajax.php",
            method: 'post',
            data: {
                note_ID: note_id
            },
            dataType: 'json',
            
            success: function(result) {     
                $("#viewingNote").text(result.noteDetail.note_text);
                $("#viewingSource").text("Entered By: " + result.noteDetail.first_name + " " + result.noteDetail.last_name + " | " + result.noteDetail.profession);
                $("#viewingDate").text("Updated Date: " + result.noteDetail.updated_date);
                
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });

         $('#viewNoteModal').modal("show");
    });
});



