// change user profile picture function
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
      var preview = document.getElementById('userProfilePic');
      preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }