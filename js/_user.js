/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function(){

	// Check account
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();
	$('#account').keyup(function()
	{
		delay(function(){
			checkAccount();
		}, 500 );
	});
	$('#account').change(function()
	{
		checkAccount();
	});

	$('#role, #group_id').change(function()
	{
		var $role_value = $('#role').val();
		var $group_id = $('#group_id').val();
		if ($role_value <= 2 && $group_id)
		{
			alert(TXT_USER_ALT_CANTSETGROUP);
			$('#group_id').val('');
		}
	});
});


/*
 * Functions
 * ------------------------------------------------------------------------------------------------ */
function checkAccount()
{
	var $target_element = $('#input_wrapper_account');
	var $account        = $('#account').val();
	var $this_id        = ($($target_element).hasAttr('data-this_id')) ? $($target_element).attr('data-this_id') : null;

	$.ajax({
		type : 'GET',
		url  : './ajax/validation/check_account.php',
		data : {
			account : $account,
			this_id : $this_id,
		},
		dataType : 'json',
		success  : function(data)
		{
			if (data.result == 1)
			{
				$('.inputAlert').remove();
				$('#do_update').show();
			}
			if (data.result == 8)
			{
				$('.inputAlert').remove();
				$($target_element).after('<p class="alert alert-danger inputAlert">' + TXT_USER_WAR_OVERLAPACCOUNT + '</p>');
				$('#do_update').hide();

				$('#account').parent().removeClass('has-success');
				$('#account').parent().addClass('has-error');
				$('#account').closest('.form-group').find('.validIcon').addClass('hidden');
				$('#account').closest('.form-group').find('.invalidIcon').removeClass('hidden');
				$('#do_update').addClass('hidden');
			}
		}
	});
}

function runValidOne($target)
{
	var $type = $($target).attr('data-valid_type');
	var $submit_button = $('#do_update');
	if ($($target).val() != '' && validOne($($target).val(), $type))
	{
		$($target).parent().removeClass('has-error');
		$($target).parent().addClass('has-success');
		$($target).closest('.form-group').find('.invalidIcon').addClass('hidden');
		$($target).closest('.form-group').find('.validIcon').removeClass('hidden');
		$($submit_button).removeClass('hidden');
	}
	else if ($($target).val() != '' && ! validOne($($target).val(), $type)){
		$($target).parent().removeClass('has-success');
		$($target).parent().addClass('has-error');
		$($target).closest('.form-group').find('.validIcon').addClass('hidden');
		$($target).closest('.form-group').find('.invalidIcon').removeClass('hidden');
		$($submit_button).addClass('hidden');
	}
	else {
		$($target).parent().removeClass('has-success');
		$($target).parent().removeClass('has-error');
		$($target).closest('.form-group').find('.validIcon').addClass('hidden');
		$($target).closest('.form-group').find('.invalidIcon').addClass('hidden');
		$($submit_button).removeClass('hidden');
	}
}

