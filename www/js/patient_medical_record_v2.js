$(document).ready(function() {
  flatpickr("#mr_time", {
    enableTime: true,
    dateFormat: "d/m/Y h:iK",
    defaultDate: "today",
    maxDate: "today",
    allowInput: false,
  });
});


// Cropper v1
let fileInput = document.getElementById('fileInput');
let myImage = document.getElementById('myImage');
const cropBtn = document.getElementById('cropBtn');
const croppedImage = document.getElementById('croppedImage');
let leftRotateBtn = document.getElementById('leftRotateBtn');
let rightRotateBtn = document.getElementById('rightRotateBtn');
//const addOCRBtn = document.querySelector('.addOCRBtn');

const addMedicalRecordManualBtn = document.getElementById('addMedicalRecordManualBtn');



cropBtn.disabled = true;
leftRotateBtn.disabled = true;
rightRotateBtn.disabled= true;
// addOCRBtn.disabled = false;

let croppedCanvas;
let dataUrl;

// disable the submit button by default
const convertBtn = document.getElementById('convertBtn');
convertBtn.disabled = true;

fileInput.addEventListener('change', function() {
  const file = this.files[0];
  const reader = new FileReader();
  reader.onload = function() {
    // myImage.src = ""; // remove the previous image
    myImage.src = reader.result; // laod selected image
    cropBtn.disabled = false;
    leftRotateBtn.disabled = false;
    rightRotateBtn.disabled= false;
    // addOCRBtn.disabled = true;
    myImage.onload = function() {
      const cropper = new Cropper(myImage, {
        aspectRatio: 0,
        viewMode: 1,
        crop(event) {        
          cropBtn.addEventListener('click', () => {
            // get cropped canvas
            croppedCanvas = cropper.getCroppedCanvas();
            // display the result
            croppedImage.style.display = 'block';
            croppedImage.src = croppedCanvas.toDataURL();

            // update dataUrl variable
            dataUrl = croppedImage.src;

            // Enable the submit button and disable crop button after cropping an image.
            convertBtn.disabled = false;    
            cropBtn.disabled = true;
            leftRotateBtn.disabled = true;
            rightRotateBtn.disabled= true;


          });

          // Rotate image to right
          rightRotateBtn.addEventListener('click', () => {         
            cropper.rotate(0.1)
            
          });

          // Rotate image to left
          leftRotateBtn.addEventListener('click', () => {      
            cropper.rotate(-0.1)        
          }); 

          // const resetBtn = document.getElementById('resetBtn');
          // resetBtn.addEventListener('click', function() {
          //   // Reset input value and image source
          //   //cropper.reset();
          //   cropper.clear();
          //   // cropper.destroy();
            
          // });

          // const destroyBtn = document.getElementById('destroyBtn');
          // destroyBtn.addEventListener('click', function() {
          //   // Reset input value and image source
          //   //cropper.reset();     
          //   cropper.destroy();
            
          // });
  
        },
      });
    };
    
  }
  reader.readAsDataURL(file);
});


let convertedImageToText = document.getElementById('convertedImageToText')
let newConvertedText;
convertBtn.addEventListener('click', () => {
  $.ajax({
    url: 'ajax_medical_records.php',
    type: 'POST',
    data: { dataUrl: dataUrl },
    dataType: 'json',
    success: function(result) {
      
      //newConvertedText = $("#convertedImageToText").text(result.fileRead);
      // newConvertedText = $("#convertedImageToText").text(result.fileReadArray.value);
      $('#mr_result2').val(result.fileRead);
      //alert(result.fileRead)
      //alert(result.fileReadArray.value)

    },
    error: function(xhr, status, error) {
      console.error('Error uploading file.');
      console.error(error);
    }
  });
  // Enable the crop button and disable submit button after cropping an image.
  convertBtn.disabled = true;
  cropBtn.disabled = false;
  leftRotateBtn.disabled = false;
  rightRotateBtn.disabled= false;
  //addOCRBtn.disabled = false;
});





const user_id = document.getElementById("user_id");


$(document).ready(function() {
    $('#addMedicalRecordManualModalBtn').click(function() { 
      // alert(JSON.stringify(newConvertedText));
      //  alert(newConvertedText);
      // console.log(newConvertedText);
      // $('#mr_result').val(JSON.stringify(newConvertedText[0]));
      // $("#mr_result").text(newConvertedText);
      //var myValue = convertedImageToText.textContent
      $('#mr_result').val(myValue);
      
      
      // patient_id = $(this).attr('patient_ID')
      //  var user_id = $('#user_id').val();
      //   convertedImageToText = $('#convertedImageToText').val();
      //   // alert(userId)
      //   $.ajax({
      //       url: "ajax_medical_records.php",
      //       method: 'get',
      //       data: {
      //           patient_ID: patient_id,
                
      //       },
      //       dataType: 'json',
            
      //       success: function(result) {     
      //           // $(".time").val(result.vitalSignsDetail.time_of_obs);
                
      //           // $(".mr_text").val(result.vitalSignsDetail.vs_text);
                                                       
      //       },
      //       error: function(xhr, status, error) {
      //           // Handle error
      //           console.log(error);
      //       }
      //   });
      //   addOCRBtn.disabled = true;
       $('#addMedicalRecordManualModal').modal("show");
       
    });
});


/////////////////////////////////////
// const addMedicalRecordManualModalBtn =  document.getElementById('addMedicalRecordManualModalBtn')
// addMedicalRecordManualModalBtn.addEventListener('click', function() {
//   console.log('buttons was clicked')
// });

////////////////////////////////////////////////////////////////////////
//const addMedicalRecordAutoBtn = document.getElementById('addMedicalRecordAutoBtn');

// $(document).ready(function() {
//     $('.addMedicalRecordManualBtn').click(function() { 
//       patient_id = $(this).attr('patient_ID')
//        var user_id = $('#user_id').val();
//        convertedImageToText = $('#convertedImageToText').val();
//         // alert(userId)
//         $.ajax({
//             url: "ajax_medical_records.php",
//             method: 'get',
//             data: {
//                 patient_ID: patient_id,
//                 user_ID: user_id
//             },
//             dataType: 'json',
            
//             success: function(result) {     
//                 // $(".time").val(result.vitalSignsDetail.time_of_obs);
                
//                 // $(".mr_text").val(result.vitalSignsDetail.vs_text);
                                                       
//             },
//             error: function(xhr, status, error) {
//                 // Handle error
//                 console.log(error);
//             }
//         });
//         addOCRBtn.disabled = true;
//         $('#addMedicalRecordAutoModal').modal("show");
//     });
// });