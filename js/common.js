/*
 * Global Variables
 * ------------------------------------------------------------------------------------------------ */
var $this_file = getPage();


/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function()
{
	/*
	 * Settings
	 * ------------------------------------------------------------------------------------------------ */
	// remove dotted-line of 'a'
	$('a').bind('focus', function(){
		if(this.blur)this.blur();
	});

	// Select2
	$('select').select2().css({
		borderRadius: 0,
	});


	/*
	 * Common Process
	 * ------------------------------------------------------------------------------------------------ */
	// Slow Show All Contents
	setTimeout(function(){
		$('.slow-show').animate({opacity: 1}, 300);
	}, 100);

	// Prohibit enter-key submit
	if ($this_file != 'posts' && $this_file != 'contacts' && $this_file != 'comments')
	{
		$('input').on('keydown', function(e)
		{
			if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13))
			{
				return false;
			}
			else {
				return true;
			}
		});
	}

	// Process Msg
	$(document).on('click keydown', function()
	{
		$('.processDone').animate({opacity: 0}, 300);
		$('.processDone').slideUp(200);
	});

	// Tab Menu
	$('.nav-tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	// Popover
	$('[data-toggle="popover"]').popover({
		'trigger': 'hover',
		'container': 'body',
		'placement': 'right',
	});

	// Tooltip
	$('[data-toggle="tooltip"]').tooltip();


	/*
	 * Menu Action
	 * ------------------------------------------------------------------------------------------------ */
	// menu action 1
	$('#main_menu li.pointer').on('click', function(){
		$('#main_menu li.pointer').removeClass('back-gray');
		$(this).addClass('back-gray');
		$('li.pointer div.list-group').addClass('hidden');
		$('div.list-group', this).removeClass('hidden');
	});

	// menu action 2
	$('#main_menu a.list-group-item').on('click', function(){
		$('#main_menu a.list-group-item').removeClass('active');
		$(this).addClass('active');
		$(this).parent().addClass('opened');
		$(this).parent().parent().on().removeClass('pointer');
	});

	// manu action 3
	$(document).click(function(event) {
	    if (!$.contains($("#main_menu")[0], event.target)) {
	    	$('li.list-group-item').not('.opened').removeClass('back-gray');
	    	$('div.list-group:not(.opened div.list-group)').addClass('hidden');
	    }
	});


	/*
	 * CSS Fix
	 * ------------------------------------------------------------------------------------------------ */
	$('.checkbox-inline, .radio-inline').css({marginLeft: '2px', marginRight: '8px'});
	$('.checkbox-inline input, .radio-inline input').css({marginTop: '3px'});
	$('.tab-content').css({padding: '10px 5px'});
	// fix nav-bar height
	$navbar_height = ($('.navbar-fixed-top').outerHeight(true));
	$('body').css({paddingTop: $navbar_height + 'px'});
	$('.navbar-fixed-top').css({zIndex: 99});
	$('#post .radio-inline, #contact .radio-inline').css({marginBottom: '2px'});
  $('.select2').css({width: '100%'});


	/*
	 * Input validation
	 * ------------------------------------------------------------------------------------------------ */
	$('.needValidation').each(function()
	{
		runValidOneCommon($(this), $('#do_update'));
	});
	$('.needValidation').keyup(function()
	{
		runValidOneCommon($(this), $('#do_update'));
	});

});


/*
 * User Functions
 * ------------------------------------------------------------------------------------------------ */
function naviAction()
{
	var page = $('body').attr('id');
	if (page != 0)
	{
		page = page.split('-');
		var page_main = '#main_menu li.list-group-item:nth-of-type(' + page[0] + ')';
		var page_sub = page_main + ' a.list-group-item:nth-of-type(' + page[1] + ')';
		$(page_main).addClass('back-gray').removeClass('pointer');
		$(page_main + ' > div.list-group').removeClass('hidden');
		$(page_sub).addClass('active');
	}
}





function getFileName()
{
	var $file_name = window.location.href.match(".+/(.+?)\.[a-z]+([\?#;].*)?$")[1];
	if ($file_name)
	{
		return $file_name;
	}
	return false;
}

