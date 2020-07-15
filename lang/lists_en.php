<?php
/*
 * SYSTEM
 * ------------------------------------------------------------------------------------------------ */
$currency_list = array
(
	'dollar' => 'dollar',
	'yen'    => 'yen',
);
$extra_posttype_list = array
(
	1001 => 'Contact',
);
$update_level_list = array
(
	1 => 'micro update',
	2 => 'minor update',
	3 => 'major update',
);
$display_errors_list = array
(
	0 => 'show',
	1 => 'hide',
);
$postease_license_ja = array
(
	0 => 'Basic license',
	1 => 'Advanced license',
	2 => 'Business license'
);


/*
 * ERROR
 * ------------------------------------------------------------------------------------------------ */
$reset_system_errormsg = array
(
	// input
	'01' => 'There are required fields that have not been entered.',
	'02' => 'Failed to generate configuration file.',
	
	// activation
	'11' => 'The activation key is not recognized.',
	'12' => 'This activation key is already in use.',
	'13' => 'The activation key and email address combinations are not recognized.',
	'14' => 'Please enter your email address.',
	'15' => 'Failed to get collation key.',
	'16' => 'Failed to update the collation key.',
	
	// database initialize
	'21' => 'There is an error in selecting the database.',
	'22' => 'If you select MySQL, please enter the connection information correctly.',
	'23' => 'Unable to connect to MySQL. Please re-enter your connection information. If you have migrated the <br> system to another server, enter the database connection information to which you are migrating. ※ You need to import the database from the source in advance.',
	'24' => 'SQLite is not available on this server. Check the specifications.',
	'25' => 'An unknown error occurred. The process has been aborted.',
	'26' => 'Unable to connect to the database you are setting up.',
	
	// database manipulation
	'31' => 'Failed to initialize the table.',
	'32' => 'Failed to initialize the record. The specified database may already be in use.',
	'33' => '',
	'34' => 'Same as the current setting. If you are migrating to the same database, change the table prefix.',
	'35' => 'Failed to update configuration record.',
	
	// data migration
	'41' => 'Unable to connect to the database you are setting up.',
	'42' => 'An existing record failed to load.',
	'43' => 'Data migration failed.',
	'44' => 'Same as the current setting. If you are migrating to the same database, change the table prefix.',
	'45' => 'Failed to update configuration record.',
	
	// change path(domain)
	'51' => 'An failed to retrieve a record containing the domain name.',
	'52' => 'An failed update of a record that contains a domain name has failed.',
	'53' => 'An failed to retrieve a record containing the directory name has failed.',
	'54' => 'An failed update to a record containing the directory name has failed.',
);

$execute_errormsg = array
(
	11 => 'New failed.',
	12 => 'Update failed.',
	13 => 'Delete failed.',
);

$errormsg_list = array
(
	// common
	'01' => 'Enter a label.',
	'02' => 'Enter a valid slug.',
	'03' => 'Slugs that have already been used.',
	'04' => 'New failed.',
	'05' => 'Update failed.',
	'06' => 'Delete failed.',
	'09' => 'There was an unexpected error.',
	'10' => 'Bad operation.',
	
	// taxonomy(category, tag + custom_value)
	'11' => 'Enter a label.',
	
	// custom item / custom list
	'21' => 'Enter a item name.',
	'22' => 'This custom list is in use by other post types. The affiliation cannot be changed.',
	'23' => 'This custom list is already in use. It cannot be hidden.',
	'24' => 'This custom list is already in use. It cannot be deleted.',
	
	// image_frame
	'31' => 'Auto requires to set max width or max height.',
	'32' => 'Crop requires both width and height settings.',
	'33' => 'The size that can be set is up to 9999px.',
	
	// user
	'41' => 'Enter a valid account.',
	'42' => 'The account is already in use.',
	
	// password
	'51' => 'Nothing has changed.',
	'52' => 'The new password does not match.',
	'53' => 'The password has not been changed.',
	'54' => 'The current password is incorrect.',
	'55' => 'The password change process failed.',
	'56' => 'The account change process failed.',
	
	// config
	'81' => 'Failed to change the domain.',
	'82' => 'Directory change failed.',
	'83' => 'An incorrect value was specified for the session key. The session key must be in half-width letters. (All changes have been canceled)',
	'84' => 'An incorrect value was specified for the upload directory permissions. (All changes have been canceled)',
	'85' => 'An incorrect value was specified for the user initial password. The user initial password must be in half-width alphanumeric characters. (All changes have been canceled)',
	'86' => 'An incorrect value was specified for the body image default size. (All changes have been canceled)',
	'89' => 'Failed to change the settings.',
	
	// activation
	'91' => 'The license is invalid.<br><a href="./reset_system.php?mode=4">&raquo; Assign a different license</a>',
	'92' => 'The license contents cannot be verified.',
	'93' => 'The license contents cannot be verified.',
	'94' => 'The system was copied (moved) or a new domain was assigned. The system is disabled.<br><a href="./reset_system.php?mode=3">&raquo; Enabled this system with the previous activation key</a><br><a href="./reset_system.php?mode=4">&raquo; Assign a new activation key</a>',
	'99' => 'There are no databases accessible. If you copied or moved the system, make sure that the database migration is correct.',
);


