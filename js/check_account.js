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
});


/*
 * Functions
 * ------------------------------------------------------------------------------------------------ */
function checkAccount()
{
	var $target_element = $('#input_wrapper_account');
	var $account        = $('#account');
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
				$($target_element).after('<p class="alert alert-danger inputAlert">' + TXT_CHECKSLUG_WAR_OVERLAPSLUG + '</p>');
				$('#do_update').hide();
			}
		}
	});
}