function validOne($string, $type)
{
	var $regex =
	{
			account   : /^([a-z]{1}[a-z0-9_]{2,31})$/,
			slug      : /^([a-z]{1}[a-z0-9_]{0,31})$/,
			password  : /^[a-zA-Z0-9_!@#$%&+?]{6,32}$/,
			prefix    : /^[a-z]{2,8}[_]$/,
			activation_key    : /^[A-Z]{4}[-][0-9]{4}[-][0-9]{4}[-][0-9]{4}[-][A-Z]{4}$/,
			imagesize : /^[0-9]{1,4}$/,
			datetime  : /^[1-3]{1}[0-9]{3}[-](0[1-9]{1}|1[1-2]{1})[-](0[1-9]{1}|[1-2]{1}[1-9]{1}|30|31) ([0-1]{1}[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}$/,
	};
	if ($regex[$type].test($string))
	{
		return true;
	}
	return false;
}

function runValidOneCommon($target, $submit_target)
{
	var $type = $target.attr('data-valid_type');
	var $submit_button = $submit_target;
	if ($target.val() != '' && validOne($target.val(), $type))
	{
		$target.parent().removeClass('has-error');
		$target.parent().addClass('has-success');
		$target.closest('.form-group').find('.invalidIcon').addClass('hidden');
		$target.closest('.form-group').find('.validIcon').removeClass('hidden');
		$submit_button.removeClass('hidden');
	}
	else if ($target.val() != '' && ! validOne($target.val(), $type))
	{
		$target.parent().removeClass('has-success');
		$target.parent().addClass('has-error');
		$target.closest('.form-group').find('.validIcon').addClass('hidden');
		$target.closest('.form-group').find('.invalidIcon').removeClass('hidden');
		$submit_button.addClass('hidden');
	}
	else {
		$target.parent().removeClass('has-success');
		$target.parent().removeClass('has-error');
		$target.closest('.form-group').find('.validIcon').addClass('hidden');
		$target.closest('.form-group').find('.invalidIcon').addClass('hidden');
		$submit_button.removeClass('hidden');
	}
}

function getCookie($cookie_name)
{
	$cookie_name += '=';
	var $this_cookie = document.cookie + ';';
	var $start = $this_cookie.indexOf($cookie_name);
	if ($start != -1)
	{
		var $end = $this_cookie.indexOf(';', $start);
		return unescape($this_cookie.substring($start + $cookie_name.length, $end));
	}
	return false;
}

function validDatetime($datetime)
{
	if ($datetime)
	{
		var $date_time_arr = $datetime.split(' ');
		var $date_arr = ($date_time_arr[0]) ? $date_time_arr[0].split('-') : '';
		var $time_arr = ($date_time_arr[1]) ? $date_time_arr[1].split(':') : '';

		var $year   = ($date_arr[0]) ? $date_arr[0] : '';
		var $month  = ($date_arr[1]) ? $date_arr[1] : '';
		var $day    = ($date_arr[2]) ? $date_arr[2] : '';
		var $hour   = ($time_arr[0]) ? $time_arr[0] : '';
		var $minute = ($time_arr[1]) ? $time_arr[1] : '';
		if ($year && $month && $day && $hour && $minute)
		{
			var $nd = new Date($year, $month - 1, $day);
			if ($nd.getFullYear() == $year && $nd.getMonth() == $month - 1 && $nd.getDate() == $day)
			{
				if (parseInt($hour, 10) >= 0 && parseInt($hour, 10) < 24 && parseInt($minute, 10) >= 0 && parseInt($minute, 10) < 60)
				{
					return true;
				}
			}
		}
	}
	return false;
}

function runValidDatetime($target)
{
	var $value = $($target).val();
	if ($($target).val() != '' && validDatetime($value))
	{
		$($target).parent().removeClass('has-error');
		$($target).closest('.form-group').find('.invalidIcon').addClass('hidden');
		return 1;
	}
	else if ($($target).val() != '' && ! validDatetime($value))
	{
		$($target).parent().addClass('has-error');
		$($target).closest('.form-group').find('.invalidIcon').removeClass('hidden');
		return 0;
	}
	else {
		$($target).parent().removeClass('has-error');
		$($target).closest('.form-group').find('.invalidIcon').addClass('hidden');
		return 0;
	}
	return 0;
}


/*
 * jQuery-extended Functions
 * ------------------------------------------------------------------------------------------------ */
$.fn.hasAttr = function(attrName)
{
	var result = false;
	if (attrName && attrName !== '')
	{
		var attrValue = $(this).attr(attrName);
		if (typeof attrValue !== 'undefined' && attrValue !== false)
		{
			result = true;
		}
	}
	return result;
};
