/*
 * Global Variables
 * ------------------------------------------------------------------------------------------------ */
// For Judge Update
var $update_flg = 0; // pre judge
var $execute_update_flg = 0; // main judge

// For Auto Save
var $auto_save_flg  = 0;
var $allow_save_flg = 1;

// For Images
var $check_eyecatch       = 0; // to change eyecatch-image timely.
var $check_custom_image   = 0; // to change custom-image timely.
var $check_custom_gallery = 0; // to change custom-gallery timely.

// For Fullscreen Adjust of tinymce
var $window_height              = window.innerHeight;
var $fullscreen_toolbars_height = 108; // 108 may be compromise value
var $fullscreen_height_adjust   = 0;
var $target_iframe              = {};

/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function ()
{
	/*
	 * Common Process
	 * ------------------------------------------------------------------------------------------------ */

	// Adjust Fullscreen height of tinymce when use multilingual
	$('.languageTab').on('click', function()
	{
		$fullscreen_height_adjust = 1;
		var $target_id = $(this).attr('id');
		var $target_num = $target_id.replace('language_tab_', '');
		var $target_iframe_id = 'content_' + $target_num + '_ifr';
		$target_iframe = $('#' + $target_iframe_id);
		$iframe_docment = $target_iframe[0].contentWindow.document;
		$('body').on('click', function()
		{
			if ($fullscreen_height_adjust == 1 && $('html').hasClass('mce-fullscreen'))
			{
				var $fullscreen_height = $window_height - $fullscreen_toolbars_height;
				$target_iframe.attr('style', 'width: 100%; height: ' + $fullscreen_height + 'px; display: block');
				$fullscreen_height_adjust = 0;
			}
		});
	});
	$('body').on('click', function()
	{
		if ($fullscreen_height_adjust == 0 && ! $('html').hasClass('mce-fullscreen'))
		{
			$fullscreen_height_adjust = 1;
		}
	});


	// Auto Save Status
	$auto_save_flg = parseInt($('#content').attr('data-auto_save_flg'));

	// Edit Controll
	var $editable_flg = $('#content').attr('data-editable_flg');
	if ($editable_flg == 0)
	{
		$auto_save_flg = 0;
		$('form input, form textarea').prop('disabled', true);
		$('form a').not('.goComments').remove();
		$('form button').remove();
		$('#save_post, #post_allow_delete_label').remove();
	}

	// Alert When not Save Update
	$('a').not('.notLink').on('click', function()
	{
		if ($update_flg == 1)
		{
			if(! window.confirm(TXT_POST_ALT_NOSAVE))
			{
				return false;
			}
		}
	});

	$('textarea').keydown(function(e)
	{
		if (e.keyCode === 9)
		{
    		e.preventDefault();
    		var elem = e.target;
    		var val = elem.value;
    		var pos = elem.selectionStart;
   			elem.value = val.substr(0, pos) + '\t' + val.substr(pos, val.length);
    		elem.setSelectionRange(pos + 1, pos + 1);
		}
	});



	// When Type Text (Auto Save On)
	if ($auto_save_flg)
	{
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
		$('input, textarea').not('#publish_datetime').keyup(function(e)
		{
			$update_flg = 1;
			delay(function() {
				saveArticle();
				$('#publish_post').removeClass('hidden');
			}, 1000 );
		});
		$('input, textarea, select').not('#publish_datetime, #post_allow_delete, #version_allow_delete').on('change', function()
		{
			$update_flg = 1;
			saveArticle();
			$('#publish_post').removeClass('hidden');
		});
	}
	// When Type Text (Auto Save Off)
	else {
		$('input, textarea').keyup(function(e)
		{
			// common
			$update_flg = 1;
			var delay = (function(){
				var timer = 0;
				return function(callback, ms){
					clearTimeout (timer);
					timer = setTimeout(callback, ms);
				};
			})();
			delay(function() {
				$('#publish_post').removeClass('hidden');
			}, 1000 );
		});
		$('input, textarea, select').on('change', function()
		{
			$update_flg = 1;
			$('#publish_post').removeClass('hidden');
		});
	}

	// Syntax highlighte
	$('.syntax').each(function(e)
	{
		var $target_syntax = $(this).attr('data-target_syntax');
		var $syntax_type = $(this).attr('data-syntax_type');
		var $raw_code = $(this).val();
		var $editor = $(this).attr('id');
		formatSyntax($target_syntax, $syntax_type, $raw_code, $editor);
	});
	$('.syntax').keydown(function(e)
	{
		// only syntax
		if(e.shiftKey)
		{
			if (e.keyCode == 13 && $(this).hasClass('syntax'))
			{
				var $target_syntax = $(this).attr('data-target_syntax');
				var $syntax_type = $(this).attr('data-syntax_type');
				var $raw_code = $(this).val();
				var $editor = $(this).attr('id');
				var delay_syntax = (function(){
					var timer = 0;
					return function(callback, ms){
						clearTimeout (timer);
						timer = setTimeout(callback, ms);
					};
				})();
				delay_syntax(function()
				{
					formatSyntax($target_syntax, $syntax_type, $raw_code, $editor);
				},
				0);
				return false;
			}
		}
	});

	// When Click Button
	$('button').not('.justButton').on('click', function()
	{
		$update_flg = 1;
		$('#publish_post').removeClass('hidden');
	});

	// Text Tab Default On
	$('#textTab a:first').tab('show');

	// language tab
	$('#textTab li').on('click', function(){
		var $target_class = '.formPartsLang_' + $(this).attr('data-target_lang');
		$('.formHasLang span').addClass('hidden');
		$($target_class).removeClass('hidden');
		$('.mce-edit-area').css({minHeight: '480px'});
		$('iframe').css({height: '480px'});
	});

	// Datetimepicker On
	$('#publish_datetime, .customDateTime').datetimepicker(
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
	$('.customDate').datetimepicker(
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
  $('.customTime').datetimepicker(
    {
      format: 'hh:ii',
      startView: 1,
      maxView: 2,
      minView: 0,
      language: getCookie('lang'),
      autoclose: true,
      todayHighlight: true,
      todayBtn: true,
	});

	// Valid datetime
	runValidDatetime($('#publish_datetime'));
	$('#publish_datetime').on('change', function()
	{
		var $valid_datetime = runValidDatetime($('#publish_datetime'));
		if ($valid_datetime == 1)
		{
			$update_flg = 1;
			if ($auto_save_flg == 1) saveArticle();
			$('#publish_post').removeClass('hidden');
		}
	});

	// Load Images
	loadEyecatch();
	loadCustomImage();
	loadCustomGallery();

	// Save Article
	$('#save_post').on('click', function()
	{
		saveArticle();
	});

	// Save Article and close
	$('.changeStatusClose').on('click', function()
	{
		var $target_status = $(this).attr('data-status');
		saveArticle($target_status);
	});

	// Sortable Gallery
	$('.sortable').sortable({
		stop: function(event, ui){
			loadCustomGallery();
			if ($auto_save_flg) saveArticle();
		}
	});

	// Remove Image From Gallery
	$('#trash').droppable({
		hoverClass: "custom_gallery_trash_on",
	    drop: function(event, ui) {
	    	ui.draggable.remove();
	    },
	});

	// Operate Anchor
	$('#anchor_minus').on('click', function(){
		var $anchor = parseInt($('#anchor').val());
		if ($anchor > 0){
			$('#anchor').val($anchor - 1);
		}
		if ($auto_save_flg) saveArticle();
	});
	$('#anchor_plus').on('click', function(){
		var $anchor = parseInt($('#anchor').val());
		$('#anchor').val($anchor + 1);
		if ($auto_save_flg) saveArticle();
	});

	// Delete button
	$('#post_allow_delete').click(function()
	{
		if ($('#post_allow_delete:checked').val()){
			$('#delete_post').css({display: 'inline'});
			$('#publish_post').css({display: 'none'});
			$('#process').val('19');
			alert(TXT_POST_ALT_DELETEBUTTON);
		}
		else {
			$('#delete_post').css({display: 'none'});
			$('#publish_post').css({display: 'inline'});
			$('#process').val('12');
		}
	});

	// Delete button
	$('#version_allow_delete').on('click', function()
	{
		$('.version-delete').toggleClass('active');

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

	// Refresh Image (with auto save)
	$('#content').on('touchstart, mouseover', function(){
		// eyecatch
		if ($check_eyecatch == 0)
		{
			$update_flg = 1;
			loadEyecatch();
			if ($auto_save_flg) saveArticle();
			$('#publish_post').removeClass('hidden');
		}
		// custom image
		if ($check_custom_image == 0)
		{
			$update_flg = 1;
			loadCustomImage();
			if ($auto_save_flg) saveArticle();
			$('#publish_post').removeClass('hidden');
		}
		// custom gallery
		if ($check_custom_gallery == 0)
		{
			$update_flg = 1;
			loadCustomGallery('add');
			if ($auto_save_flg) saveArticle();
			$('#publish_post').removeClass('hidden');
			$('.custom_gallery_addition').val('');
		}
	});

	// Prepare Set Image
	// eyecatch
	$('#set_eyecatch, #eyecatch').on('click', function(){
		$check_eyecatch = 0;
	});
	// custom image
	$('.set_custom_image').on('click', function(){
		$check_custom_image = 0;
	});
	// custom gallery
	$('.set_custom_gallery').on('click', function(){
		$check_custom_gallery = 0;
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
		if ($auto_save_flg) saveArticle();
	});
	// custom image
	$('.remove_custom_image').on('click', function(){
		$(this).addClass('hidden');
		$parent_id = '#' + $(this).parent('div').attr('id');
		$($parent_id + ' .custom_image').val('');
		$($parent_id + ' img').animate({opacity: 0}, 200);
		setTimeout(function(){
			$($parent_id + ' img').slideUp(200);
		}, 300);
		if ($auto_save_flg) saveArticle();
	});
	// custom gallery
	$('.remove_custom_gallery').on('click', function(){
		if (confirm(TXT_POST_CFM_DELETE_GALLERY)) {
			$(this).addClass('hidden');
			$parent_id = '#' + $(this).parent('div').attr('id');
			$($parent_id + ' .custom_gallery').val('');
			$($parent_id + ' .custom_gallery_display').animate({opacity: 0}, 200);
			setTimeout(function(){
				$($parent_id + ' .custom_gallery_display').slideUp(200);
				$($parent_id + ' .custom_gallery_trash').hide();
				$($parent_id + ' ul').html('');
			}, 300);
			if ($auto_save_flg) saveArticle();
		}
	});

});


/*
 * Functions
 * ------------------------------------------------------------------------------------------------ */
/**
 * Load Custom Image
 */
function loadCustomImage()
{
	$check_custom_image = 1;
	$('.custome_image_container').each(function(){
		var $custome_image_target = '/upload/' + $('.custom_image_target', this).val() + '/';
		var $src = $('.custom_image', this).val();
		if ($src != ''){
			$('.custom_image_wrap figure', this).remove();
			if ($src.indexOf('.pdf') != -1)
			{
				var $this_object = $('.custom_image_wrap', this);
				var $src_arr   = $src.split('/');
				var $uri       = $src_arr[$src_arr.length - 1];
				var $uri_arr   = $uri.split('?');
				var $file_name = $uri_arr[0];
				var $file_size = 0;
				$.ajax({
					url: 'ajax/get_filesize.php',
					type: 'post',
					data: {
						uri: $src,
						unit: 'k'
					},
					dataType: 'json',
					async: false,
				}).done(function ($responce)
				{
					if ($responce['result'] == '1')
					{
						$file_size = $responce['filesize'];
						$this_object.prepend('<figure><img class="thumbnail" src="img/pdf_small.png"><figcaption>' + $file_name + ' (' + $file_size + 'KB)' + '</figcaption></figure>');
					}
				});
			}
			else {
				$src = $src.replace('/upload/fr_main/', $custome_image_target);
				$('.custom_image_wrap', this).prepend('<figure><img class="thumbnail" src="' + $src + '"></figure>');
			}
			$('.remove_custom_image', this).removeClass('hidden');
			$('.custom_image', this).val($src);
		}
		else {
			$('.custom_image_wrap figure', this).remove();
		}
	});
}


/**
 * Load Custom Gallery
 */
function loadCustomGallery($process)
{
	$check_custom_gallery = 1;
	$('.custome_gallery_container').each(function(){
		if ($process == 'add'){
			var $custome_gallery_target = '/upload/' + $('.custom_gallery_target', this).val() + '/';
			var $src = $('.custom_gallery_addition', this).val().replace('/upload/fr_main/', $custome_gallery_target);
			if ($src != ''){
				$('.custom_gallery_display ul', this).append('<li class="col-xs-6 col-md-3"><img class="thumbnail" src="' + $src + '" alt=""></li>');
			}
		}
		var $custom_gallery_value = '';
		$('.custom_gallery_display li', this).each(function(){
			if ($custom_gallery_value == ''){
				$custom_gallery_value = $('img', this).attr('src');
			}
			else {
				$custom_gallery_value += ',' + $('img', this).attr('src');
			}
		});
		$('.custom_gallery', this).val($custom_gallery_value);
		if ($custom_gallery_value){
			$('.remove_custom_gallery', this).removeClass('hidden');
			$('.custom_gallery_display', this).css({display: 'block', opacity: 1});
			$('.custom_gallery_trash', this).css({display: 'block', opacity: 1});
		}
		else {
			$('.remove_custom_gallery', this).addClass('hidden');
			$('.custom_gallery_display', this).css({display: 'none', opacity: 0});
			$('.custom_gallery_trash', this).css({display: 'none', opacity: 0});
		}
	});
}

/**
 * Execute delete
 */
function deletePost($delete_message)
{
	if (! window.confirm($delete_message))
	{
		$('#delete_post').css({display: 'none'});
		$('#publish_post').css({display: 'inline'});
		$('#process').val('12');
		$('#post_allow_delete').prop('checked',false);

		return false;
	}
}


/**
 * Format Syntax code
 */
function formatSyntax($target_syntax, $syntax_type, $raw_code, $editor)
{
	var $code_class = '';
	var $formatted_code = null;
	var $frame_head = '<pre class="line-numbers"><code class="language-' + $syntax_type + '">';
	var $frame_bottom = '</code></pre><script src="plugin/prism/prism.js"></script>';
	var $note_operation = TXT_POST_MSG_SYNTAX;

	$.ajax({
		type : 'POST',
		url  : './ajax/format_syntax.php',
		data : {
			raw_code   : $raw_code,
			code_class : $code_class,
		},
		dataType : 'json',
		success  : function(data)
		{
			if (data.result == '1')
			{
				$formatted_code = data.formatted_code;
				$html = $frame_head + $formatted_code + $frame_bottom;
				$('#'+ $target_syntax).html($html);
				var $syntax_height = $('#'+ $target_syntax + ' > pre').innerHeight();
				$('#' + $editor).css({height: $syntax_height});
				return false;
			}
			else
			{
				$html = $frame_head + $note_operation + $frame_bottom;
				$('#'+ $target_syntax).html($html);
				return false;
			}
		}
	});
}


/**
 * Save post data on RealTime
 */
function saveArticle($designated_status)
{
	if ($execute_update_flg)
	{
		return false;
	}
	else {
		// Set execute flg
		$execute_update_flg = 1;

		// Set Status
		if($designated_status == undefined)
		{
			$designated_status = false;
	    }
		else {
			$('input[name=status]').val([$designated_status]);
		}

		// Button and Message controll
		$('#save_post').html('<i class="fa fa-spin fa-circle-o-notch"></i>').attr('disabled', true);
		//$('#save_message:not(:animated)').animate({opacity: 0.7}, 300);

		// Default items
		var $title = {};
		$('[data-group="title"]').each(function(){
			$title[$(this).attr('data-num')] = $(this).val();
		});
		var $addition = {};
		$('[data-group="addition"]').each(function(){
			$addition[$(this).attr('data-num')] = $(this).val();
		});
		var $categories = [];
		$('[name="categories[]"]:checked').each(function(){
			$categories.push($(this).val());
		});
		var $tags = [];
		$('[name="tags[]"]:checked').each(function(){
			$tags.push($(this).val());
		});
		var $content = {};
		var $judge_flg_wisiwyg = $('#judge_flg_wisiwyg').val();
		$('[data-group="content"]').each(function()
		{
			if ($judge_flg_wisiwyg == '1')
			{
				$tinymce_id = $(this).attr('id');
				$content[$(this).attr('data-num')] = tinyMCE.get($tinymce_id).getContent();
			}
			else {
				$content[$(this).attr('data-num')] = $(this).val();
			}
		});
		var $version          = $('#version').val();
		var $versioned_at     = $('#versioned_at').val();
		var $current_flg      = $('#current_flg').val();
		var $publish_datetime = $('#publish_datetime').val();
		var $anchor           = $('#anchor').val();
		var $target_id        = $('#target_id').val();
		var $process          = $('#process').val();
		var $site_id          = $('#site_id').val();
		var $posttype_id      = $('#posttype_id').val();
		var $parent_id        = $('#parent_id').val();
		var $status           = ($designated_status == false) ? $('input[name=status]:checked').val() : $designated_status;
		var $slug             = $('#slug').val();
		var $eyecatch         = $('#eyecatch').val();

		// Custom items
		var $items = {};
		$('[data-group="custom"]').each(function()
		{
			var $language_id    = $(this).attr('data-language_id');
			var $custom_item_id = $(this).attr('data-custom_item_id');
			var $type           = $(this).attr('type');
			if ($type == 'checkbox' || $type == 'radio')
			{
				if ($(this).is(':checked'))
				{
					if (! $items[$custom_item_id]) $items[$custom_item_id] = {};
					if (! $items[$custom_item_id][$language_id]) $items[$custom_item_id][$language_id] = [];
					$items[$custom_item_id][$language_id].push($(this).val());
				}
			}
			else {
				if (! $items[$custom_item_id]) $items[$custom_item_id] = {};
				$items[$custom_item_id][$language_id] = $(this).val();
			}
		});

		// For multipage
		var $use_multipage_flg   = $('#use_multipage_flg').val();
		var $this_posttype       = $('#this_posttype').val();
		var $this_posttype_order = $('#this_posttype_order').val();

		$.ajax({
			type : 'POST',
			url  : './ajax/save_post.php',
			data : {
				version          : $version,
				versioned_at     : $versioned_at,
				current_flg      : $current_flg,
				publish_datetime : $publish_datetime,
				anchor           : $anchor,
				target_id        : $target_id,
				site_id          : $site_id,
				posttype_id      : $posttype_id,
				parent_id        : $parent_id,
				eyecatch         : $eyecatch,
				slug             : $slug,
				categories       : $categories,
				tags             : $tags,
				status           : $status,
				title            : $title,
				addition         : $addition,
				content          : $content,
				items            : $items,
			},
			dataType : 'json',
			success  : function(data)
			{
				if (data.process == 'created')
				{
					$('#target_id').val(data.target_id);
					$('#process').val(12);
					$('#publish_post').removeClass('hidden');
					$('h3.panel-title').append('<span class="label label-primary">ID ' + data.target_id + '</span>');

					if ($use_multipage_flg == 1)
					{
						$('.panel-right').append('<a href="./?this_posttype=' + $this_posttype + '&amp;this_posttype_order=' + $this_posttype_order + '&amp;process=11&amp;parent_id=' + data.target_id + '&amp;version=1&amp;current_flg=1"><i class="fa fa-plus-square-o" aria-hidden="true"></i> ' + TXT_POST_LBL_NEWPAGE + '</a>');
					}
				}
				setTimeout(function()
				{
					//$('#save_message:not(:animated)').animate({opacity: 0}, 600);
					$('#save_post').html(TXT_POST_MSG_SAVE).attr('disabled', false);;
					$update_flg = 0;
					$execute_update_flg = 0;
				}, 1000);

				if ($designated_status != false)
				{
					if ($parent_id == 0)
					{
						location.href = './?view_page=posts&process=' + $process + '&id=' + $target_id + '&number=1';
					}
					else {
						$process = 12;
						location.href = './?id=' + $parent_id + '&version=1&process=' + $process + '&child_process=12';
					}
				}
			}
		});
	}
}


/**
 * Create New Version Post
 */
function createNewVersionPost($target_id, $version)
{
	$.ajax({
		type : 'POST',
		url  : './ajax/create_new_version_post.php',
		data : {
			target_id : $target_id,
			version   : $version,
		},
		dataType : 'json',
		success  : function($data)
		{
			if ($data.result == '1')
			{
				location.href = '?id=' + $target_id + '&version=' + $data.new_version + '&process=12';
			}
		}
	});
}


/**
 * Change Current Version
 */
function changeCurrentPost($target_id, $new_current_version)
{
	$.ajax({
		type : 'POST',
		url  : './ajax/change_current_post.php',
		data : {
			target_id           : $target_id,
			new_current_version : $new_current_version,
		},
		dataType : 'json',
		success  : function($data)
		{
			if ($data.result == '1')
			{
				location.href = '?id=' + $target_id + '&version=' + $new_current_version + '&process=12';
			}
		}
	});
}


/**
 * Delete Version
 */
function deleteVersionPost($target_id, $version)
{
	var $current_version = $('#current_version').val();

	if (window.confirm(TXT_POST_CFM_DELETE))
	{
		$.ajax({
			type : 'POST',
			url  : './ajax/delete_version_post.php',
			data : {
				target_id : $target_id,
				version   : $version,
			},
			dataType : 'json',
			success  : function($data)
			{
				if ($data.result == '1')
				{
					location.href = '?id=' + $target_id + '&version=' + $current_version + '&process=12';
				}
			}
		});
	}
}



