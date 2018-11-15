/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function(){

	$max_height = 0;
	$('.summaryMenu').each(function ()
	{
		if ($(this).height() > $max_height)
		{
			$max_height = $(this).height();
		}
	});
	setTimeout(function ()
	{
		$('.summaryMenu').height($max_height - 20);
	},10);


	// CSS fix
	$('.table').css({marginBottom: 0});
	$('.table th, .table td').css({borderBottom: '1px solid #ddd', borderTop: 0});
	$('.table tr:last-child th, .table tr:last-child td').css({borderBottom: 0});

	// Check Update
	var $update_allowed_role   = Number($('#update_allowed_role').val());
	var $allow_update_flg      = Number($('#allow_update_flg').val());
	var $host_activation       = $('#host_activation').val();
	var $check_update_level    = $('#check_update_level').val();;
	var $this_postease_version = $('#this_postease_version').val();
	var $this_ip               = $('#this_ip').val();
  var $this_classification   = $('#this_classification').val();
	var $language              = $('#language').val();
	var $check_domain          = $('#check_domain').val();
  var $this_domain           = $('#this_domain').val();
  var $check_dir_name        = $('#check_dir_name').val();
  var $this_dir_name         = $('#this_dir_name').val();

	// Invalidate link
	$(document).on('click', '#refuse_update',  function()
	{
		$.ajax({
			type : 'GET',
			url  : './ajax/change_update_level.php',
			data : {
				update_level : 2,
			},
			dataType : 'json',
			success  : function(data){
				if (data.result == 1)
				{
					location.href = '';
				}
			},
		});
	});

	// Commit update (cleanup POSTEASEBAK files)
	if (getParam('commit'))
	{
		$.ajax({
			type : 'GET',
			url  : './ajax/commit_update.php',
			dataType : 'json',
			success  : function(data)
			{
				if (data.result == 1)
				{
					console.log('Update complete!');
					location.href = './?change=1';
				}
			},
		});
	}

	// Rollback update
	if (getParam('rollback'))
	{
		$.ajax({
			type : 'GET',
			url  : './ajax/rollback_update.php',
			dataType : 'json',
			success  : function(data)
			{
				if (data.result == 1)
				{
					console.log('Update canceled.');
					location.href = './';
				}
			},
		});
	}
	
	// Correct Domain
	if ($check_domain == '1')
	{
    $.ajax({
      type : 'GET',
      url  : './ajax/correct_domain.php',
      data : {
        domain : $this_domain,
      },
      dataType : 'json',
      success  : function(data)
      {
        if (data.result == 1)
        {
          console.log('Correct Domain complete!');
          location.href = './?view_page=index&change=1';
        }
      },
    });
	}
 
	// Correct Dir name
  if ($check_dir_name == '1')
  {
    $.ajax({
      type : 'GET',
      url  : './ajax/correct_dir_name.php',
      data : {
        dir_name : $this_dir_name,
      },
      dataType : 'json',
      success  : function(data)
      {
        if (data.result == 1)
        {
          console.log('Correct Dir name complete!');
          location.href = './?view_page=index&change=1';
        }
      },
    });
  }
  
  // Delete Request values
  if ($.cookie('requested_from'))   $.removeCookie('requested_from');
  if ($.cookie('onetime_password')) $.removeCookie('onetime_password');
  if ($.cookie('host_activation'))  $.removeCookie('host_activation');
  if ($.cookie('lang'))             $.removeCookie('lang');

	// Check update
	if ($update_allowed_role && $allow_update_flg)
	{
		setTimeout(function()
		{
			$.ajax({
				type : 'GET',
				url  : $host_activation + '/ajax/check_version.php',
				data : {
					this_ip               : $this_ip,
					this_classification   : $this_classification,
					level                 : $check_update_level,
					language              : $language,
					this_postease_version : $this_postease_version,
				},
				dataType : 'json',
				timeout : 5000,
				success  : function(data){
					if (data.result == 1 && data.update_level && data.update_detail && data.next_postease_version)
					{
						var $target_version = data.next_postease_version;
						var $update_level   = data.update_level;
						var $update_detail  = data.update_detail;
						var $update_url_description = (data.update_url_description) ? data.update_url_description : null;

						$('#warnings').append('<p id="notice_update" class="alert" id="notice_update"></p>');
						$('#notice_update').addClass(alert_class=($update_level<3) ? 'alert-success' : 'alert-info');
						$('#notice_update').text(TXT_UPDATE_INDEX_NOTICEUPDATE($update_level));
						$('#notice_update').append('&nbsp;&nbsp;<a id="execute_update" href="./?view_page=update&update_mode=1&update_level=' + $update_level + '"><i class="fa fa-external-link-square"></i> ' + TXT_INDEX_LNK_EXECUTEUPDATE + '</a>');
						$('#notice_update').slideDown(500).animate({opacity: 1}, 300);

						// for level 3
						if ($update_level == 3)
						{
							$('#execute_update').attr('onclick', "javascript:return confirm(\'" + TXT_INDEX_CNF_CONFIRMUPDATE + "\')");
							$('#notice_update').append('&nbsp;&nbsp;&nbsp;&nbsp;<a id="refuse_update"><i class="fa fa-ban"></i> ' + TXT_INDEX_LNK_REFUSEUPDATE + '</a>');
							$('#notice_update').slideDown(500).animate({opacity: 1}, 300);
						}

						// for level 2, 3
						if ($update_level == 2 && $update_detail)
						{
							$('#notice_update').append('<hr class="innerPanel"><i class="fa fa-info-circle"></i> ' + TXT_INDEX_LBL_VERSION + $target_version + '&nbsp;&nbsp;' + $update_detail);
							$('#notice_update').slideDown(500).animate({opacity: 1}, 300);
						}
						else if ($update_level == 3 && $update_detail && $update_url_description)
						{
							$('#notice_update').append('<hr class="innerPanel"><a id="detail_update" href="' + $update_url_description + '" target="_blank"><i class="fa fa-info-circle"></i> ' + TXT_INDEX_LBL_VERSION + $target_version + '&nbsp;&nbsp;' + $update_detail + '</a>');
							$('#notice_update').slideDown(500).animate({opacity: 1}, 300);
						}
					}
				},
			});
		}, 2000);
	}

});
