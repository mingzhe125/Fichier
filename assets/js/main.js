$(document).ready(function() {
  $.fn.bootstrapValidator.validators.fileuploadstatus = {
    validate: function(validator, $field, options) {
      if ($('.uploaded_files .file-item').length > 0) {
        return true;
      } else {
        return false;
      }
    },
    trigger: 'progress_end'
  };

  $('.frm_contact').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      dropbox: {
        trigger: 'progress_end',
        message: 'Please uplod the file',
        validators: {
          fileuploadstatus: {
            message: 'Please uplod the file'
          }
        }
      },
      username: {
        message: 'The username is not valid',
        validators: {
          notEmpty: {
            message: 'The username is required and cannot be empty'
          },
          stringLength: {
            min: 4,
            max: 30,
            message: 'The username must be more than 4 and less than 30 characters long'
          },
          regexp: {
            regexp: /^[a-zA-Z0-9_ ]+$/,
            message: 'The username can only consist of alphabetical, number and underscore'
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: 'The email is required and cannot be empty'
          },
          emailAddress: {
            message: 'The input is not a valid email address'
          }
        }
      },
      to_email: {
        validators: {
          notEmpty: {
            message: 'The email is required and cannot be empty'
          },
          emailAddress: {
            message: 'The input is not a valid email address'
          }
        }
      },
      from_email: {
        validators: {
          notEmpty: {
            message: 'The email is required and cannot be empty'
          },
          emailAddress: {
            message: 'The input is not a valid email address'
          }
        }
      },
      message: {
        validators: {
          notEmpty: {
            message: 'The message is required and cannot be empty'
          }
        }
      },
      captcha: {
        validators: {
          notEmpty: {
            message: 'The captcha is required and cannot be empty'
          },
          stringLength: {
            min: 4,
            max: 10,
            message: 'The captcha must be more than 4 and less than 10 characters long'
          }
        }
      }
    }
  });

  resizeBody();

  $(window).resize(function() {
    resizeBody();
  });

  if ($('#dropbox').length > 0) {
    $('#dropbox').on('click', function() {
      $('#fileElem').trigger('click');
      return false;
    });
  }

//	if ($(".fancy_pdf").length > 0) {
//		$(".fancy_pdf").click(function() {
//			fancy_width = $('.container').width() * 0.8;
//			fancy_height = $(window).height() * 0.8;
//			$.fancybox({
//				'autoDimensions': false,
//				'autosize': true,
//				'content': '<embed src="' + this.href + '#nameddest=self&page=1&view=FitH,0&zoom=80,0,0" type="application/pdf" height="' + fancy_height + 'px" width="' + fancy_width + 'px" />',
//				'onClosed': function() {
//					$("#fancybox-inner").empty();
//				}
//			});
//			return false;
//		});
//	}

  if ($('.fancy_image').length > 0) {
    $(".fancy_image").click(function() {
      fancy_width = $('.container').width() * 0.7;
      fancy_height = $(window).height() * 0.8;
      $.fancybox({
        'autoDimensions': false,
        'autosize': true,
        'content': '<img src="' + this.href + '" height="auto" width="' + fancy_width + 'px" />',
        'onClosed': function() {
          $("#fancybox-inner").empty();
        }
      });
      return false;
    });
  }

  if ($('.file_protect').length > 0) {
    $('.file_protect').click(function() {
      $('.password-wrapper').show('medium');
    });
  }

  var tolltip_trigger = 'click_help';

  if ($('.site_help').length > 0) {
    $('.site_help').click(function() {
      $('#dropbox').trigger(tolltip_trigger);
      $('#from_email').trigger(tolltip_trigger);
      $('#to_email').trigger(tolltip_trigger);
      $('#inputMessage').trigger(tolltip_trigger);
      $('.confirm_btn').trigger(tolltip_trigger);
    });
  }

  $('#dropbox').tooltipster({
    animation: 'grow',
    content: 'Glissez déposez vos fichiers',
    multiple: true,
    position: 'right',
    theme: 'tooltipster-light',
    trigger: tolltip_trigger
  });

  $('#from_email').tooltipster({
    animation: 'grow',
    content: 'Ajouer votre   adresse email ici',
    multiple: true,
    position: 'right',
    theme: 'tooltipster-light',
    trigger: tolltip_trigger
  });

  $('#to_email').tooltipster({
    animation: 'grow',
    content: 'Ajouer les adresses email des destinataires',
    multiple: true,
    position: 'left',
    theme: 'tooltipster-shadow',
    trigger: tolltip_trigger
  });

  $('#inputMessage').tooltipster({
    animation: 'grow',
    content: 'Joignez un message à votre transfert',
    multiple: true,
    position: 'left',
    theme: 'tooltipster-shadow',
    trigger: tolltip_trigger
  });

  $('.confirm_btn').tooltipster({
    animation: 'grow',
    content: 'Cliquez sur ce bouton pour démarrer le transfert',
    multiple: true,
    position: 'right',
    theme: 'tooltipster-noir',
    trigger: tolltip_trigger
  });
});


function resizeBody() {
  var screen_height = $(window).height();

  var current_main_height = $('.main').height();
  var purpose_main_height = screen_height - $('.navbar').height() - 2;

  if (current_main_height < purpose_main_height) {
    $('.main').height(purpose_main_height);
  }
}