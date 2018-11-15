/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function() {

	var $mode             = Number($('#mode').val());
	var $established_db   = Number($('#established_db').val());
	var $shift_db         = Number($('#shift_db_hidden').val());
	var $requested_from   = ($.cookie('requested_from')) ? $.cookie('requested_from') : '';
	var $onetime_password = ($.cookie('onetime_password')) ? $.cookie('onetime_password') : '';
	var $host_activation  = ($.cookie('host_activation')) ? decodeURIComponent($.cookie('host_activation')) : '';
	var $lang             = ($.cookie('lang')) ? $.cookie('lang') : '';
	
	// modal action
	$('#myModal').modal({
		show: true,
		backdrop: false,
	});
	$('body').css({backgroundColor: '#999'});
	$('#myModal').on('hidden.bs.modal', function (e) {
		location.reload();
	});

	// hide checkbox for shift-db
	if ($established_db == 0){
		$('#shift_db_wrap').css({display: 'none'});
	}

	// hide submit-button before check shift-db
	if ($mode == 2 && $shift_db == 0)
	{
		$('#submit').addClass('hidden');
	}
	$('#shift_db').on('change', function ()
	{
	    if ($(this).prop('checked'))
	    {
	    	$('#submit').removeClass('hidden');
	    }
	    else {
	    	$('#submit').addClass('hidden');
	    }
	});

	// toggle mysql-input
	var $targets_mysql = '#db_host, #db_name, #db_user, #db_pass';
	if ($('#database').val() == 1) {
		$('#info_db_connect').hide();
	}
	else {
		$($targets_mysql).attr('disabled', false);
	}

	$('#database').on('change', function()
	{
		// toggle mysql-input
		if ($(this).val() == 1) {
			$('#info_db_connect').slideUp();
			$($targets_mysql).attr('disabled', true);
		}
		else {
			$('#info_db_connect').slideDown();
			$($targets_mysql).attr('disabled', false);
		}
	});

	// notice shift_db
	$('#shift_db').on('click', function(){
		if ($('#shift_db:checked').val()){
			alert(TXT_RESETSYSTEM_ALT_SHIFTDB);
		}
	});

	// waite process
	$('#do_submit').click(function()
	{
		$('.spinnerInline').removeClass('hidden');
		$(this).addClass('hidden');
		setTimeout(function()
		{
			if ($mode == 2)
			{
				$('.modal-footer').prepend(TXT_RESETSYSTEM_MSG_NOWSHIFTDB);
			}
			else {
				$('.modal-footer').prepend(TXT_RESETSYSTEM_MSG_NOWSETTING);
			}
		}, 1000);
	});

	// input validation
	$('.needValidation').each(function()
	{
		runValidOne($(this));
	});
	$('.needValidation').keyup(function()
	{
		runValidOne($(this));
	});
	$('.needValidation').change(function()
	{
		runValidOne($(this));
	});
 
	showDownloadPasswordButton();
	
	
	
	// get activation key
	$('#getActivationKey').on('click', function()
	{
    $('.modal-body .alert').remove();
    var $email = $('#request_email').val();
		
    if (false === validOne($email, 'email'))
		{
      $('.modal-body').prepend('<div class="alert alert-danger">' + TXT_RESETSYSTEM_ALT_INVALID_EMAIL + '</div>');
		}
		else {
      $('.modal-body').prepend('<div class="alert alert-info"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> ' + TXT_RESETSYSTEM_MSG_ONISSUE_ACTIVATIONKEY + '</div>');
      setTimeout(function ()
      {
        if (! $requested_from || ! $onetime_password || ! $host_activation || ! $lang)
        {
          $.ajax({
            url: 'ajax/make_local_env.php',
            type: 'post',
            dataType: 'json',
            async: false,
          }).done(function ($responce)
          {
            if ($responce['result'] == '1')
            {
              $requested_from   = $responce.requested_from;
              $onetime_password = $responce.onetime_password;
              $host_activation  = $responce.host_activation;
              $lang             = $responce.lang;
              $.cookie('requested_from', $responce.requested_from);
              $.cookie('onetime_password', $responce.onetime_password);
              $.cookie('host_activation', encodeURIComponent($responce.host_activation));
              $.cookie('lang', $responce.lang);
            }
          });
        }
        if ($email)
        {
          $.ajax({
            url: $host_activation + '/ajax/make_license.php',
            type: 'post',
            data: {
              requested_from : $requested_from,
              onetime_password : $onetime_password,
              email : $email,
              lang : $lang,
            },
            dataType: 'json',
            async: false,
          })
          .done(function ($responce)
          {
            if ($responce['result'] == '1')
            {
              $('.modal-body .alert').remove();
              $('#getActivationKey').remove();
              $('#request_email').prop('disabled', true);
              $('#account').val($email).change();
              $('.modal-body').prepend('<div class="alert alert-success">' + TXT_RESETSYSTEM_MSG_ISSUED_ACTIVATIONKEY + '</div>');
            }
            if ($responce['result'] == '6')
            {
              $('.modal-body .alert').remove();
              $('.modal-body').prepend('<div class="alert alert-danger">' + TXT_RESETSYSTEM_ALT_INVALID_EMAIL + '</div>');
            }
          });
        }
      }, 100);
		}
	});
	
	
	$('#password').change(function()
	{
		showDownloadPasswordButton();
	});
	
	
  // make password automatically
  $('#makePassword').on('click', function()
  {
    var $password = makePassword();
    $('#password').val($password).change();
  });
	
	// make prefix automatically
	$('#makePrefix').on('click', function()
	{
		var $prefix = makePrefix();
		$('#table_prefix').val($prefix).change();
	});
});


