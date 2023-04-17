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



// searchBtn.addEventListener('click', function(event) {
//   // Prevent the default form submission behavior
//   event.preventDefault();

//   // Disable the submit button
//   submitBtn.disabled = true;

//   // Do some processing, e.g. sending an AJAX request

//   // Re-enable the submit button
//   submitBtn.disabled = false;
// });




// When the user submits the form in the modal
// $('#modal-form').on('submit', function(event) {
//   event.preventDefault(); // prevent the form from submitting normally

//   // Get the data from the form
//   var patientId = $('#patient-id').val();
//   var additionalInfo = $('#additional-info').val();

//   // Send an AJAX request to the PHP endpoint
//   $.ajax({
//       url: 'save-additional-info.php',
//       type: 'POST',
//       data: {
//           patient_id: patientId,
//           additional_info: additionalInfo
//       },
//       success: function(response) {
//           // Update the patient's profile page with the new information
//           $('#patient-info').text(response);
//           // Hide the modal
//           $('#modal').modal('hide');
//       },
//       error: function(xhr, status, error) {
//           // Handle the error
//           alert('An error occurred: ' + error);
//       }
//   });
// });



// $(document).ready(function() {
//   // Handle form submission
//   $("#addProfileForm").submit(function(e) {
//     e.preventDefault(); // Prevent default form submission

//     // Get form data
//     var formData = $(this).serialize();

//     // Send AJAX request
//     $.ajax({
//       url: "add-medical-profile.php",
//       type: "POST",
//       data: formData,
//       success: function(response) {
//         // Handle successful response
//         console.log(response);
//         $("#addProfileModal").modal("hide"); // Hide the modal
//       },
//       error: function(xhr, status, error) {
//         // Handle error response
//         console.log(xhr.responseText);
//       }
//     });
//   });
// });


// if (document.getElementById('successfulMessage').style.display == 'flex') {
//   setTimeout(function() {
//     document.getElementById('successfulMessage').style.display = 'none';
// }, 2000);
// }

  
// const successfulMessage = document.getElementById('successfulMessage');
// setTimeout(function() {
//   successfulMessage.style.display = 'none';
// }, 2000);


// document.addEventListener('DOMContentLoaded', function() {
//   const successfulMessage = document.getElementById('successfulMessage');
//   setTimeout(function() {
//       successfulMessage.style.display = 'none';
//   }, 2000);
// });


// // function for passing data without refreshing the page
// $(document).ready(function() {
//   $('.viewMedProviderBtn').click(function() {
//       patient_id = $(this).attr('id')
//       alert(patient_id)
//   })
// });




///////////////////////////////////////////////////////
//Test cropper.js working
// const image = document.getElementById('myImage');
// const cropper = new Cropper(image, {
//   aspectRatio: 16 / 9,
//   crop(event) {
//     console.log(event.detail.x);
//     console.log(event.detail.y);
//     console.log(event.detail.width);
//     console.log(event.detail.height);
//     console.log(event.detail.rotate);
//     console.log(event.detail.scaleX);
//     console.log(event.detail.scaleY);
//   },
// });



//Upload and display image statically
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
  xhr.open('POST', 'ajax_medical_records.php', true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      console.log('Image uploaded successfully.');
    } else {
      console.log('Image upload failed.');
    }
  };
  xhr.send(new FormData(imageUploadForm));
});


var cropper = new Cropper(previewImage, {
  aspectRatio: 16 / 9,
  crop(event) {
    console.log(event.detail.x);
    console.log(event.detail.y);
    console.log(event.detail.width);
    console.log(event.detail.height);
    console.log(event.detail.rotate);
    console.log(event.detail.scaleX);
    console.log(event.detail.scaleY);
  },
});




  






