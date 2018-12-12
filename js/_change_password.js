/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function(){

	// Input validation
	$('.needValidation').each(function()
	{
		runValidOneCommon($(this), $('#do_submit'));
	});
	$('.needValidation').keyup(function()
	{
		runValidOneCommon($(this), $('#do_submit'));
	});

	// Password Comparision
	checkSameType($('#password_confirm'), $('#password_new'), $('#do_submit'));
	$('#password_confirm, #password_new').keyup(function()
	{
		checkSameType($('#password_confirm'), $('#password_new'), $('#do_submit'));
	});
	
	$('#password_generator').on('click', function()
	{
		var $new_password = makePassword();
		$('#password_new').val($new_password);
		$('#password_confirm').val($new_password);
    runValidOneCommon($('.needValidation'), $('#do_submit'));
    checkSameType($('#password_confirm'), $('#password_new'), $('#do_submit'));
    showDownloadPasswordButton();
	})

	$('#password_new, #password_confirm').change(function ()
	{
    showDownloadPasswordButton();
  });
  showDownloadPasswordButton();
	
  $('#download_password').on('click', function () {
		$('#download_password').remove();
  })
  
});

/*
 * functions
 * ------------------------------------------------------------------------------------------------ */
function checkSameType($target, $comparison, $submit_target)
{
	var $submit_button = $submit_target;
	if ($($target).val() != '' && $($comparison).val() != '')
	{
		if ($($target).val() == $($comparison).val())
		{
			$($target).parent().removeClass('has-error');
			$($target).parent().addClass('has-success');
			$($target).closest('.form-group').find('.invalidIcon').addClass('hidden');
			$($target).closest('.form-group').find('.validIcon').removeClass('hidden');
			$submit_button.removeClass('hidden');
			return true;
		}
		else {
			$($target).parent().removeClass('has-success');
			$($target).parent().addClass('has-error');
			$($target).closest('.form-group').find('.validIcon').addClass('hidden');
			$($target).closest('.form-group').find('.invalidIcon').removeClass('hidden');
			$submit_button.addClass('hidden');
		}
	}
	else {
		$($target).parent().removeClass('has-success');
		$($target).parent().removeClass('has-error');
		$($target).closest('.form-group').find('.validIcon').addClass('hidden');
		$($target).closest('.form-group').find('.invalidIcon').addClass('hidden');
		$submit_button.removeClass('hidden');
	}
  return false;
}



function showDownloadPasswordButton ()
{
  if (checkSameType($('#password_confirm'), $('#password_new'), $('#do_submit')))
  {
    $.ajax({
      url: 'ajax/make_auth_file.php',
      type: 'post',
      data: {
        account : $('#account').val(),
        password : $('#password_new').val()
      },
      dataType: 'json',
    }).done(function ($response)
    {
      if ($response['result'] == '1')
      {
        if (! $('#download_password').length)
        {
          $('#password_auto_generate').append('<a href="ajax/download_account_password.php" class="btn btn-info" id="download_password">' + TXT_RESETSYSTEM_LNK_DOWNLOAD_PASSWORD + '</a>');
        }
      }
    });
  }
}