/*
 * Functions
 * ------------------------------------------------------------------------------------------------ */
function runValidOne($target)
{
	var $type = $($target).attr('data-valid_type');
	var $submit_button = $('#do_submit');
	if ($($target).val() != '' && validOne($($target).val(), $type))
	{
		$($target).parent().removeClass('has-error');
		$($target).parent().addClass('has-success');
		$($target).next().addClass('hidden');
		$($target).closest('.form-group').find('.needValidIcon').addClass('hidden');
		$($target).closest('.form-group').find('.validIcon').removeClass('hidden');
		$($submit_button).removeClass('hidden');
	}
	else if ($($target).val() != '' && ! validOne($($target).val(), $type)){
		$($target).parent().removeClass('has-success');
		$($target).parent().addClass('has-error');
		$($target).next().removeClass('hidden');
		$($target).closest('.form-group').find('.validIcon').addClass('hidden');
		$($target).closest('.form-group').find('.needValidIcon').removeClass('hidden');
		$($submit_button).addClass('hidden');
	}
	else {
		$($target).parent().removeClass('has-success');
		$($target).parent().removeClass('has-error');
		$($target).next().addClass('hidden');
		$($target).closest('.form-group').find('.validIcon').addClass('hidden');
		$($target).closest('.form-group').find('.needValidIcon').removeClass('hidden');
		$($submit_button).removeClass('hidden');
	}
}



function showDownloadPasswordButton ()
{
  if (validOne($('#account').val(), 'account') && validOne($('#password').val(), 'password'))
  {
    $.ajax({
      url: 'ajax/make_auth_file.php',
      type: 'post',
      data: {
        account : $('#account').val(),
        password : $('#password').val()
      },
      dataType: 'json',
    }).done(function ($responce)
    {
      if ($responce['result'] == '1')
      {
        if (! $('#download_password').length)
        {
          $('.modal-footer').prepend('<a href="ajax/download_account_password.php" class="btn btn-info" id="download_password">' + TXT_RESETSYSTEM_LNK_DOWNLOAD_PASSWORD + '</a>');
        }
      }
    });
  }
}