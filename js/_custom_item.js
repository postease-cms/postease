/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function()
{
	// Onload
	if ($('#type').val() == 'image' || $('#type').val() == 'gallery')
	{
		$('#choices_image').css({display: 'block', opacity: 1}).attr('disbled', false);
		$('#target_image').attr('disabled', false);
		$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_list').attr('disabled', true);
		$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_syntax').attr('disabled', true);
		$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_delimiter').attr('disabled', true);
	}
	else if ($('#type').val() == 'table')
	{
		$('#choices_column_delimiter').css({display: 'block', opacity: 1}).attr('disbled', false);
		$('#target_delimiter').attr('disabled', false);
		$('#choices_syntax').css({display: 'none', opacity: 1}).attr('disbled', true);
		$('#target_syntax').attr('disabled', true);
		$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_image').attr('disabled', true);
		$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_list').attr('disabled', true);
	}
	else if ($('#type').val() == 'syntax')
	{
		$('#choices_syntax').css({display: 'block', opacity: 1}).attr('disbled', false);
		$('#target_syntax').attr('disabled', false);
		$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_image').attr('disabled', true);
		$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_list').attr('disabled', true);
		$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_delimiter').attr('disabled', true);
	}
	else if ($('#type').val() == 'select' || $('#type').val() == 'radio' || $('#type').val() == 'checkbox')
	{
		$('#choices_list').css({display: 'block', opacity: 1}).attr('disbled', false);
		$('#target_list').attr('disabled', false);
		$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_image').attr('disabled', true);
		$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_syntax').attr('disabled', true);
		$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_delimiter').attr('disabled', true);
	}
	else {
		$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_list').attr('disabled', true);
		$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_image').attr('disabled', true);
		$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_syntax').attr('disabled', true);
		$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
		$('#target_delimiter').attr('disabled', true);
	}


	// Change
	$('#type').on('change', function()
	{
		if ($(this).val() == 'image' || $(this).val() == 'gallery')
		{
			$('#choices_image').css({display: 'block', opacity: 1}).attr('disbled', false);
			$('#target_image').attr('disabled', false);
			$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_list').attr('disabled', true);
			$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_syntax').attr('disabled', true);
			$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_delimiter').attr('disabled', true);

		}
		else if ($('#type').val() == 'table')
		{
			$('#choices_column_delimiter').css({display: 'block', opacity: 1}).attr('disbled', false);
			$('#target_delimiter').attr('disabled', false);
			$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_syntax').attr('disabled', true);
			$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_image').attr('disabled', true);
			$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_list').attr('disabled', true);

		}
		else if ($('#type').val() == 'syntax')
		{
			$('#choices_syntax').css({display: 'block', opacity: 1}).attr('disbled', false);
			$('#target_syntax').attr('disabled', false);
			$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_image').attr('disabled', true);
			$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_list').attr('disabled', true);
			$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_delimiter').attr('disabled', true);
		}
		else if ($('#type').val() == 'select' || $('#type').val() == 'radio' || $('#type').val() == 'checkbox')
		{
			$('#choices_list').css({display: 'block', opacity: 1}).attr('disbled', false);
			$('#target_list').attr('disabled', false);
			$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_image').attr('disabled', true);
			$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_syntax').attr('disabled', true);
			$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_delimiter').attr('disabled', true);
		}
		else {
			$('#choices_list').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_list').attr('disabled', true);
			$('#choices_image').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_image').attr('disabled', true);
			$('#choices_syntax').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_syntax').attr('disabled', true);
			$('#choices_column_delimiter').css({display: 'none', opacity: 0}).attr('disbled', true);
			$('#target_delimiter').attr('disabled', true);
		}
	});

});