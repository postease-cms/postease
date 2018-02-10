
<!-- OUTER WRAP -->
<main id="content" class="col-md-10">
	
	<!-- PAGE TITLE -->
	<div id="page_title" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><i class="fa <?=$page_icon?>"></i> <?=$page_title_main?> <?=TXT_COVER_LBL_TOCOVER?></h3></div>
	</div>
	
	<!-- INNER WRAP -->
	<div id="post_wrap" class="col-md-12">
		
		<!-- MAIN CONTENTS -->
		<div class="slow-show">
			
			<?php if (count($records)):?>
				<!-- LIST -->
				<div class="panel panel-default registerdList">
					<div class="panel-heading">
						<label for="cover_image_target"><?=TXT_COVER_LBL_SETFRAME?></label>
						<span id="back_to_text"><a href="<?=$back_link?>"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> <?=TXT_COVER_LNK_BACKTOTEXT?></a></span>
						<select class="form-control" id="cover_image_target">
							<?php foreach ($image_frame_list as $key => $value):?>
								<option value="<?=$key?>" <?=($key==$image_frame_default)?'selected':''?>><?=$value?></option>
							<?php endforeach?>
						</select>
					</div>
					<div class="panel-body">
						<div class="row">
							<?php foreach ($records as $key => $row):?>
								<div class="cover_image_container col-lg-3 col-md-4 col-sm-6 col-xs-12" data-entity_code=<?=$entity_code?> data-entity_id=<?=$row['id']?>>
									<div class="thumbnail">
										<div class="cover_image_wrap" id="cover_image_wrap_<?=$row['id']?>">
											<input type="hidden" class="cover_image" id="cover_image_<?=$row['id']?>" value="">
											<?php if ($row['cover_image']):?>
												<img class="cover_image_established" src="<?=$row['cover_image']?>" alt="*">
											<?php else:?>
												<img src="img/noimage.png" alt="*">
											<?php endif?>
										</div>
										<div class="caption">
											<span class="cover_image_name"><?=$row['name']?></span>
											<span class="cover_image_slug"><?=$row['slug']?></span>
											<div id="cover_image_operation_<?=$row['id']?>" class="cover_image_operation">
												<a href="filemanager/dialog.php?type=2&field_id=cover_image_<?=$row['id']?>" type="button" id="set_<?=$row['id']?>" class="btn btn-default openFilemanager set_cover_image"><?=TXT_POST_BTN_IMG_SET?></a>
												<button type="button" id="delete_<?=$row['id']?>" class="btn btn-warning delete_cover_image <?=($row['cover_image']?'':'hidden')?>"><?=TXT_POST_BTN_IMG_DELETE?></button>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach?>
						</div>
					</div>
				</div>
			<?php endif?>
		</div>
	</div>
</main>
<script src="js/taxonomy.js"></script>
<script src="js/edit_hierarchy.js"></script>
<script src="js/check_slug.js"></script>