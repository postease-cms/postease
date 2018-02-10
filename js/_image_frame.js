/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function()
{
	// labels default
	var $type = $('#type').val();
	if ($type == 'auto')
	{
		$('#label_width').text(TXT_IMAGEFRAME_LBL_WIDTH_AUTO);
		$('#label_height').text(TXT_IMAGEFRAME_LBL_HEIGHT_AUTO);
	}
	else {
		$('#label_width').text(TXT_IMAGEFRAME_LBL_WIDTH_CROP);
		$('#label_height').text(TXT_IMAGEFRAME_LBL_HEIGHT_CROP);
	}

	// labels when change type
	$('#type').change(function(){
		var $updated_type = $(this).val();
		if ($updated_type == 'auto')
		{
			$('#label_width').text(TXT_IMAGEFRAME_LBL_WIDTH_AUTO);
			$('#label_height').text(TXT_IMAGEFRAME_LBL_HEIGHT_AUTO);
		}
		else {
			$('#label_width').text(TXT_IMAGEFRAME_LBL_WIDTH_CROP);
			$('#label_height').text(TXT_IMAGEFRAME_LBL_HEIGHT_CROP);
		}
	});

});