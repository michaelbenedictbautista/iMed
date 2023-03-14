// $(document).ready(function() {
//     // Handle button click event
//     $('.view-note').click(function() {
//       var noteId = $(this).data('note-id');
  
//       // Make AJAX request to retrieve patient data
//       $.ajax({
//         url: 'note_detail.php',
//         method: 'GET',
//         data: { note_id: noteId },
//         // success: function(data) {
//         //   // Update modal body with patient data
//         //   $('#viewNoteModal .modal-body').html(data);
  
//         //   // Show modal
//         //   $('#viewNoteModal').modal('show');
//         // },
//         error: function(xhr, status, error) {
//           // Handle error
//           console.log(error);
//         }
//       });
//     });
//   });