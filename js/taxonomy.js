/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function(){

	// Language Switch on Panel
	$('.panelSelectLang > a').click(function()
	{
		var $target_class = '.formPartsLang_' + $(this).attr('data-target_lang');
		$('.panelSelectLang > a').removeClass('btn-primary btn-default');
		$('.panelSelectLang > a').not(this).addClass('btn-default');
		$(this).addClass('btn-primary');
		$('.formHasLang > div').addClass('hidden');
		$($target_class).removeClass('hidden');
	});

	// Language Switch on Table
	$('.tableSelectLang > a').click(function()
	{
		var $target_class = '.tdPartsLang_' + $(this).attr('data-target_lang');
		$('.tableSelectLang > a').removeClass('btn-primary btn-default');
		$('.tableSelectLang > a').not(this).addClass('btn-default');
		$(this).addClass('btn-primary');
		$('.tableHasLang span').addClass('hidden');
		$($target_class).removeClass('hidden');
	});


	// Validate required and Button spinner action
	$('form').submit(function()
	{
		var $mode_delete_flg = ($('#allow_delete').prop('checked') == true) ? 1 : 0;
		var $label_filled = 0;
		var $label_empty  = 0;
		var $spinner_flg  = 1;
		if (! $mode_delete_flg)
		{
			$('.formHasLang input').each(function()
			{
				var $value = $(this).val();
				if (! $value)
				{
					$label_empty ++;
					$label_check_flg = 0;
				}
				else {
					$label_filled ++;
				}
			});
			if ($label_filled == 0)
			{
				alert(TXT_TAXONOMY_ALT_NOLABEL);
				$spinner_flg = 0;
				return false;
			}
			else if ($label_filled > 0 && $label_empty > 0)
			{
				if(! window.confirm(TXT_TAXONOMY_CFM_HASNOLABEL))
				{
					$spinner_flg = 0;
					return false;
				}
			}
		}
		if ($spinner_flg == 1)
		{
			$('#do_update').addClass('hidden');
			$('#do_delete').addClass('hidden');
			$('.spinner').removeClass('hidden');
		}
	});

});

