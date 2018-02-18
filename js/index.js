$(document).ready(function() {
	
	//Navbar
	$('#navLogout').on('click', function() {
		$.post('./php/logout/logout.php', function(data) {
			if (data == "reload") {
				location.reload();
			}
		});
	});


	//Post uploading related stuff
	$('#uploadBtn').on('click', function() {
		$("#fileUpload").trigger('click');
	})

	$('#fileUpload').change(function() {
		var fileName = $('#fileUpload').val().replace(/C:\\fakepath\\/i, '');
		if (fileName) {
			$('#uploadFileText').html(fileName);
			$('#uploadBtn').css({'width': '17.5vw', 'text-overflow': 'ellipsis'});
			$('#sendUploadBtn').css({'display': 'block'});			
		} else {
			$('#uploadFileText').html('No file selected... <i class="fa fa-upload" aria-hidden="true">');
			$('#uploadBtn').css({'width': '25vw'});
			$('#sendUploadBtn').css({'display': 'none'});	
		}
	
	});

	$('#sendUploadBtn').on('click', function() {
	    var file_data = $('#fileUpload').prop('files')[0];   
	    var form_data = new FormData();                  
	    form_data.append('file', file_data);                             
	    $.ajax({
		    url: './php/upload/postUpload.php',
		    dataType: 'text',
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: form_data,                         
		    type: 'post',
		    success: function(res) {
				if (res == "Your post has been uploaded!") {
					location.reload();
					/*$('#uploadBtn').css({'width': '25vw'});
					$('#sendUploadBtn').css({'display': 'none'});
					$('#uploadFileText').html('Upload <i class="fa fa-upload" aria-hidden="true">');
					$.post('./php/upload/loadUpload.php', function(data) {
						$('#uploadsDisplay').html(data);
					});*/						
				} else {
					alert(res);
				}
		    }
	    });
	});

	//Geo related
	$('.upload .fa-globe').on('click', function() {
		var id = this.id;
		$.post('./geo/geoModal.php', {id: id}, function(data) { 
			$('#geoModals').html(data);
			$('#geoModal').css({'display': 'block'});
		});
	});

	//Comment related
	$('.upload .fa-commenting-o').on('click', function() {
		var name = this.attributes['name'].value;
		$.post('./php/upload/postComment.php', {name: name}, function(data) {
			$('#commentModals').html(data);
			$('#commentModal').css({'display': 'block'});
		});
	});



});








