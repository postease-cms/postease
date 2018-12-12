/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function ()
{
	// Datetimepicker On
	$('#sc_publish_date_start, #sc_publish_date_end').datetimepicker(
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

	// Datetimepicker On
	$('#change_publish_datetime').datetimepicker(
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

	// CSS fix
	$('span.label-status').css({display: 'inline-block', padding: '4px 0', width: '52px', height: '1.8em', fontSize: '70%'});
	$('span.label-extra').css({display: 'inline-block', padding: '4px 0', width: '36px', height: '1.8em', fontSize: '70%'});
  $('.select2').css({width: '200px'});
	
	// Narrow Down Search Condition
	$('#sc_status').change(function(){
		var $sc_status = $(this).val();
		location.href = '?page=1&sc_status=' + $sc_status;
	});
	$('#sc_category_id').change(function(){
		var $sc_category_id = $(this).val();
		location.href = '?page=1&sc_category_id=' + $sc_category_id;
	});
	$('#sc_tag_id').change(function(){
		var $sc_tag_id = $(this).val();
		location.href = '?page=1&sc_tag_id=' + $sc_tag_id;
	});
	$('#sc_text').change(function(){
		var $sc_text = $(this).val();
		location.href = '?page=1&sc_text=' + $sc_text;
	});
	$('#sc_publish_date_start').change(function(){
		var $sc_publish_date_start = $(this).val();
		location.href = '?page=1&sc_publish_date_start=' + $sc_publish_date_start;
	});
	$('#sc_publish_date_end').change(function(){
		var $sc_publish_date_end = $(this).val();
		location.href = '?page=1&sc_publish_date_end=' + $sc_publish_date_end;
	});
	$('#sc_anchor').change(function(){
		var $sc_anchor = $(this).val();
		location.href = '?page=1&sc_anchor=' + $sc_anchor;
	});
	$('#sc_created_by').change(function(){
		var $sc_created_by = $(this).val();
		location.href = '?page=1&sc_created_by=' + $sc_created_by;
	});
	if ($('#post_list').hasClass('withEyecatch'))
	{
		$('#post_list td').css({padding: '.4em .7em', height: '5.4em'});
	}


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
		$('#post_list input[type=checkbox]').each(function()
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
			$('#checkall_title').text(TXT_POSTS_LBL_CHECKALL);
			checkall_flg = 0;
		}
	});

	// Check all
	var checkall_flg = 0;
	$('#checkall_title').on('click', function()
	{
		if (! checkall_flg)
		{
			$('#post_list input[type=checkbox]').each(function()
			{
				$(this).prop('checked', true);
			});
			$('#checkall_title').text(TXT_POSTS_LBL_UNCHECKALL);
			$("#operation > .panel-body").slideDown(300);
			checkall_flg = 1;
		}
		else if (checkall_flg)
		{
			$('#post_list input[type=checkbox]').each(function()
			{
				$(this).prop('checked', false);
			});
			$("#operation > .panel-body").slideUp(300);
			$('#checkall_title').text(TXT_POSTS_LBL_CHECKALL);
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

	$('#operation button')
		.mouseover(function(){
			var $hover_class = $(this).attr('data-hover_class');
			$(this).removeClass('btn-default').addClass($hover_class);
		})
		.mouseout(function(){
			var $hover_class = $(this).attr('data-hover_class');
			$(this).removeClass($hover_class).addClass('btn-default');
	});

	// Change order
	$('.changeOrder i').on('click', function()
	{
		var $action           = $(this).attr('id');
		var $process          = $(this).attr('data-process');
		var $publish_datetime = $(this).attr('data-publish_datetime');
		var $target_id        = $(this).attr('data-target_id');

		if ($target_id && $publish_datetime)
		{
			$.ajax({
				type : 'GET',
				url  : './ajax/change_post_order.php',
				data : {
					action           : $action,
					process          : $process,
					publish_datetime : $publish_datetime,
					target_id        : $target_id,
				},
				dataType : 'json',
				success  : function(data){
					if (data.result == 1)
					{
						location.href = './?process=' + data.process;
					}
				}
			});
		}
	});


	// Change order-status
	$('#change_status > button').on('click', function()
	{
		var $target     = $(this).parent().attr('data-target');
		var $action     = $(this).attr('id');
		var $process    = $(this).attr('data-process');
		var $targets    = [];
		$('#post_list input[type=checkbox]').each(function()
		{
			if ($(this).is(':checked'))
			{
				$targets.push($(this).val());
			}
		});

		if ($targets.length >= 1)
		{
			var $msg = false;
			if ($process == '19')
			{
				$msg = window.confirm(TXT_POSTS_CFM_DELETE($target));
			}
			else {
				$msg = true;
			}

			if ($msg == true)
			{
				if ($action == 'to_clone')
				{
					$.ajax({
						type : 'GET',
						url  : './ajax/clone_posts.php',
						data : {
							process : $process,
							targets : $targets,
						},
						dataType : 'json',
						success  : function(data){
							if (data.result == 1)
							{
								location.href = './?process=' + data.process + '&number=' + data.number;
							}
						}
					});
				}
				else {
					$.ajax({
						type : 'GET',
						url  : './ajax/change_post_status.php',
						data : {
							action  : $action,
							process : $process,
							targets : $targets,
						},
						dataType : 'json',
						success  : function(data){
							if (data.result == 1)
							{
								location.href = './?process=' + data.process + '&number=' + data.number;
							}
						}
					});
				}
			}
		}
	});

	// Change publish_datetime
	$('.changePublishDatetime button').on('click', function()
	{
		var $publish_datetime = $('#change_publish_datetime').val();
		var $process          = $(this).attr('data-process');
		var $targets    = [];
		$('#post_list input[type=checkbox]').each(function()
		{
			if ($(this).is(':checked'))
			{
				$targets.push($(this).val());
			}
		});

		if ($targets.length >= 1 && $publish_datetime)
		{
			$.ajax({
				type : 'GET',
				url  : './ajax/change_post_publish_datetime.php',
				data : {
					process          : $process,
					publish_datetime : $publish_datetime,
					targets          : $targets,
				},
				dataType : 'json',
				success  : function(data){
					if (data.result == 1)
					{
						location.href = './?process=' + data.process + '&number=' + data.number;
					}
				}
			});
		}
	});

	// Change taxonomy
	$('.changeTaxonomy button').on('click', function()
	{
		var $action      = $(this).attr('id');
		var $process     = $(this).attr('data-process');
		var $taxonomy_id = 0;
		if ($action == 'add_category' || $action == 'remove_category')
		{
			$taxonomy_id = Number($('#change_category_id').val());
		}
		if ($action == 'add_tag' || $action == 'remove_tag')
		{
			$taxonomy_id = Number($('#change_tag_id').val());
		}
		var $targets    = [];
		$('#post_list input[type=checkbox]').each(function()
		{
			if ($(this).is(':checked'))
			{
				$targets.push($(this).val());
			}
		});

		if ($targets.length >= 1 && $taxonomy_id > 0)
		{
			$.ajax({
				type : 'GET',
				url  : './ajax/change_post_taxonomy.php',
				data : {
					action      : $action,
					process     : $process,
					targets     : $targets,
					taxonomy_id : $taxonomy_id,
				},
				dataType : 'json',
				success  : function(data){
					if (data.result == 1)
					{
						location.href = './?process=' + data.process + '&number=' + data.number;
					}
				}
			});
		}
	});

});