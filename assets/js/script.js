var current_uploading_file = 0;
var removed_files = 0;
var uploading_files = [];
var timeStructure = new TimeStructure();
var sizeStructure = new SizeStructure();
var totalSize = 0;
var uploadingSize = 0;

var xhr, hUploadSpeed;
var uploaded = 0, prevUpload = 0, speed = 0, total = 0, preloaded = 0, remainingBytes = 0, timeRemaining = 0;

$(document).ready(function () {

  if (typeof FileReader === "undefined") {
    $('#fileElem').attr('multiple', false);
  }
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

  handleFiles = function (files, e) {
//    var excludeType = /(exe|bat|html|php|js).*/;
    uploaded = 0, prevUpload = 0, speed = 0, total = 0, preloaded = 0, remainingBytes = 0, timeRemaining = 0;
    for (var i = 0; i < files.length; i++) {
      var file_item = files[i];

      // check file type
//      if (file_item.type.match(excludeType)) {
//        alert(_t("File \"") + file_item.name + _t("\" is not a valid file"));
//        continue;
//      }

      if (parseInt(file_item.size / 1024) > 10240) {
        alert(_t("File \"") + file_item.name + _t("\" is too big."));
        continue;
      }

      var file_uid = uid();
      file_item.uid = file_uid;
      uploading_files.push(file_item);
      total += file_item.size;
      totalSize += file_item.size;

      $('.uploaded_files').append(
              '<div class="file-item file_' + file_uid + '">' +
              ' <ul class="uploaded_file_item">' +
              '   <li class="number"><span>' + (file_uid + 1 - removed_files) + '</span></li>' +
              '   <li class="file_name">' + file_item.name + '</li>' +
              '   <li class="file_size">' + sizeStructure.BytesToStructuredString(file_item.size) + '</li>' +
              '   <li class="upload_progress"><span class="progress">0%</span></li>' +
//              '   <li class="upload_status"></li>' +
              '   <li class="file_action"></li>' +
              ' </ul>' +
              '</div>'
              ).show();
    }

//    var info = '<ul class="preview active-win">\n\
//                  <li class="total_files">' + _t('Deposited Files') + ' : <span class="current_item">' + (current_uploading_file + 1 - removed_files) + '</span>/<span class="total_item">' + (uploading_files.length - removed_files) + '</span></li>\n\
//                  <li class="progress-holder">\n\
//                    <span id="progress"></span>\n\
//                  </li>\n\
//                  <li class="percents"></li>\n\
//                  <li class="total_size">' + sizeStructure.BytesToStructuredString(totalSize) + '</li>\n\
//                </ul>\n\
//                <p id="speed_any"></p>';
    var info = '<p id="speed_any"></p>';

    $(".upload-progress").show('normal', function () {
      $(".upload-progress").html(info);
      hUploadSpeed = setInterval(UploadSpeed, 1000); //per seconds
      uploadFile(uploading_files[current_uploading_file]);
    });
  };

  uploadFile = function (file) {
    // check if browser supports file reader object
    if (typeof FileReader !== "undefined") {
      reader = new FileReader();
      reader.onload = function (e) {
        ;
      };
      reader.readAsDataURL(file);
    } else {
      $('#fileElem').attr('multiple', false);
    }

//    $('.file_' + current_uploading_file + ' .upload_status').css('background', 'url("' + site_url + '/assets/img/loading2.gif") no-repeat center center');
    xhr = new XMLHttpRequest();
    xhr.open("post", "lib/ajax_fileupload.php?filename=" + file.name, true);

    xhr.upload.addEventListener("progress", function (event) {
      if (event.lengthComputable) {
        uploaded = preloaded + event.loaded;
        $("#progress").css("width", ((uploadingSize + event.loaded) / totalSize) * 100 + "%");
        $(".percents").html(" " + (((uploadingSize + event.loaded) / totalSize) * 100).toFixed() + "%");
        $(".up-done").html((parseInt((uploadingSize + event.loaded) / 1024)).toFixed(0));

        $('.file_' + current_uploading_file + ' .upload_progress .progress').css("width", ((event.loaded / event.total) * 100).toFixed() + "%");
        $('.file_' + current_uploading_file + ' .upload_progress .progress').html(((event.loaded / event.total) * 100).toFixed() + "%");
      }
      else {
        alert(_t("Failed to compute file upload length"));
      }
    }, false);
    xhr.addEventListener('load', uploadThrough, false);//EventListener for completed upload

    xhr.onreadystatechange = function (oEvent) {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          db_id = xhr.responseText;

          $('.file_' + current_uploading_file + ' .file_action').html('<a href="javascript:void(0);" class="delete" onClick="remove_item(\'' + db_id + '\')">' + _t('Delete') + '</a>');
          $('.file_' + current_uploading_file).attr('id', 'file_' + db_id);
//          $('.file_' + current_uploading_file + ' .upload_status').css('background', 'url("' + site_url + '/assets/img/icon_checked.jpg") no-repeat center center');
          $('.file_' + current_uploading_file).append('<input type="hidden" name="uploaded_files[]" value="' + db_id + '" /><input type="hidden" name=uploaded_file_size[' + db_id + ']" value="' + sizeStructure.BytesToStructuredString(file.size) + '" />');
          uploadingSize += file.size;
          preloaded += file.size;
          current_uploading_file++;
          if (current_uploading_file < uploading_files.length) {
            $('.upload-progress .current_item').html(current_uploading_file - removed_files);
            uploadFile(uploading_files[current_uploading_file]);
          }
          $('#dropbox').trigger('progress_end');
          $('.frm_contact').data('bootstrapValidator')
                  .updateStatus('dropbox', 'NOT_VALIDATED')
                  .validateField('dropbox');
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
  };
});

function remove_item(db_id) {
  $.ajax({
    type: "POST",
    url: "lib/ajax_fileupload.php",
    data: {method: 'delete', id: db_id},
    success: function () {
      $('#file_' + db_id).hide('slow', function () {
        var matches = $('#file_' + db_id).prop('className').match(/\bfile_(\d+)\b/i);
        var theNumber = matches[1];
        $('#file_' + db_id).remove();
        $('.upload-progress .current_item').html($('.upload-progress .current_item').html() * 1 - 1);
        $('.upload-progress .total_item').html($('.upload-progress .total_item').html() * 1 - 1);

        totalSize = totalSize - uploading_files[theNumber].size;
        uploadingSize = uploadingSize - uploading_files[theNumber].size;
        removed_files++;

        $('.upload-progress .total_size').html(sizeStructure.BytesToStructuredString(totalSize));

        $('.uploaded_files .file-item').each(function (index) {
          $(this).find('.uploaded_file_item .number').eq(0).html('<span>' + (index * 1 + 1) + '</span>');
        });
        if ($('.uploaded_files .file-item').length == 0) {
          $('.uploaded_files').hide();
        }
      });
    }
  });
}

function uploadThrough() {
  if (current_uploading_file >= uploading_files.length) {
    $('.upload-progress .current_item').html(current_uploading_file - removed_files);
    UploadSpeed();//flush
    clearInterval(hUploadSpeed);
    xhr = null;
    $('#speed_any').html(_t('Upload Completed!'));
  }
}

function UploadSpeed() {
  //speed
  speed = uploaded - prevUpload;
  if (speed === 0) {
    return false;
  }
  prevUpload = uploaded;
  //Calculating ETR
  remainingBytes = total - uploaded;
  timeRemaining = remainingBytes / speed;
  $('#speed_any').html(_t('Time Left : ') + timeStructure.SecondsToStructuredString(timeRemaining) + ' (' + sizeStructure.SpeedToStructuredString(speed) + ')');
}

var uid = (function () {
  var id = 0;
  return function () {
    if (arguments[0] === 0)
      id = 0;
    return id++;
  };
})();