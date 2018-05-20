/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function(){

	$('.panel-body').hide();
	$('.panel-body:first').show();

	if ($target = getParam('target'))
	{
		$('.panel-body').hide();
		$('#panel_' + $target).show();
	}

	$('.panel-heading').click(function(e)
	{
		$('.panel-body').not($(this).next()).slideUp(300);
		$(this).next().slideToggle(300);
	});
	
	$('.iconList').each(function(index, e)
	{
		if (index)
		{
      $(this).hide();
		}
	})
	
	$('.iconListSeeMore > a').on('click', function()
	{
    $('.iconList').each(function(index, e)
    {
      if (index)
      {
        $(this).fadeToggle();
      }
    })
	})

});