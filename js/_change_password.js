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
}

