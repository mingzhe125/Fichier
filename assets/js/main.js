$(document).ready(function () {
  $.fn.bootstrapValidator.validators.fileuploadstatus = {
    validate: function (validator, $field, options) {
      if ($('.uploaded_files .file-item').length > 0) {
        return true;
      } else {
        return false;
      }
    },
    trigger: 'progress_end'
  };
  var counter = 1;
  setInterval(function () {
    counter++;
    $('.wrapper .main_back').removeClass('opaque');
    $('.wrapper .main_back.bg_' + counter).addClass('opaque');
    if (counter === 3) {
      counter = 0;
    }
  }, 10000);

  $('.frm_contact').bootstrapValidator({
    message: _t('This value is not valid'),
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      dropbox: {
        trigger: 'progress_end',
        message: _t('Please uplod the file'),
        validators: {
          fileuploadstatus: {
            message: _t('Please uplod the file')
          }
        }
      },
      username: {
        message: _t('The username is not valid'),
        validators: {
          notEmpty: {
            message: _t('The username is required and cannot be empty')
          },
          stringLength: {
            min: 4,
            max: 30,
            message: _t('The username must be more than 4 and less than 30 characters long')
          },
          regexp: {
            regexp: /^[a-zA-Z0-9_ ]+$/,
            message: _t('The username can only consist of alphabetical, number and underscore')
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: _t('The email is required and cannot be empty')
          },
          emailAddress: {
            message: _t('The input is not a valid email address')
          }
        }
      },
      to_email: {
        validators: {
          notEmpty: {
            message: _t('The email is required and cannot be empty')
          },
          emailAddress: {
            message: _t('The input is not a valid email address')
          }
        }
      },
      from_email: {
        validators: {
          notEmpty: {
            message: _t('The email is required and cannot be empty')
          },
          emailAddress: {
            message: _t('The input is not a valid email address')
          }
        }
      },
      message: {
        validators: {
          notEmpty: {
            message: _t('The message is required and cannot be empty')
          }
        }
      },
      captcha: {
        validators: {
          notEmpty: {
            message: _t('The captcha is required and cannot be empty')
          }
        }
      }
    }
  });

  resizeBody();

  $(window).resize(function () {
    resizeBody();
  });

  if ($('#dropbox').length > 0) {
    $('#dropbox').on('click', function () {
      if (navigator.userAgent.search("Firefox") > -1) {
        $('#fileElem', $('.frm_contact')).trigger('click');
      } else {
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("click", true, true);
        document.getElementById('fileElem').dispatchEvent(evt);
      }
      return false;
    });

    var tolltip_trigger = 'click_help';

    $('#dropbox').tooltipster({
      animation: 'grow',
      content: _t('Drag? Your files here'),
      multiple: true,
      position: 'right',
      theme: 'tooltipster-light',
      trigger: tolltip_trigger
    });

    $('#from_email').tooltipster({
      animation: 'grow',
      content: _t('Enter your email address here'),
      multiple: true,
      position: 'right',
      theme: 'tooltipster-light',
      trigger: tolltip_trigger
    });

    $('#to_email').tooltipster({
      animation: 'grow',
      content: _t('Email address of the recipient'),
      multiple: true,
      position: 'left',
      theme: 'tooltipster-shadow',
      trigger: tolltip_trigger
    });

    $('#inputMessage').tooltipster({
      animation: 'grow',
      content: _t('Join message your transfer'),
      multiple: true,
      position: 'left',
      theme: 'tooltipster-shadow',
      trigger: tolltip_trigger
    });

    $('.confirm_btn').tooltipster({
      animation: 'grow',
      content: _t('Click here to send? Your files'),
      multiple: true,
      position: 'right',
      theme: 'tooltipster-light',
      trigger: tolltip_trigger
    });
  }

  if ($('.fancy_image').length > 0) {
    $(".fancy_image").click(function () {
      fancy_width = $('.container').width() * 0.7;
      fancy_height = $(window).height() * 0.8;
      $.fancybox({
        'autoDimensions': false,
        'autosize': true,
        'content': '<img src="' + this.href + '" height="auto" width="' + fancy_width + 'px" />',
        'onClosed': function () {
          $("#fancybox-inner").empty();
        }
      });
      return false;
    });
  }

  if ($('.file_protect').length > 0) {
    $('.file_protect').click(function () {
      $('.password-wrapper').show('medium');
    });
  }

  if ($('.site_help').length > 0) {
    $('.site_help').click(function () {
      $('#dropbox').trigger(tolltip_trigger);
      $('#from_email').trigger(tolltip_trigger);
      $('#to_email').trigger(tolltip_trigger);
      $('#inputMessage').trigger(tolltip_trigger);
      $('.confirm_btn').trigger(tolltip_trigger);
    });
  }
});

function resizeBody() {
  var screen_height = $(window).height();

  var current_main_height = $('.main').height();
  var purpose_main_height = screen_height - $('.navbar').height() - 2;

  if (current_main_height < purpose_main_height) {
    $('.main').height(purpose_main_height);
  }
}