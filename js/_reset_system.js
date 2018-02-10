/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function() {

	var $mode           = Number($('#mode').val());
	var $established_db = Number($('#established_db').val());
	var $shift_db       = Number($('#shift_db_hidden').val());

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

function makePrefix()
{
	var $length = 4;
	var $char = "abcdefghijklmnopqrstuvwxyz";
	var $char_length = $char.length;
	var $string = "";
	for(var i = 0; i < $length; i ++){
		$string += $char[Math.floor(Math.random() * $char_length)];
	}
	return $string + '_';
}