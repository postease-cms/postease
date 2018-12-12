/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function () 
{
	generateRawUrl();
	generatePermalink();
	getRewriteRule();
	
	$('input[name=permalink_style]').on('click', function ()
	{
		$('#parameterSample').text('?post_key=' + $(this).data('parameter_key'));
		$('#permalinkKeySample').text('/' + $(this).data('sample'));
		if ($('#rewrite_url').val())
		{
			generatePermalink();
			getRewriteRule();
		}
		else if ($('#resource_url').val())
		{
			generateRawUrl();
		}
	});
	
	$('#resource_url, #rewrite_url, input[name=rewrite_operator_flg], #rewrite_operator').change(function ()
	{
		generateRawUrl();
		generatePermalink();
		getRewriteRule();
	})
	
	$('#rewrite_url').change(function ()
	{
		getRewriteRule();
	})
	
});



/*
 * User Functions
 * ------------------------------------------------------------------------------------------------ */
function generatePermalinkKey ()
{
	$('.permalinkKeySample').text('/' + $('input[name=permalink_style]').data('sample'));
	return false;
}

function generateRawUrl ()
{
	if (! $('#rewrite_url').val() && $('#resource_url').val())
	{
		$('#permalink_sample').text($('#resource_url').val() + '?post_key=' + $('input[name=permalink_style]:checked').data('parameter_key'));
	}
	return false;
}

function generatePermalink ()
{
	if ($('#rewrite_url').val())
	{
		$('#permalink_sample').text($('#rewrite_url').val() + '/' + $('input[name=permalink_style]:checked').data('sample'));
	}
	return false;
}

function getRewriteRule ()
{
	$permalink_style = $('input[name=permalink_style]:checked').val();
	$resource_url = $('#resource_url').val();
	$rewrite_url = $('#rewrite_url').val();
	$rewrite_operator_flg = $('input[name=rewrite_operator_flg]:checked').val();
	$rewrite_operator = $('#rewrite_operator').val();
	
	// if ($permalink_style && $resource_url && $rewrite_url)
	// {
		$.ajax({
			url: 'ajax/generate_rewrite_rule.php',
			type: 'post',
			data: {
				permalink_style : $permalink_style,
				resource_url: $resource_url,
				rewrite_url: $rewrite_url,
				rewrite_operator_flg: $rewrite_operator_flg,
				rewrite_operator: $rewrite_operator,
			},
			dataType: 'json',
			async: true,
		}).done(function ($response)
		{
			$('#rewrite_rule_code').text($response['rewrite_rule']);
		});
	// }
	
	if (! $rewrite_url && ! $rewrite_operator_flg)
	{
		$('#rewrite_rule_code').text('# nothing rule');
	}
	
}


