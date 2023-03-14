$(document).ready(function() {
    $('.Mybutton').click(function() {
        note_id = $(this).attr('id')
        // alert(note_id)
        $.ajax({
            url: "test.php",
            method: 'post',
            data: {
                note_ID: note_id
            },
            dataType: 'json',
            
            success: function(result) {
                $("#viewingTitle").text(result.detailInfo.detailText);
                $("#viewingNote").text(result.detailInfo.detailID);             
            }
            // error: function(xhr, status, error) {
            //     // Handle error
            //     console.log(error);
            // }
        });

         $('#viewNoteModal').modal("show");
    })
})
