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

// const isValid = () => {
//     if ((firstName != null || firstName.value.trim().length > 0) && (lastName != null || lastName.value.trim().length > 0) && (userName != null || userName.value.trim().length > 0) && (email1 != null || email1.value.trim().length > 0) && (password1 != null || password1.value.trim().length >= 8) && (contactNumber != null || contactNumber.value.trim().length > 0) && (profession != null || profession.value.trim().length > 0) && (userLevel != null || userLevel.value.trim().length > 0) && (institutionName != null || institutionName.value.trim().length > 0) && (institutionAddress != null || institutionAddress.value.trim().length > 0)) {
//         return true;
//     } else {
//         return false;
//     }
// }


// $(document).ready(function (e) {
//     $("#image-upload-form").on('submit',(function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: "upload.php",
//             type: "POST",
//             data:  new FormData(this),
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function(data)
//             {
//                 $("#targetLayer").html(data);
//             },
//               error: function(data)
//             {
//                 console.log("error");
//               console.log(data);
//             }
//        });
//     }));
// });

var imageInput = document.getElementById('imageInput');
  var previewImage = document.getElementById('previewImage');
  imageInput.addEventListener('change', function() {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function(event) {
      previewImage.src = event.target.result;
    }
    reader.readAsDataURL(file);
});


  var imageUploadForm = document.getElementById('imageUploadForm');
  imageUploadForm.addEventListener('submit', function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        console.log('Image uploaded successfully.');
      } else {
        console.log('Image upload failed.');
      }
    };
    xhr.send(new FormData(imageUploadForm));
  });






