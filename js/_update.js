/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function()
{
	$('#main_menu').animate({opacity: 0.2}, 300);

	console.log('Thanks for using PostEase!');

	// Progress-bar
	$('#update_progress_bar').css({display: 'none'});

	// Cancel All a-href
	$('a').click(function(e)
	{
		e.preventDefault();
	});

	// Execute Update
	var $update_allowed_role   = Number($('#update_allowed_role').val());
	var $update_mode           = Number($('#update_mode').val());
	var $allow_update_flg      = Number($('#allow_update_flg').val());
	var $auto_update_flg       = Number($('#auto_update_flg').val());
	var $check_update_level    = $('#check_update_level').val();
	var $host_activation       = $('#host_activation').val();
	var $host_update           = $('#host_update').val();
	var $this_postease_version = $('#this_postease_version').val();
	var $this_classification   = $('#this_classification').val();
	var $this_ip               = $('#this_ip').val();
	var $language              = $('#language').val();

	var $target_version        = null;
	var $update_level          = 0;
	var $update_detail         = null;
	var $update_extra          = false;

	if ($update_allowed_role && $update_mode && $allow_update_flg && $auto_update_flg)
	{
		$('#update_process_msg').text(TXT_UPDATE_MSG_01);

		// Step.1 : Check Update
		$.ajax({
			type : 'GET',
			url  : $host_activation + '/ajax/check_version.php',
			data : {
				this_postease_version : $this_postease_version,
				this_classification   : $this_classification,
				this_ip               : $this_ip,
				level                 : $check_update_level,
				language              : $language,
			},
			dataType : 'json',
			timeout: 5000,
			error : function(XMLHttpRequest, textStatus, errorThrown)
			{
				setTimeout(function()
				{
					$('#update_process_msg').text(TXT_UPDATE_MSG_91);
				}, 500);
				setTimeout(function()
				{
					location.href = './?view_page=index&change=1';
				}, 2500);
			},
			success  : function(data)
			{
				if (data.result == 1 && data.update_level && data.update_detail && data.next_postease_version)
				{
					$target_version = data.next_postease_version;
					$update_level   = data.update_level;
					$update_detail  = data.update_detail;

					$('#update_process_msg').text(TXT_UPDATE_MSG_02);
					$('#update_progress_bar').css({display: 'block'});

					// Step.2 : Prepare Update (ACT)
					$.when(
						setInterval(function(){
							var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
							if ($progress_now < 20)
							{
								var $progress_next = $progress_now + 1;
								$('#progress_bar').attr('aria-valuenow', $progress_next);
								$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
							}
						}, 10)
					).done(function()
					{
						$.ajax({
							type : 'GET',
							url  : $host_activation + '/ajax/prepare_update.php',
							data : {
								target_version : $target_version
							},
							dataType : 'json',
							timeout: 7000,
							error : function(XMLHttpRequest, textStatus, errorThrown)
							{
								setTimeout(function()
								{
									$('#update_process_msg').text(TXT_UPDATE_MSG_92);
								}, 500);
								setTimeout(function()
								{
									location.href = './?view_page=index&change=1';
								}, 2500);
							},
							success  : function(data)
							{
								if (data.result == 1)
								{
									if (data.targets)
									{
										for (var $i = 0; $i < data.targets.length; $i++)
										{
											if (data.targets[$i].match(/update_extra/))
											{
												$update_extra = true;
												break;
											}
										}
									}

									// Step.3 : Prepare Update (UPD)
									$.when(
										setInterval(function(){
											var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
											if ($progress_now < 40)
											{
												var $progress_next = $progress_now + 1;
												$('#progress_bar').attr('aria-valuenow', $progress_next);
												$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
											}
										}, 10)
									).done(function()
									{
										var $targets = data.targets;
										$.ajax({
											type : 'POST',
											url  : $host_update + '/ajax/prepare_update.php',
											data : {
												target_version : $target_version,
												targets        : $targets,
											},
											dataType : 'json',
											timeout: 7000,
											error : function(XMLHttpRequest, textStatus, errorThrown)
											{
												setTimeout(function()
												{
													$('#update_process_msg').text(TXT_UPDATE_MSG_99);
												}, 1000);
												setTimeout(function()
												{
													location.href = './?view_page=index&change=1';
												}, 2500);
											},
											success  : function(data)
											{
												if (data.result == 1)
												{
													// Step.4 : Execute Update
													$.when(
														setInterval(function(){
															var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
															if ($progress_now < 60)
															{
																var $progress_next = $progress_now + 1;
																$('#progress_bar').attr('aria-valuenow', $progress_next);
																$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
															}
														}, 10)
													).done(function()
													{
														var $temp_dir = data.temp_dir;
														$.ajax({
															type : 'GET',
															url  : './ajax/execute_update.php',
															data : {
																target_version : $target_version,
																temp_dir       : $temp_dir,
																update_level   : $update_level,
																update_detail  : $update_detail
															},
															dataType : 'json',
															timeout: 300000,
															error : function(XMLHttpRequest, textStatus, errorThrown)
															{
																setTimeout(function()
																{
																	$('#update_process_msg').text(TXT_UPDATE_MSG_94);
																}, 1000);
																setTimeout(function()
																{
																	location.href = './?view_page=index&change=1&rollback=1';
																}, 2500);
															},
															success  : function(data)
															{
																if (data.result == 1)
																{
																	// Step.5 : Claenup Update
																	$.when(
																		setInterval(function(){
																			var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
																			if ($progress_now < 80)
																			{
																				var $progress_next = $progress_now + 1;
																				$('#progress_bar').attr('aria-valuenow', $progress_next);
																				$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
																			}
																		}, 10)
																	).done(function()
																	{
																		$.ajax({
																			type : 'GET',
																			url  : $host_update + '/ajax/cleanup_update.php',
																			data : {
																				temp_dir : $temp_dir
																			},
																			dataType : 'json',
																			timeout: 7000,
																			error : function(XMLHttpRequest, textStatus, errorThrown)
																			{
																				setTimeout(function()
																				{
																					$('#update_process_msg').text(TXT_UPDATE_MSG_95);
																				}, 1000);
																				setTimeout(function()
																				{
																					location.href = './?view_page=index&change=1&rollback=1';
																				}, 2500);
																			},
																			success : function(data)
																			{
																				if (data.result == 1)
																				{
																					// Step.6 : Update Extra
																					$.when(
																						setInterval(function(){
																							var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
																							if ($progress_now < 90)
																							{
																								var $progress_next = $progress_now + 1;
																								$('#progress_bar').attr('aria-valuenow', $progress_next);
																								$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
																							}
																						}, 10)
																					).done(function()
																					{
																						if ($update_extra)
																						{
																							$.ajax({
																								type : 'GET',
																								url  : './ajax/update_extra.php',
																								dataType : 'json',
																								timeout: 60000,
																								error : function(XMLHttpRequest, textStatus, errorThrown)
																								{
																									setTimeout(function()
																									{
																										$('#update_process_msg').text(TXT_UPDATE_MSG_96);
																									}, 500);
																									setTimeout(function()
																									{
																										location.href = './?view_page=index&change=1&rollback=1';
																									}, 2500);
																								},
																								success  : function(data)
																								{
																									if (data.result == 1)
																									{
																										// final step with Step.6
																										setInterval(function(){
																											var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
																											if ($progress_now < 100)
																											{
																												var $progress_next = $progress_now + 1;
																												$('#progress_bar').attr('aria-valuenow', $progress_next);
																												$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
																											}
																										}, 10);
																										$.when(
																											setTimeout(function()
																											{
																												$('#update_process_msg').text(TXT_UPDATE_MSG_03($update_level, $target_version));
																											}, 500)
																										).done(function()
																										{
																											setTimeout(function(){
																												location.href = './?view_page=index&change=1&commit=1';
																											}, 3000);
																										});
																									}
																									// False of Step.6
																									else if (data.result == 0)
																									{
																										setTimeout(function()
																										{
																											$('#update_process_msg').text(TXT_UPDATE_MSG_96);
																										}, 500);
																										setTimeout(function()
																										{
																											location.href = './?view_page=index&change=1&rollback=1';
																										}, 2500);
																									}
																								}
																							});
																						}
																						else {
																							// final step without Step.6
																							setInterval(function(){
																								var $progress_now = parseInt($('#progress_bar').attr('aria-valuenow'));
																								if ($progress_now < 100)
																								{
																									var $progress_next = $progress_now + 1;
																									$('#progress_bar').attr('aria-valuenow', $progress_next);
																									$('#progress_bar').attr('style', 'width:' + $progress_next + '%');
																								}
																							}, 10);
																							$.when(
																								setTimeout(function()
																								{
																									$('#update_process_msg').text(TXT_UPDATE_MSG_03($update_level, $target_version));
																								}, 500)
																							).done(function()
																							{
																								setTimeout(function(){
																									location.href = './?view_page=index&change=1&commit=1';
																								}, 3000);
																							});
																						}
																					});
																				}
																				// False of Step.5
																				else if (data.result == 0)
																				{
																					setTimeout(function()
																					{
																						$('#update_process_msg').text(TXT_UPDATE_MSG_95);
																					}, 500);
																					setTimeout(function()
																					{
																						location.href = './?view_page=index&change=1&rollback=1';
																					}, 2500);
																				}
																			}
																		});
																	});
																}
																// False of Step.4
																else if (data.result == 0)
																{
																	setTimeout(function()
																	{
																		$('#update_process_msg').text(TXT_UPDATE_MSG_94);
																	}, 500);
																	setTimeout(function()
																	{
																		location.href = './?view_page=index&change=1&rollback=1';
																	}, 2500);
																}
															}
														});
													});
												}
												// False of Step.3
												else if (data.result == 9)
												{
													setTimeout(function()
													{
														$('#update_process_msg').text(TXT_UPDATE_MSG_93);
													}, 500);
													setTimeout(function()
													{
														location.href = './?view_page=index&change=1';
													}, 2500);
												}
											}
										});
									});

								}
								// False of Step.2
								else if (data.result == 9)
								{
									setTimeout(function()
									{
										$('#update_process_msg').text(TXT_UPDATE_MSG_92);
									}, 500);
									setTimeout(function()
									{
										location.href = './?view_page=index&change=1';
									}, 2500);
								}
							}
						});
					});
				}
				// False of Step.1 (But not system false)
				else
				{
					setTimeout(function()
					{
						$('#update_process_msg').text(TXT_UPDATE_MSG_61);
					}, 500);
					setTimeout(function()
					{
						location.href = './?view_page=index&change=1';
					}, 2500);
				}
			}
		});
	}
	else {
		location.href = './?view_page=index&change=1';
	}
});
