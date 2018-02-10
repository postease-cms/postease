/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function(){

	// Activate multipost
	$('input[name=use_multisite_flg], input[name=use_multilingual_flg]').on('click', function()
	{
		var $this_value = $(this).val();
		var $posttype_flg = $('input[name=use_posttype_flg]:checked').val();
		if ($this_value == 1 && $posttype_flg == 0)
		{
			if(window.confirm(TXT_CONFIGOPTION_CFM_USEPOSTTYPE))
			{
				$('input[name=use_posttype_flg]').val(['1']);
			}
			else{
				$(this).val(['0']);
				return false;
			}
		}
	});
});