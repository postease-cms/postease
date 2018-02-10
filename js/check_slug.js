/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function()
{
	// Check slug
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();
	$('#slug').keyup(function()
	{
		delay(function(){
			checkSlug();
			runValidOneCommon($('#slug'), $('#do_update'));
		}, 500 );
	});
	$('#slug').change(function()
	{
		checkSlug();
	});
});


/*
 * Functions
 * ------------------------------------------------------------------------------------------------ */
function checkSlug()
{
	var $target         = $('#slug');
	var $submit_button  = $('#do_update');
	var $target_wrapper = $('#input_wrapper_slug');
	var $this_slug      = $('#slug').val();
	var $target_table   = ($target_wrapper.hasAttr('data-target_table')) ? $target_wrapper.attr('data-target_table') : null;
	var $this_id        = ($target_wrapper.hasAttr('data-this_id')) ? $target_wrapper.attr('data-this_id') : null;
	var $classification = ($target_wrapper.hasAttr('data-classification')) ? $('#input_wrapper_slug').attr('data-classification') : null;

	$.ajax({
		type : 'GET',
		url  : './ajax/validation/check_slug.php',
		data : {
			target_table   : $target_table,
			this_slug      : $this_slug,
			this_id        : $this_id,
			classification : $classification,
		},
		dataType : 'json',
		success  : function(data)
		{
			if (data.result == 1)
			{
				if($('p.inputAlert').length)
				{
					$('p.inputAlert').remove();
				}
			}
			if (data.result == 8)
			{
				$('.inputAlert').remove();
				$('div#input_wrapper_slug').after('<p class="alert alert-danger inputAlert">' + TXT_CHECKSLUG_WAR_OVERLAPSLUG + '</p>');
				$target.parent().removeClass('has-success');
				$target.parent().addClass('has-error');
				$target.closest('.form-group').find('.validIcon').addClass('hidden');
				$target.closest('.form-group').find('.invalidIcon').removeClass('hidden');
				$submit_button.addClass('hidden');
			}
		}
	});
}

