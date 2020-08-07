<?php

/*
 * COMMON
 * ------------------------------------------------------------------------------------------------ */
$entity_code_list = array
(
		1 => 'site',
		2 => 'posttype',
		3 => 'language',
		4 => 'category',
		5 => 'tag',
		6 => 'user',
		7 => 'group',
);

$common_display_limit = array
(
		5   => 5,
		10  => 10,
		15  => 15,
		20  => 20,
		30  => 30,
		50  => 50,
		100 => 100,
);


/*
 * SYSTEM
 * ------------------------------------------------------------------------------------------------ */
$database_list = array
(
		1 => 'SQLite',
		2 => 'MySQL',
);

$language_list = array
(
		'en' => 'English',
		'ja' => '日本語',
);

$system_font_list = array
(
		'uni_sans_serif' => 'System default',
		'ja_noto_sans'   => '日本語 Noto Sans',
		'ja_system'      => '日本語 ヒラギノ / メイリオ',
);

$postease_license = array
(
  0 => 'Basic',
  1 => 'Advance',
  2 => 'Business'
);


/*
 * DASH BOARD
 * ------------------------------------------------------------------------------------------------ */
$post_status_icon = array
(
	1 => '<i class="fa fa-eye" aria-hidden="true"></i>',
	2 => '<i class="fa fa-pencil" aria-hidden="true"></i>',
	8 => '<i class="fa fa-eye-slash" aria-hidden="true"></i>',
);
$contact_status_icon = array
(
	1 => '<i class="fa fa-archive" aria-hidden="true"></i>',
	7 => '<i class="fa fa-hourglass-half" aria-hidden="true"></i>',
	8 => '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>',
);


/*
 * COMMENT
 * ------------------------------------------------------------------------------------------------ */
$comment_items = array
(
		1  => array
		(
				'item'    => 'target_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'target_id',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1001,
		),
		2  => array
		(
				'item'    => 'post_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'post_id',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1002,
		),
		3  => array
		(
				'item'    => 'comment_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'comment_id',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1003,
		),
		4  => array
		(
				'item'    => 'parent_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'parent_id',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1004,
		),
		5  => array
		(
				'item'    => 'site_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'site_id',
				'default_value' => 1,
				'select_values' => null,
				'temp_order'    => 1005,
		),
		6  => array
		(
				'item'    => 'posttype_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'posttype_id',
				'default_value' => 1,
				'select_values' => null,
				'temp_order'    => 1006,
		),
		7  => array
		(
				'item'    => 'type',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'type',
				'default_value' => 1,
				'select_values' => null,
				'temp_order'    => 1007,
		),
		8  => array
		(
				'item'    => 'ip_address',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'ip_address',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 1008,
		),
		9  => array
		(
				'item'    => 'delete_flg',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'delete_flg',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1009,
		),
		10 => array
		(
				'item'    => 'score',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'score',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1,
		),
		11 => array
		(
				'item'    => 'nickname',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'nickname',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 2,
		),
		12 => array
		(
				'item'    => 'email',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'email',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 3,
		),
		13 => array
		(
				'item'    => 'eyecatch',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'eyecatch',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 4,
		),
		14 => array
		(
				'item'    => 'title',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'title',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 5,
		),
		15 => array
		(
				'item'    => 'content',
				'label'   => null,
				'htmltag' => 'textarea',
				'type'    => 'textarea',
				'name'    => 'content',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 6,
		),
);


/*
 * POSTTYPE / CONTACT
 * ------------------------------------------------------------------------------------------------ */
$posttype_comment_type_icon = array
(
		1  => 'comment',
		2  => 'star-half-o',
		3  => 'paperclip',
);

