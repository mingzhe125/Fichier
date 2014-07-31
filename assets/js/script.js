$(document).ready(function() {
  var dropbox;

  dropbox = document.getElementById("dropbox");
  dropbox.addEventListener("dragenter", dragenter, false);
  dropbox.addEventListener("dragleave", dragleave, false);
  dropbox.addEventListener("dragover", dragover, false);
  dropbox.addEventListener("drop", drop, false);

  function defaults(e) {
    e.stopPropagation();
    e.preventDefault();
  }
  function dragenter(e) {
    $(this).addClass("active");
    defaults(e);
  }

  function dragover(e) {
    defaults(e);
  }
  function dragleave(e) {
    $(this).removeClass("active");
    defaults(e);
  }

  function drop(e) {
    $(this).removeClass("active");
    defaults(e);

    var dt = e.dataTransfer;
    var files = dt.files;

    handleFiles(files, e);
  }

  handleFiles = function(files, e) {
    // Traverse throught all files and check if uploaded file type is image	
    var imageType = /(image|pdf).*/;
    var file = files[0];

    // check file type
    if (!file.type.match(imageType)) {
      alert("File \"" + file.name + "\" is not a valid image file, Are you trying to screw me :( :( ");
      return false;
    }
    // check file size
    if (parseInt(file.size / 1024) > 10240) {
      alert("File \"" + file.name + "\" is too big. I am using shared server :P");
      return false;
    }

    var info = '<div class="preview active-win"><div class="progress-holder"><span id="progress"></span></div><span class="percents"></span>';

    $(".upload-progress").show("slow", function() {
      $(".upload-progress").html(info);
      uploadFile(file);
    });

  };

  uploadFile = function(file) {
    // check if browser supports file reader object 
    if (typeof FileReader !== "undefined") {
      //alert("uploading "+file.name);  
      reader = new FileReader();
      reader.onload = function(e) {
      };
      reader.readAsDataURL(file);

      xhr = new XMLHttpRequest();
      xhr.open("post", "lib/ajax_fileupload.php?filename=" + file.name, true);

      xhr.upload.addEventListener("progress", function(event) {
        if (event.lengthComputable) {
          $("#progress").css("width", (event.loaded / event.total) * 100 + "%");
          $(".percents").html(" " + ((event.loaded / event.total) * 100).toFixed() + "%");
          $(".up-done").html((parseInt(event.loaded / 1024)).toFixed(0));
        }
        else {
          alert("Failed to compute file upload length");
        }
      }, false);

      xhr.onreadystatechange = function(oEvent) {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            db_id = xhr.responseText;
            $("#progress").css("width", "100%");
            $(".percents").html("100%");
            $(".up-done").html((parseInt(file.size / 1024)).toFixed(0));
            $('.upload-progress').fadeOut('slow', function() {
              $("#progress").css('width', ' 0%');
              $(".percents").html("0%");
              var uploaded_file = $('#fileElem').val().split('\\');
              $('.uploaded_files').append('<div class="file-item" id="file_' + db_id + '">' + uploaded_file[uploaded_file.length - 1] + '<a href="javascript:void(0);" class="delete" onClick="remove_item(\'' + db_id + '\')"><sup>x</sup></a><input type="hidden" name="uploaded_files[]" value="' + db_id + '" /></div>');
              $('.upload-progress').html('');
              $('#dropbox').trigger('progress_end');
              $('.frm_contact').data('bootstrapValidator')
                      .updateStatus('dropbox', 'NOT_VALIDATED')
                      .validateField('dropbox');
            });
          } else {
            alert("Error" + xhr.statusText);
          }
        }
      };

      // Set headers
      xhr.setRequestHeader("Content-Type", "multipart/form-data");
      xhr.setRequestHeader("X-File-Name", file.fileName);
      xhr.setRequestHeader("X-File-Size", file.fileSize);
      xhr.setRequestHeader("X-File-Type", file.type);

      // Send the file (doh)
      xhr.send(file);

    } else {
      alert("Your browser doesnt support FileReader object");
    }
  };

  $('#dropbox').tooltipster({
    animation: 'fall',
    content: 'Glissez déposez vos fichiers',
    multiple: true,
    position: 'right',
    theme: 'tooltipster-light'
  });

  $('#from_email').tooltipster({
    animation: 'grow',
    content: 'Ajouer votre   adresse email ici',
    multiple: true,
    position: 'right',
    theme: 'tooltipster-light'
  });

  $('#to_email').tooltipster({
    animation: 'grow',
    content: 'Ajouer les adresses email des destinataires',
    multiple: true,
    position: 'left',
    theme: 'tooltipster-shadow'
  });
  $('#inputMessage').tooltipster({
    animation: 'grow',
    content: 'Joignez un message à votre transfert',
    multiple: true,
    position: 'left',
    theme: 'tooltipster-shadow'
  });
  $('.confirm_btn').tooltipster({
    animation: 'grow',
    content: 'Cliquez sur ce bouton pour démarrer le transfert',
    multiple: true,
    position: 'right',
    theme: 'tooltipster-noir'
  });
});

function remove_item(db_id) {
  $.ajax({
    type: "POST",
    url: "lib/ajax_fileupload.php",
    data: {method: 'delete', id: db_id},
    success: function() {
      $('#file_' + db_id).hide('slow');
    }
  });
}