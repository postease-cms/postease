/*
 * Global Variables
 * ------------------------------------------------------------------------------------------------ */
var $targets_post = '#title, #content, #name, #email, #tel, #zip_code, #address, #contacted_at, #language_id, #contact_way, *[data-group=custom], input[name=categories\\[\\]]';
var $targets_edit = '#title, #content, #name, #email, #tel, #zip_code, #address, #contacted_at, #language_id, #contact_way, *[data-group=custom], input[name=categories\\[\\]]';


/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function() {

	// Load for Create
	if ($('#process').val() == '31') {
		$($targets_post).attr('disabled', false);
		$('#submit_contact').css('display', 'block');
	}

	// Datetimepicker On
	$('#contacted_at, .customDate').datetimepicker(
	{
		format: 'yyyy-mm-dd hh:ii',
		startView: 2,
		maxView: 3,
		minView: 0,
		language: getCookie('lang'),
		autoclose: true,
		minuteStep: 1,
		todayHighlight: true,
		todayBtn: true,
	});

	// Valid datetime
	runValidDatetime($('#contacted_at'));
	$('#contacted_at').on('change', function()
	{
		runValidDatetime($('#contacted_at'));
	});

	// Update button
	$('#edit_check').on('click', function()
	{
		if ($('#edit_check:checked').val()){
			var $created_by = $('#created_by').val();
			if ($created_by == 0)
			{
				if ($msg = window.confirm(TXT_CONTACT_CNF_UPDATE))
				{
					$('#delete_check').prop('checked', false);
					$('#submit_contact').css({display: 'block'});
					$('#delete_contact, #to_status_1, #to_status_7').css({display: 'none'});
					$($targets_edit).attr('disabled', false);
					$('#process').val('33');
				}
				else {
					$(this).prop('checked', false);
				}
			}
			else {
				$('#delete_check').prop('checked', false);
				$('#submit_contact').css({display: 'block'});
				$('#delete_contact, #to_status_1, #to_status_7').css({display: 'none'});
				$($targets_edit).attr('disabled', false);
				$('#process').val('33');
			}
		}
		else {
			$('#submit_contact').css({display: 'none'});
			$('#to_status_1, #to_status_7').css({display: 'inline'});
			$($targets_edit).attr('disabled', true);
			$('#process').val('32');
		}
	});

	// Delete button
	$('#delete_check').click(function()
	{
		if ($('#delete_check:checked').val())
		{
			var $created_by = $('#created_by').val();
			if ($created_by == 0)
			{
				if ($msg = window.confirm(TXT_CONTACT_CNF_ALLOWDELETE))
				{
					$('#edit_check').prop('checked',false);
					$('#delete_contact').css({display: 'block'});
					$('#submit_contact, #to_status_1, #to_status_7').css({display: 'none'});
					$('#process').val('39');
					alert(TXT_CONTACT_ALT_DELETEBUTTON);
				}
				else {
					$(this).prop('checked', false);
				}
			}
			else {
				$('#edit_check').prop('checked',false);
				$('#delete_contact').css({display: 'block'});
				$('#submit_contact, #to_status_1, #to_status_7').css({display: 'none'});
				$('#process').val('39');
				alert(TXT_CONTACT_ALT_DELETEBUTTON);
			}
		}
		else {
			$('#delete_contact').css({display: 'none'});
			$('#to_status_1, #to_status_7').css({display: 'inline'});
			if ($('#edit_check').is(':checked')){
				$('#process').val('33');
			}
			else {
				$('#process').val('32');
			}
		}
	});

	$('.changeStatusClose').on('click', function()
	{
		var $status = $(this).attr('data-status');
		$('input[name=status]').val([$status]);
		$('#contact').submit();
	});

});