$icon_list = array
(
		'General' => array
		(
				'pencil-square'    => '<i class="fa fa-pencil-square" aria-hidden="true"></i>',
				'pencil'           => '<i class="fa fa-pencil" aria-hidden="true"></i>',
				'book'             => '<i class="fa fa-book" aria-hidden="true"></i>',
				'bookmark'         => '<i class="fa fa-bookmark" aria-hidden="true"></i>',
				'bullhorn'         => '<i class="fa fa-bullhorn" aria-hidden="true"></i>',
				'map-marker'       => '<i class="fa fa-map-marker" aria-hidden="true"></i>',
				'cube'             => '<i class="fa fa-cube" aria-hidden="true"></i>',
				'cubes'            => '<i class="fa fa-cubes" aria-hidden="true"></i>',
				'cogs'             => '<i class="fa fa-cogs" aria-hidden="true"></i>',
				'globe'            => '<i class="fa fa-globe" aria-hidden="true"></i>',
				'bell'        => '<i class="fa fa-bell" aria-hidden="true"></i>',
				'heart'       => '<i class="fa fa-heart" aria-hidden="true"></i>',
				'commenting'       => '<i class="fa fa-commenting" aria-hidden="true"></i>',
				'folder'           => '<i class="fa fa-folder" aria-hidden="true"></i>',
				'folder-open'      => '<i class="fa fa-folder-open" aria-hidden="true"></i>',
				'plus-square'            => '<i class="fa fa-plus-square" aria-hidden="true"></i>',
				'info-circle'      => '<i class="fa fa-info-circle" aria-hidden="true"></i>',
				'question-circle'  => '<i class="fa fa-question-circle" aria-hidden="true"></i>',
				'check-circle'     => '<i class="fa fa-check-circle" aria-hidden="true"></i>',
				'certificate'      => '<i class="fa fa-certificate" aria-hidden="true"></i>',
				'file'             => '<i class="fa fa-file" aria-hidden="true"></i>',
				'file-text'        => '<i class="fa fa-file-text" aria-hidden="true"></i>',
		),
		'Architecture' => array
		(
				'home'             => '<i class="fa fa-home" aria-hidden="true"></i>',
				'building'         => '<i class="fa fa-building" aria-hidden="true"></i>',
				'building-o'       => '<i class="fa fa-building-o" aria-hidden="true"></i>',
				'university'       => '<i class="fa fa-university" aria-hidden="true"></i>',
				'industry'         => '<i class="fa fa-industry" aria-hidden="true"></i>',
				'hospital-o'       => '<i class="fa fa-hospital-o" aria-hidden="true"></i>',
		),
		'Jobs' => array
		(
				'coffee'           => '<i class="fa fa-coffee" aria-hidden="true"></i>',
				'cutlery'          => '<i class="fa fa-cutlery" aria-hidden="true"></i>',
				'beer'             => '<i class="fa fa-beer" aria-hidden="true"></i>',
				'glass'            => '<i class="fa fa-glass" aria-hidden="true"></i>',
				'bar-chart'        => '<i class="fa fa-bar-chart" aria-hidden="true"></i>',
				'microphone'       => '<i class="fa fa-microphone" aria-hidden="true"></i>',
				'diamond'          => '<i class="fa fa-diamond" aria-hidden="true"></i>',
				'paw'              => '<i class="fa fa-paw" aria-hidden="true"></i>',
				'wrench'           => '<i class="fa fa-wrench" aria-hidden="true"></i>',
				'scissors'         => '<i class="fa fa-scissors" aria-hidden="true"></i>',
				'bed'              => '<i class="fa fa-bed" aria-hidden="true"></i>',
				'balance-scale'    => '<i class="fa fa-balance-scale" aria-hidden="true"></i>',
		),
		'Culture' => array
		(
				'film'             => '<i class="fa fa-film" aria-hidden="true"></i>',
				'music'            => '<i class="fa fa-music" aria-hidden="true"></i>',
				'camera'           => '<i class="fa fa-camera" aria-hidden="true"></i>',
				'camera-retro'     => '<i class="fa fa-camera-retro" aria-hidden="true"></i>',
		),
		'Gadget' => array
		(
				'television'       => '<i class="fa fa-television" aria-hidden="true"></i>',
				'desktop'          => '<i class="fa fa-desktop" aria-hidden="true"></i>',
				'laptop'           => '<i class="fa fa-laptop" aria-hidden="true"></i>',
				'mobile'           => '<i class="fa fa-mobile" aria-hidden="true"></i>',
				'phone'            => '<i class="fa fa-phone" aria-hidden="true"></i>',
				'print'            => '<i class="fa fa-print" aria-hidden="true"></i>',
				'fax'              => '<i class="fa fa-fax" aria-hidden="true"></i>',
				'gamepad'          => '<i class="fa fa-gamepad" aria-hidden="true"></i>',
				'headphones'       => '<i class="fa fa-headphones" aria-hidden="true"></i>',
		),
		'Vhicle' => array
		(
				'motorcycle'       => '<i class="fa fa-motorcycle" aria-hidden="true"></i>',
				'car'              => '<i class="fa fa-car" aria-hidden="true"></i>',
				'bus'              => '<i class="fa fa-bus" aria-hidden="true"></i>',
				'truck'            => '<i class="fa fa-truck" aria-hidden="true"></i>',
				'taxi'             => '<i class="fa fa-taxi" aria-hidden="true"></i>',
				'ship'             => '<i class="fa fa-ship" aria-hidden="true"></i>',
				'plane'            => '<i class="fa fa-plane" aria-hidden="true"></i>',
				'fighter-jet'      => '<i class="fa fa-fighter-jet" aria-hidden="true"></i>',
				'rocket'           => '<i class="fa fa-rocket" aria-hidden="true"></i>',
		),
		'Outdoor' => array
		(
				'bicycle'          => '<i class="fa fa-bicycle" aria-hidden="true"></i>',
				'futbol-o'         => '<i class="fa fa-futbol-o" aria-hidden="true"></i>',
				'life-ring'        => '<i class="fa fa-life-ring" aria-hidden="true"></i>',
				'tree'             => '<i class="fa fa-tree" aria-hidden="true"></i>',
				'leaf'             => '<i class="fa fa-leaf" aria-hidden="true"></i>',
				'trophy'           => '<i class="fa fa-trophy" aria-hidden="true"></i>',
				'flag'             => '<i class="fa fa-flag" aria-hidden="true"></i>',
				'flag-checkered'   => '<i class="fa fa-flag-checkered" aria-hidden="true"></i>',
				'bullseye'         => '<i class="fa fa-bullseye" aria-hidden="true"></i>',
				'fire'             => '<i class="fa fa-fire" aria-hidden="true"></i>',
				'clock-o'          => '<i class="fa fa-clock-o" aria-hidden="true"></i>',
		),
);

