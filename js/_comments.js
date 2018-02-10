/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function () {

	// CSS fix
	$('span.label-status').css({display: 'inline-block', padding: '4px 0', width: '44px', marginRight: '2px'});
	$('span.label-extra').css({display: 'inline-block', padding: '4px 0', width: '38px', marginRight: '2px'});
	$('span.label-narrowdown').css({display: 'inline-block', padding: '10px', width: '198px', margin: '0px 3px', fontSize: '100%', fontWeight: 'normal'});

	// Narrow Down Search Condition
	var $type = $('#type').val();
	$('#sc_status').change(function(){
		var $sc_status = $(this).val();
		location.href = '?page=1&type=' + $type + '&sc_status=' + $sc_status;
	});
	$('#sc_score').change(function(){
		var $sc_score = $(this).val();
		location.href = '?page=1&type=' + $type + '&sc_score=' + $sc_score;
	});
	$('#sc_category_id').change(function(){
		var $sc_category_id = $(this).val();
		location.href = './?view_page=posts&page=1&type=' + $type + '&sc_category_id=' + $sc_category_id;
	});
	$('#sc_tag_id').change(function(){
		var $sc_tag_id = $(this).val();
		location.href = './?view_page=posts&page=1&type=' + $type + '&sc_tag_id=' + $sc_tag_id;
	});
	$('#sc_text').change(function(){
		var $sc_text = $(this).val();
		location.href = '?page=1&type=' + $type + '&sc_text=' + $sc_text;
	});
	$('#sc_posted_at_start').change(function(){
		var $sc_posted_at_start = $(this).val();
		location.href = '?page=1&type=' + $type + '&sc_posted_at_start=' + $sc_posted_at_start;
	});
	$('#sc_posted_at_end').change(function(){
		var $sc_posted_at_end = $(this).val();
		location.href = '?page=1&type=' + $type + '&sc_posted_at_end=' + $sc_posted_at_end;
	});

	// Datetimepicker On
	$('#sc_posted_at_start, #sc_posted_at_end').datetimepicker(
	{
		format: 'yyyy-mm-dd',
		startView: 2,
		maxView: 3,
		minView: 2,
		language: getCookie('lang'),
		autoclose: true,
		todayHighlight: true,
		todayBtn: true,
	});

	// Batch Operation
	// Panel Toggle Action
	$("#operation > .panel-heading").click(function(e){
		var target = e.target;
		if (target.id == 'checkall') {
			$(this).next().slideToggle(300);
		}
	});

	// Check one
	$('.batchCheck').on('click', function()
	{
		var $checked = 0;
		$('#comment_list input[type=checkbox]').each(function()
		{
			if($(this).prop('checked'))
			{
				$checked = 1;
				$("#operation > .panel-body").slideDown(300);
				return false;
			}
		});
		if (! $checked) {
			$("#operation > .panel-body").slideUp(300);
			$('#checkall_title').text(TXT_COMMENT_LBL_CHECKALL);
			checkall_flg = 0;
		}
	});

	// Check all
	var checkall_flg = 0;
	$('#checkall_title').on('click', function()
	{
		if (! checkall_flg)
		{
			$('#comment_list input[type=checkbox]').each(function()
			{
				$(this).prop('checked', true);
			});
			$('#checkall_title').text(TXT_COMMENT_LBL_UNCHECKALL);
			$("#operation > .panel-body").slideDown(300);
			checkall_flg = 1;
		}
		else if (checkall_flg)
		{
			$('#comment_list input[type=checkbox]').each(function()
			{
				$(this).prop('checked', false);
			});
			$("#operation > .panel-body").slideUp(300);
			$('#checkall_title').text(TXT_COMMENT_LBL_CHECKALL);
			checkall_flg = 0;
		}
	});
	// Allow delete
	$('#allow_delete').on('click', function()
	{
		if ($(this).is(':checked'))
		{
			$('#to_delete').css({display: 'inline'});
		}
		else {
			$('#to_delete').css({display: 'none'});
		}
	});

	$('#operationButton button')
		.mouseover(function(){
			var $hover_class = $(this).attr('data-hover_class');
			$(this).removeClass('btn-default').addClass($hover_class);
		})
		.mouseout(function(){
			var $hover_class = $(this).attr('data-hover_class');
			$(this).removeClass($hover_class).addClass('btn-default');
	});

	// Change order-status
	$('#operationButton button').on('click', function()
	{
		var $target     = $(this).parent().attr('data-target');
		var $action     = $(this).attr('id');
		var $process    = $(this).attr('data-process');
		var $targets    = [];
		$('#comment_list input[type=checkbox]').each(function()
		{
			if ($(this).is(':checked'))
			{
				$targets.push($(this).val());
			}
		});
		if ($targets.length >= 1)
		{
			var $msg = false;
			if ($process == '29')
			{
				$msg = window.confirm(TXT_COMMENT_CFM_DELETE($target));
			}
			else {
				$msg = true;
			}
			if ($msg == true)
			{
				$.ajax({
					type : 'GET',
					url  : './ajax/change_comment_status.php',
					data : {
						action  : $action,
						process : $process,
						targets : $targets,
					},
					dataType : 'json',
					success  : function(data){
						if (data.result == 1)
						{
							location.href = '?process=' + data.process + '&number=' + data.number;
						}
					}
				});
			}
		}
	});

});