/*
 * Global Variables
 * ------------------------------------------------------------------------------------------------ */
var $targets_post = '#title, #content, #nickname, #email, #ip_address, #posted_at';
var $targets_edit = '#title, #content, #nickname, #email, #ip_address, #posted_at, #site_id, #posttype_id';

//For Images
var $check_eyecatch       = 0; // to change eyecatch-image timely.


/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function () {

	// Load for Create
	if ($('#process').val() == '21' || $('#type').val() == '3') {
		$($targets_post).attr('disabled', false);
	}

	// Datetimepicker On
	$('#posted_at').datetimepicker(
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

	// Update button
	$('#edit_check').on('click', function(){
		if ($('#edit_check:checked').val()){
			$($targets_edit).attr('disabled', false);
			$('#process').val('23');
		}
		else {
			$($targets_edit).attr('disabled', true);
			$('#process').val('22');
		}
	});

	// Delete button
	$('#delete_check').click(function(){
		if ($('#delete_check:checked').val()){
			$('#delete_comment').css({display: 'inline'});
			$('#update_comment').css({display: 'none'});
			$('#process').val('29');
			alert(TXT_COMMENT_ALT_DELETEBUTTON);
		}
		else {
			$('#delete_comment').css({display: 'none'});
			$('#update_comment').css({display: 'inline'});
			if ($('#edit_check').is(':checked')){
				$('#process').val('23');
			}
			else {
				$('#process').val('22');
			}
		}
	});

	// click star action for score
	$('.score i').on('click', function(){
		if ($('#process').val() != 22) {
			var $review_max_score = $('#score').attr('data-review_max_score');
			var $index = $('.score i').index(this);
			for (var i=0; i<=$index; i++){
				$('.score i').eq(i).attr('class', 'fa fa-star');
			}
			for (var i=($index+1); i<$review_max_score; i++){
				$('.score i').eq(i).attr('class', 'fa fa-star-o');
			}
			$('#score').val($index + 1);
		}
	});

	$('.changeStatusClose').on('click', function()
	{
		var $status = $(this).attr('data-status');
		$('input[name=status]').val([$status]);
		$('#comment').submit();
		return false;
	});

	/*
	 * Media(image)
	 * ------------------------------------------------------------------------------------------------ */
	// Open Filemanager
	$('.openFilemanager').fancybox({
		'minWidth'  : 860,
		'minHeight' : 520,
		'type'		: 'iframe',
	    'autoScale' : true,
	});

	// Load Images
	loadEyecatch();

	// Refresh Image (with auto save)
	$('#content').on('touchstart, mouseover', function(){
		// eyecatch
		if ($check_eyecatch == 0)
		{
			$update_flg = 1;
			loadEyecatch();
			$('#publish_post').removeClass('hidden');
		}
	});

	// Prepare Set Image
	// eyecatch
	$('#set_eyecatch, #eyecatch').on('click', function(){
		$check_eyecatch = 0;
	});

	// Remove Image
	// eyecatch
	$('#remove_eyecatch').on('click', function(){
		$(this).addClass('hidden');
		$('#eyecatch').val('');
		$('#eyecatch_wrap img').animate({opacity: 0}, 200);
		setTimeout(function(){
			$('#eyecatch_wrap img').slideUp(200);
		}, 300);
	});
});