$posttype_mata_common = array
(
		'menu_icon'              => 'pencil-square',
		'auto_save_flg'          => '1',
		'use_wisiwyg_flg'        => '1',
		'use_customitem_flg'     => '1',
		'use_multipage_flg'      => '0',
		'comment_type'           => '',
		'use_publish_end_at_flg' => '1', // added in v3.0.0
		'use_category_flg'       => '1', // added in v3.0.0
		'use_tag_flg'            => '1', // added in v3.0.0
		'use_addition_flg'       => '1',
		'use_content_flg'        => '1',
		'use_slug_flg'           => '0',
		'use_list_eyecatch_flg'  => '1',
		'eyecatch_frame'         => 'fr_admin/eyecatch',
		'customitem_position'   => '2',
		'posts_list_num'        => '10',
		'posts_sort_order'      => 'DESC',
		'posts_column03'        => '1',
		'posts_category_num'    => '2',
		'posts_tag_num'         => '2',
		'comments_list_num'     => '10',
		'comments_title_length' => '12',
		'review_max_score'      => '5',
);

$posttype_mata_individual = array
(
	'permalink_style'        => '1',
	'resource_url'           => '', // added in v3.0.0
	'rewrite_url'            => '', // added in v3.0.0
	'permalink_base_prd'     => '', // added in v3.0.0
	'rewrite_operator'       => 'php', // added in v3.0.0
	'rewrite_operator_flg'   => '0', // added in v3.0.0
);

$contact_mata_common = array
(
		// additional function
		'use_customitem_flg'        => '1',
		'email_admin'               => '',
		
		// mail config
		'use_auto_reply_admin'    => '0',
		'admin_language'          => 'unicode',
		'admin_to'                => '',
		'admin_from'              => '',
		'admin_from_name'         => '',
		'admin_subject'           => '',
		'admin_body_head'         => '',
		'admin_body_main'         => '',
		'use_input_values_admin'  => '1',
		'admin_body_bottom'       => '',
		'admin_signature'         => '',
	
		'use_auto_reply_customer'    => '0',
		'customer_language'          => 'unicode',
		'customer_from'              => '',
		'customer_from_name'         => '',
		'customer_subject'           => '',
		'customer_body_head'         => '',
		'customer_body_main'         => '',
		'use_input_values_customer'  => '1',
		'customer_body_bottom'       => '',
		'customer_signature'         => '',
		
		// environment
		'use_smtp'     => '0',
		'host'         => '',
		'user_name'    => '',
		'password'     => '',
		'port'         => '',
		
		// display list
		'contacts_list_num'         => '10',
		'contacts_sort_order'       => 'DESC',
		'contacts_column01'         => '1',
		'contacts_column03'         => '1',
		'contacts_column01_length'  => '16',
		'contacts_category_num'     => '2',
);

$upload_file_type_list = array
(
  'csv'   => 'CSV',
  //'xml'   => 'XML',
  //'json'  => 'JSON',
);

$key_column_list = array
(
  1  => 'id',
  2  => 'hash_id',
  3  => 'slug',
);