/*
 * RESET-SYSTEM
 * ------------------------------------------------------------------------------------------------ */
$reset_system_titles = array
(
	1 => 'Initial settings',
	2 => 'Database migration',
	3 => 'Reset settings',
	4 => 'Change license',
	5 => 'Verify database usage',
	6 => 'Verify database connection settings',
);

$reset_system_submit = array
(
	1 => 'Set',
	2 => 'Migrate',
	3 => 'Reset',
	4 => 'Update',
	5 => '',
	6 => 'Reset',
);


/*
 * TITLE
 * ------------------------------------------------------------------------------------------------ */
$view_page_type  = array
(
	'post'            => 1,
	'posts'           => 1,
	'category'        => 0,
	'tag'             => 1,
	'custom_item'     => 0,
	'config_posttype' => 1,
	'contact'         => 2,
	'contacts'        => 2,
	'config_contact'  => 2,
	'media'           => 3,
	'image_frame'     => 3,
	'user'            => 4,
	'group'           => 4,
	'change_password' => 4,
	'site'            => 5,
	'posttype'        => 5,
	'language'        => 5,
	'config_general'  => 6,
	'config_option'   => 6,
	'config_core'     => 6,
);
$view_page_title = array
(
	1 => '',
	2 => '',
	3 => 'Media',
	4 => 'User',
	5 => 'Site-option',
	6 => 'Config',
);


/*
 * COMMON
 * ------------------------------------------------------------------------------------------------ */
$common_status_display = array
(
	1 => 'Enabled',
	8 => 'Disabled',
);
$common_status_use = array
(
	1 => 'Enabled',
	8 => 'Disabled',
);

$common_flg_use = array
(
	0 => 'Disabled',
	1 => 'Enabled',
);

$common_flg_utilize = array
(
	0 => 'Disabled',
	1 => 'Enabled',
);

$common_flg_display = array
(
	0 => 'Disabled',
	1 => 'Enabled',
);

$common_flg_permission = array
(
	0 => 'Disallow',
	1 => 'Allow',
);

$common_flg_valid = array
(
	0 => 'Disabled',
	1 => 'Enabled',
);

$common_flg_do = array
(
	0 => 'Disabled',
	1 => 'Enabled',
);


/*
 * CONFIG (core)
 * ------------------------------------------------------------------------------------------------ */
$edit_controll_list = array
(
	1 => 'Private',
	2 => 'User role',
	9 => 'None',
);
$editable_role_list = array
(
	2 => 'Site administrator',
	7 => 'Editor',
	8 => 'Writer',
);
$implement_code_list = array
(
	1 => 'PHP',
	2 => 'jQuery',
);


/*
 * CONFIG POSTTYPE / CONTACT
 * ------------------------------------------------------------------------------------------------ */
$posts_column01_list = array
(
	1 => 'Publish Status',
	2 => 'ID',
);
$posts_column02_list = array
(
	1 => 'Categories / Tags',
	2 => 'Categories',
	3 => 'Tags',
);
$posts_column03_list = array
(
	1 => 'Created by',
	2 => 'Updated by',
);
$posts_sort_order_list = array
(
	'ASC'  => 'Asc',
	'DESC' => 'Desc',
);
$post_customitem_position_list = array
(
	1 => 'Top',
	2 => 'Middle',
	3 => 'Bottom',
);
$permalink_style_list = array
(
	1 => 'HashID（67a89b013d25）',
	2 => 'category and HashID（category/67a89b013d25）',
	3 => 'SystemID（123）',
	4 => 'Category and SystemID（category/123）',
	5 => 'Slug（hello-world）',
	6 => 'Category and Slug（category/hello-world）',
	7 => 'Date and Slug（' . date('Y/m/d') . '/hello-world）',
	8 => 'Year/Month and Slug（' . date('Y/m') . '/hello-world）',

);
$permalink_sample_list = array
(
	1 => '67a89b013d25',
	2 => 'category/67a89b013d25',
	3 => '123',
	4 => 'category/123',
	5 => 'hello-world',
	6 => 'category/hello-world',
	7 => date('Y/m/d') . '/hello-world',
	8 => date('Y/m') . '/hello-world',
);
$parameter_key_list = array
(
	1 => '67a89b013d25',
	2 => '67a89b013d25',
	3 => '123',
	4 => '123',
	5 => 'hello-world',
	6 => 'category-hello-world',
	7 => date('Y-m-d') . '-hello-world',
	8 => date('Y-m') . '-hello-world',
);
$contacts_sort_order_list = array
(
	'ASC'  => 'Asc',
	'DESC' => 'Desc',
);
$contacts_column01_list = array
(
	1 => 'Title',
	2 => 'Content',
);
$contacts_column03_list = array
(
	1 => 'Name',
	2 => 'Email',
	3 => 'Phone number',
);


