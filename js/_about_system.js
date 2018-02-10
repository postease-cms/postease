/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function () {

	// Panel Toggle Action
	$('.panel-heading').css('cursor', 'pointer').click(function(e){
		var $target = e.target;
		if ($target.id.indexOf('update_history') != -1 || $target.id.indexOf('purchase_history') != -1) {
			$(this).next().slideToggle(300);
		}
	});

	// Change applied level and reload
	$('input[name=level\\[\\]]').change(function()
	{
		var $sc_level = $('input[name=level\\[\\]]:checked').map(function() {
			return $(this).val();
		}).get();
		location.href = '?applied_level=' + $sc_level;
	});

	$('#unlock_activation_key').on('click', function()
	{
		$(this).hide();
		$('#activation_key_masked').hide();
		$('#activation_key_full').show();
		$('#lock_activation_key').show();
	});
	$('#lock_activation_key').on('click', function()
	{
		$(this).hide();
		$('#activation_key_masked').show();
		$('#activation_key_full').hide();
		$('#unlock_activation_key').show();
	});
});