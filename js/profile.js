$(document).ready(function() {

  $('#profileImage').on('click', function() {
    $('#changeProfilePicture').trigger('click');
  });

  $('#changeProfilePicture').change(function() {
    var fileName = $('#changeProfilePicture').val().replace(/C:\\fakepath\\/i, '');
    if (fileName) {
      var file_data = $('#changeProfilePicture').prop('files')[0];
      var form_data = new FormData();
      form_data.append('file', file_data);
      $.ajax({
        url: './php/upload/changeProfileImage.php',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(res) {
        if (res == 'Your profile image has been changed!') {
          location.reload();
        } else {
          alert(res);
        }
        }
      });
    } else {
      alert('No image selected...');
    }
  });

});