/*
 * POST
 * ------------------------------------------------------------------------------------------------ */
$post_status = array
(
	1 => 'published',
	2 => 'draft',
	8 => 'unpublish',
);
$post_status_icon = array
(
	1 => '<i class="fa fa-eye" aria-hidden="true"></i>',
	2 => '<i class="fa fa-pencil" aria-hidden="true"></i>',
	8 => '<i class="fa fa-eye-slash" aria-hidden="true"></i>',
);
$contact_status_icon = array
(
	1 => '<i class="fa fa-archive" aria-hidden="true"></i>',
	7 => '<i class="fa fa-comments-o" aria-hidden="true"></i>',
	8 => '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>',
);


/*
 * COMMENT
 * ------------------------------------------------------------------------------------------------ */
$comment_status = array
(
	1 => 'published',
	2 => 'pending',
	8 => 'unpublish',
);
$comment_items_label = array
(
	'score'    => 'Score',
	'nickname' => 'Nickname',
	'email'    => 'Email',
	'eyecatch' => 'Eyecatch',
	'title'    => 'Subject',
	'content'  => 'Body',
);


/*
 * CONTACT
 * ------------------------------------------------------------------------------------------------ */
$contact_status = array
(
	1 => 'Done',
	7 => 'In progress',
	8 => 'Untreated',
);
$contact_items_label = array
(
	'category_id' => 'Inquiry category',
	'title'       => 'Subject',
	'content'     => 'Body',
	'name'        => 'Name',
	'email'       => 'Email',
	'tel'         => 'Phone number',
);


/*
 * POSTTYPE
 * ------------------------------------------------------------------------------------------------ */
$posttype_comment_type = array
(
	1 => 'Comment',
	2 => 'Review',
	3 => 'Sub-post',
);
$posttype_mata_text = array
(
	'label_title'     => 'Title',
	'label_addition'  => 'Description',
	'label_content'   => 'Content',
);


/*
 * USER
 * ------------------------------------------------------------------------------------------------ */
$user_role = array
(
	1 => 'System Administrator',
	2 => 'Site Administrator',
	7 => 'Editor',
	8 => 'Writer',
);


/*
 * CUSTOM-ITEM
 * ------------------------------------------------------------------------------------------------ */
$custom_item_type_post = array
(
	'text'       => 'Text',
	'datetime'   => 'Datetime',
	'date'       => 'Date',
	'time'       => 'Time',
	'textarea-s' => 'Textarea(S)',
	'textarea-m' => 'Textarea(M)',
	'textarea-l' => 'Textarea(L)',
	'list'       => 'List',
	'table'      => 'Table',
	'select'     => 'Select',
	'radio'      => 'Radio',
	'checkbox'   => 'Checkbox',
	'image'      => 'Image',
	'gallery'    => 'Gallery',
	'relation'   => 'Relation',
	'syntax'     => 'Syntax',
);
$custom_item_type_contact = array
(
	'text'       => 'Text',
	'date'       => 'Date',
	'textarea-s' => 'Textarea(S)',
	'textarea-m' => 'Textarea(M)',
	'textarea-l' => 'Textarea(L)',
	'select'     => 'Select',
	'radio'      => 'Radio',
	'checkbox'   => 'Checkbox',
);
$column_delimiter_list = array
(
	'comma'     => 'Comma ( , )',
	'semicolon' => 'Semicolon ( ; )',
	'colon'     => 'Colon ( : )',
	'slash'     => 'Slash ( / )',
	'dot'       => 'Dot ( . )',
);


/*
 * IMAGE-FRAME
 * ------------------------------------------------------------------------------------------------ */
$image_frame_type = array
(
	'auto' => 'Auto resize',
	'crop' => 'Crop ',
);


/*
 * UPDATE
 * ------------------------------------------------------------------------------------------------ */
$update_type = array
(
	1  => 'Major',
	2  => 'Minor',
	3  => 'Micro',
	9  => 'Downgrade',
);

$update_level = array
(
	1  => 'Level1 (Micro update)',
	2  => 'Level2 (Minor update)',
	3  => 'Level3 (Major update)',
);


/*
 * INDEX
 * ------------------------------------------------------------------------------------------------ */
function smart_cache_icon ($lisence)
{
	$icon = '';
	if ($lisence > 0)
	{
		$icon = '';
	}
}
