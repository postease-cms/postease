/*
 * Global Variables
 * ------------------------------------------------------------------------------------------------ */
// For Images
var $cover_image_num = 0;


/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function ()
{
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
	$('#content').on('touchstart, mouseover', function()
	{
		if ($cover_image_num > 0)
		{
			changeCoverImage($cover_image_num);
			$cover_image_num = 0;
		}

	});

	// Prepare Set Image
	$('.set_cover_image').on('click', function()
	{
		$cover_image_num = $('.set_cover_image').index(this) + 1;
	});

	// Prepare Delete Image
	$('.delete_cover_image').on('click', function()
	{
		var $target_container = $(this).parents('.cover_image_container');
		var $entity_code   = $target_container.attr('data-entity_code');
		var $entity_id        = $target_container.attr('data-entity_id');
		deleteCover($entity_code, $entity_id);
	});

	// Remove Image
	$('.remove_custom_image').on('click', function()
	{
		$(this).addClass('hidden');
		$parent_id = '#' + $(this).parent('div').attr('id');
		$($parent_id + ' .custom_image').val('');
		$($parent_id + ' img').animate({opacity: 0}, 200);
		setTimeout(function()
		{
			$($parent_id + ' img').slideUp(200);
		}, 300);
	});

	// Adjust image-height
	var $current_max_height = 0;
	$('.cover_image_wrap').each(function()
	{
		var $this_height = $(this).innerHeight();
		if ($this_height > $current_max_height)
		{
			$current_max_height = $this_height;
		}
	});
	$('.cover_image_wrap').innerHeight($current_max_height);

});



function changeCoverImage($cover_image_num)
{
	var $target_container = $('.cover_image_container:nth-of-type(' + $cover_image_num + ')');
	var $covere_image_target = '/upload/' + $('#cover_image_target').val() + '/';
	var $src = $('.cover_image', $target_container).val().replace('/upload/fr_main/', $covere_image_target);
	if ($src != '')
	{
		$('.cover_image_operation i', $target_container).remove();
		$('.cover_image_wrap img', $target_container).remove();
		$('.cover_image_wrap', $target_container).prepend('<img class="cover_image_established" src="' + $src + '">');
		$('.remove_cover_image', $target_container).removeClass('hidden');
		$('.cover_image', $target_container).val($src);

		var $entity_code = $target_container.attr('data-entity_code');
		var $entity_id      = $target_container.attr('data-entity_id');
		saveCover($entity_code, $entity_id, $src);
	}
}


function saveCover($entity_code, $entity_id, $cover_image)
{
	$.ajax({
		type : 'POST',
		url  : './ajax/save_cover.php',
		data : {
			entity_code : $entity_code,
			entity_id      : $entity_id,
			cover_image    : $cover_image,
		},
		dataType : 'json',
		success  : function(data)
		{
			if (data.result == 1)
			{
				$('#delete_' + $entity_id).removeClass('hidden');
				$('#cover_image_operation_' + $entity_id).prepend('<i class="iconAdded opacity0 fa fa-check-circle" aria-hidden="true"></i>');
			}
			setTimeout(function()
			{
				$('#cover_image_operation_' + $entity_id + ' i').animate({opacity: 1}, 600);
			},
			100);
		}
	});
}


function deleteCover($entity_code, $entity_id)
{
	$('#cover_image_operation_'+ $entity_id + ' i').remove();

	$.ajax({
		type : 'POST',
		url  : './ajax/delete_cover.php',
		data : {
			entity_code : $entity_code,
			entity_id      : $entity_id,
		},
		dataType : 'json',
		success  : function(data)
		{
			if (data.result == 1)
			{
				$('#delete_' + $entity_id).addClass('hidden');
				$('#cover_image_wrap_'+ $entity_id + ' img.cover_image_established').animate({opacity: 0}, 600, function(){
					$('#cover_image_wrap_'+ $entity_id + ' img.cover_image_established').remove();
					$('#cover_image_wrap_'+ $entity_id).append('<img src="img/noimage.png" alt="*">');
				});
				$('#cover_image_operation_' + $entity_id).append('<i class="iconDeleted opacity0 fa fa-check-circle" aria-hidden="true"></i>');
			}
			setTimeout(function()
			{
				$('#cover_image_operation_' + $entity_id + ' i').animate({opacity: 1}, 600);
			},
			100);
		}
	});
}