$(document).ready(function() {
  flatpickr("#mr_time", {
    enableTime: true,
    dateFormat: "d/m/Y h:iK",
    defaultDate: "today",
    maxDate: "today",
    allowInput: false,
  });
});

// Medication view modal function
$(document).ready(function() {
  $('.viewMedicalBtn').click(function() { 
    mr_id = $(this).attr('id')
      //alert(mr_id);
      $.ajax({
          url: "ajax.php",
          method: 'post',
          data: {
            mr_ID: mr_id
          },
          dataType: 'json',
          
          success: function(result) {     
               $(".mr_time").val(result.medicalRecordDetail.mr_time);
               $(".mr_title").val(result.medicalRecordDetail.mr_title);

              const result_wrapper = document.querySelector(".result_wrapper")
              if (result.medicalRecordDetail.mr_result !== undefined || result.medicalRecordDetail.mr_result !== null || result.medicalRecordDetail.mr_result =="") {         
              
              //var mrResultString = JSON.stringify(result.medicalRecordDetail.mr_result);
              result_wrapper.style.display='block';  
              $(".mr_result").val(result.medicalRecordDetail.mr_result); 
              } else { 
                result_wrapper.style.display='none';        
              }
              
              // const my_mr_file = document.querySelector(".my_mr_file")
              // if (result.medicalRecordDetail.mr_file !== undefined || result.medicalRecordDetail.mr_file !== null) {         
              // //$(".my_mr_file").val("View image attached: N/A");
              // my_mr_file.style.display='block';
              // $("#medical-record-link").attr("href", "img/uploads_medical_record/" + result.medicalRecordDetail.mr_file);
              // } else {          
              //   my_mr_file.style.display='none';
              //   // $(".my_mr_file").val("View image attached: N/A");
              // } 
  
              $(".mr_text").val(result.medicalRecordDetail.mr_text);
              $(".viewMedicalsource").val(result.medicalRecordDetail.first_name + " " +result.medicalRecordDetail.last_name + " | " + result.medicalRecordDetail.profession);

              $("#viewingDate").text("Updated Date: " + result.medicalRecordDetail.updated_date);
                                                  
          },
          error: function(xhr, status, error) {
              // Handle error
              console.log(error);
          }
      });

       $('#viewMedicalRecordModal').modal("show");
  });
});


// Image cropper
let mr_file = document.getElementById('mr_file');
let myImage = document.getElementById('myImage');
const cropBtn = document.getElementById('cropBtn');
const croppedImage = document.getElementById('croppedImage');
let leftRotateBtn = document.getElementById('leftRotateBtn');
let rightRotateBtn = document.getElementById('rightRotateBtn');
//const addOCRBtn = document.querySelector('.addOCRBtn');

const addMedicalRecordManualBtn = document.getElementById('addMedicalRecordManualBtn');
const croppedImageResultText = document.getElementById('croppedImageResultText');
const resultWrapper = document.getElementById('resultWrapper');


cropBtn.disabled = true;
leftRotateBtn.disabled = true;
rightRotateBtn.disabled= true;
// addOCRBtn.disabled = false;

let croppedCanvas;
let dataUrl;

// disable the submit button by default
const convertBtn = document.getElementById('convertBtn');
convertBtn.disabled = true;

mr_file.addEventListener('change', function() {
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
      
      // Initialise cropper
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
            convertBtn.style.display = "block";
            croppedImageResultText.style.display = "block";  
            cropBtn.disabled = false;
            leftRotateBtn.disabled = false;
            rightRotateBtn.disabled= false;
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
      $('#mr_result').val(result.fileRead);
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
  resultWrapper.style.display = "block";
  leftRotateBtn.disabled = false;
  rightRotateBtn.disabled= false;
  //addOCRBtn.disabled = false;
});

