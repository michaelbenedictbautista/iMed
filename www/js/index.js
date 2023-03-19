// function for passing data without refreshing the page
$(document).ready(function() {
    $('.noteDetailBtn').click(function() {
        note_id = $(this).attr('id')
        // alert(note_id)
        $.ajax({
            url: "view_note_detail.php",
            method: 'post',
            data: {
                note_ID: note_id
            },
            dataType: 'json',
            
            success: function(result) {     
                $("#viewingTitle").text("Source: " + result.noteDetail.first_name + " " + result.noteDetail.last_name + " | " + result.noteDetail.profession);
                $("#viewingNote").text(result.noteDetail.note_text);
                $("#viewingDate").text(result.noteDetail.updated_date);
                
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });

         $('#viewNoteModal').modal("show");
    })
})