$base_columns = array
(
  'id'               => null,
  'version'          => 1,
  'versioned_at'     => date('Y-m-d H:i:s'),
  'current_flg'      => 1,
  'hash_id'          => null,
  'permalink_key'    => null,
  'permalink_uri'    => null,
  'publish_datetime' => date('Y-m-d H:i:s'),
  'publish_end_at'   => null,
  'site_id'          => null,
  'posttype_id'      => null,
  'parent_id'        => 0,
  'category_id'      => '0000',
  'tag_id'           => '0000',
  'slug'             => '',
  'eyecatch'         => null,
  'anchor'           => 0,
  'assigned_to'      => 0,
  'created_at'       => date('Y-m-d H:i:s'),
  'created_by'       => null,
  'updated_at'       => null,
  'updated_by'       => 0,
  'grouped_by'       => 0,
  'status'           => 1,
  'delete_flg'       => 0,
);
$text_columns = array
(
  'base_id'      => '',
  'base_version' => '',
  'language_id'  => 1,
  'title'        => '',
  'addition'     => '',
  'content'      => '',
);


/*
 * POST
 * ------------------------------------------------------------------------------------------------ */
$operators = array
(
		'.jpg'  => '/\.jpg/',
		'.JPG'  => '/\.JPG/',
		'.jpeg' => '/\.jpeg/',
		'.JPEG' => '/\.JPEG/',
		'.png'  => '/\.png/',
		'.PNG'  => '/\.PNG/',
		'.gif'  => '/\.gif/',
		'.GIF'  => '/\.GIF/',
		'.pdf'  => '/\.pdf/',
		'.PDF'  => '/\.PDF/',
);

$counter_types = array
(
		1  => 'PV',
		2  => 'UU',
		3  => 'LIKE',
);


/*
 * CONTACT
 * ------------------------------------------------------------------------------------------------ */
$contact_items = array
(
		1  => array
		(
				'item'    => 'site_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'site_id',
				'default_value' => 1,
				'select_values' => null,
				'temp_order'    => 1001,
		),
		2  => array
		(
				'item'    => 'posttype_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'posttype_id',
				'default_value' => 1001,
				'select_values' => null,
				'temp_order'    => 1002,
		),
		3  => array
		(
				'item'    => 'language_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'language_id',
				'default_value' => 1,
				'select_values' => null,
				'temp_order'    => 1003,
		),
		3  => array
		(
				'item'    => 'group_id',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'hidden',
				'name'    => 'group_id',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1004,
		),
		4  => array
		(
				'item'    => 'category_id',
				'label'   => null,
				'htmltag' => 'select',
				'type'    => 'select',
				'name'    => 'category_id',
				'default_value' => 0,
				'select_values' => null,
				'temp_order'    => 1,
		),
		5  => array
		(
				'item'    => 'title',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'title',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 2,
		),
		6  => array
		(
				'item'    => 'content',
				'label'   => null,
				'htmltag' => 'textarea',
				'type'    => 'textarea',
				'name'    => 'content',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 1000,
		),
		7  => array
		(
				'item'    => 'name',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'name',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 3,
		),
		8  => array
		(
				'item'    => 'email',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'email',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 4,
		),
		9  => array
		(
				'item'    => 'tel',
				'label'   => null,
				'htmltag' => 'input',
				'type'    => 'text',
				'name'    => 'tel',
				'default_value' => null,
				'select_values' => null,
				'temp_order'    => 5,
		),
);

$html_input_type = array
(
		0  => 'hidden',
		1  => 'text',
		2  => 'search',
		3  => 'tel',
		4  => 'url',
		5  => 'email',
		6  => 'password',
		7  => 'datetime',
		8  => 'date',
		9  => 'month',
		10 => 'week',
		11 => 'time',
		12 => 'datetime-local',
		13 => 'number',
		14 => 'color',
		15 => 'checkbox',
		16 => 'radio',
		18 => 'image',
);


/*
 * CUSTOM-ITEM
 * ------------------------------------------------------------------------------------------------ */
$syntax_type_list = array
(
		'Markup'      => 'HTML/XHTML',
		'Bash'        => 'Bash',
		'CSS'         => 'CSS',
		'C'           => 'C',
		'C#'          => 'C#',
		'C++'         => 'C++',
		'C-like'      => 'C-like',
		'Java'        => 'Java',
		'JavaScript'  => 'javascript',
		'Less'        => 'Less',
		'Objective-C' => 'Objective-C',
		'Pascal'      => 'Pascal',
		'Perl'        => 'Perl',
		'PHP'         => 'PHP',
		'Python'      => 'Python',
		'Ruby'        => 'Ruby',
		'Sass (Sass)' => 'Sass (Sass)',
		'Sass (Scss)' => 'Sass (Scss)',
		'Scala'       => 'Scala',
		'SQL'         => 'SQL',
		'Swift'       => 'Swift',
		'vim'         => 'vim',
		'YAML'        => 'YAML',
);

