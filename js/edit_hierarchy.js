/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function () {

	var $target_table     = $('#content').attr('data-target_table');
	var $host_activation  = $('#host_activation').val();
	var $activation_key   = $('#activation_key').val();
	var $verification_key = $('#verification_key').val();

	// Verify
	if (/posttypes/.test($target_table) || /sites/.test($target_table) || /languages/.test($target_table))
	{
		$.ajax({
			type : 'GET',
			url  : $host_activation + '/ajax/verify.php',
			data : {
				activation_key   : $activation_key,
				verification_key : $verification_key
			},
			dataType : 'json',
			success  : function(data){
				if (data.result != 1)
				{
					location.href = './_logout.php';
				}
			}
		});
	}

	// Allow Delete Action
	$('#allow_delete').click(function()
	{
		var $target_name = $(this).attr('data-target_name');
		if ($('#allow_delete:checked').val())
		{
			alert(TXT_EDITHIERARCHY_ALT_DELETE($target_name));
			$('#do_delete').css({display: 'inline'});
			$('#do_update').css({display: 'none'});
			$('#process').val(9);
		}
		else {
			$('#do_delete').css({display: 'none'});
			$('#do_update').css({display: 'inline'});
			$('#process').val(2);
		}
	});

	// Do Delete
	// Change process
//	$('#do_delete').hover(function()
//	{
//		$('#process').val(9);
//	},
//	function ()
//	{
//		$('#process').val(2);
//	});
	// Remove delete-target from posts
	$('#do_delete').on('click', function()
	{
		$target_id = $('#update_id').val();
		$page      = $('form').attr('id');
		// category
		if ($page == 'category')
		{
			$.ajax({
				url: './ajax/remove_category.php',
				dataType: 'json',
				type: 'GET',
				data: {
					'target_id' : $target_id,
				},
				success  : function(data){
					$('#category').submit();
				}
		    });
		}
		// tag
		else if ($page == 'tag')
		{
			$.ajax({
				url: './ajax/remove_tag.php',
				dataType: 'json',
				type: 'GET',
				data: {
					'target_id' : $target_id,
				},
				success  : function(data){
					$('#tag').submit();
				}
		    });
		}
		// site
		else if ($page == 'site')
		{
			$.ajax({
				url: './ajax/remove_site.php',
				dataType: 'json',
				type: 'GET',
				data: {
					'target_id' : $target_id,
				},
				success  : function(data){
					$('#site').submit();
				}
		    });
		}
		else {
			$('#' + $page).submit();
		}
	});

	// Draggable Table
	$('.sortable').sortable(
	{
		stop: function()
		{
			$target_table    = $(this).attr('data-target_table');
			var $line_orders = new Array();
			$(' > tr', this).each(function()
			{
				var $id = $('td:first-child', this).text();
				$line_orders.push($id);
			});
			$.ajax({
		        url: './ajax/change_order.php',
		        dataType: 'json',
		        type: 'GET',
		        data: {
		        	'target_table' : $target_table,
		            'line_orders'  : $line_orders
		        },
		        success  : function(data)
				{
		        	// Reload when site or posttype
					if (data.result == 1 && (/posttypes/.test($target_table) || /sites/.test($target_table) || /languages/.test($target_table)))
					{
						location.href = '?change=1';
					}
				}
		    });
		}
	});

	// CSS Reset
	$('.form-group').css({marginBottom: 0});

});