<?php

/*
 * Record Values
 * ---------------------------------------------------------------------------------------------------- */
// sites
$REC_SITE_DEFAULTSITE = array
(
	'en' => 'SITE',
	'ja' => '既定サイト',
);


// posttypes
$REC_POSTTYPE_DEFAULTPOSTTYPE = array
(
	'en' => 'POST',
	'ja' => '投稿',
);


// contacts
$REC_POSTTYPE_DEFAULTCONTACT = array
(
	'en' => 'CONTACT',
	'ja' => 'コンタクト',
);


// languages
$REC_LANGUAGE_DEFAULTLANGUAGE = array
(
	'en' => 'LANGUAGE',
	'ja' => '既定言語',
);


// image_frames
$REC_IMAGEFRAME_ADMINEYECATCH = array
(
	'en' => 'eyecatch for Dashboard',
	'ja' => '管理画面アイキャッチ用',
);

$REC_IMAGEFRAME_ADMINDEFAUTIMAGE = array
(
	'en' => 'default image for Dashboard',
	'ja' => '管理画面デフォルトイメージ用',
);

$REC_IMAGEFRAME_ADMINLIST = array
(
	'en' => 'eyecatch image for list',
	'ja' => '管理画面リスト表示用',
);

$REC_IMAGEFRAME_ADMINDEFAUTGALLERY = array
(
	'en' => 'gallery for Dashboard',
	'ja' => '管理画面デフォルトギャラリー用',
);

$REC_IMAGEFRAME_DEFAUTAUTO_01 = array
(
	'en' => 'AUTO RESIZE SAMPLE',
	'ja' => '自動リサイズサンプル',
);

$REC_IMAGEFRAME_DEFAUTCROP_01 = array
(
	'en' => 'CROP SAMPLE',
	'ja' => '固定サイズ切抜きサンプル',
);


// posts_text
$REC_POSTTYPE_LABELTITLE = array
(
	'en' => 'title',
	'ja' => 'タイトル',
);

$REC_POSTTYPE_LABELADDITION = array
(
	'en' => 'addition',
	'ja' => 'ディスクリプション',
);

$REC_POSTTYPE_LABELCONTENT = array
(
	'en' => 'content',
	'ja' => '本文',
);


// posts_text
$REC_POSTSTEXT_DUMMYTITLE = array
(
	'en' => 'Welcome to POSTEASE!',
	'ja' => 'ようこそ、POSTEASE へ！',
);

$REC_POSTSTEXT_DUMMYCONTENT = array
(
	'en' => "<p>Let's begin to start POSTEASE.</p><p>POSTEASE is absolutely simple and powerful headless cms.</p>",
	'ja' => '<p>さあ、POSTEASE を使い始めましょう。</p><p>POSTEASE はとてもシンプルでパワフルなヘッドレスCMSです。</p>',
);


// contacts_text
$REC_CONTACTSTEXT_DUMMYTITLE = array
(
	'en' => 'Inquiry',
	'ja' => 'お問合わせ',
);

$REC_CONTACTSTEXT_DUMMYCONTENT = array
(
	'en' => 'This is the contents of the dummy contact generated automatically at the time of system installation. Before using this system, please edit or delete this data.',
	'ja' => 'これはシステムインストール時に自動生成されたダミーコンタクトです。このコンタクトは削除するか、内容を更新して使用してください。',
);

$REC_CONTACTSTEXT_DUMMYNAME = array
(
	'en' => 'Post Ease',
	'ja' => 'ポスト イーズ',
);

$REC_CONTACTSTEXT_DUMMYEMAIL = array
(
	'en' => 'user@postease.com',
	'ja' => 'user@postease.com',
);

$REC_CONTACTSTEXT_DUMMYTEL = array
(
	'en' => '0412-345-000',
	'ja' => '012-3456-7890',
);


// contacts_text
$REC_UPDATEHISTORIES_APPLIEDDETAIL = array
(
	'en' => 'Install',
	'ja' => 'インストール',
);



/*
 * Initialize Records Process
 * ---------------------------------------------------------------------------------------------------- */
require_once dirname(__FILE__).'/../../lib/functions.php';
date_default_timezone_set($_SESSION['postease']['timezone']);
$now  = date('Y-m-d H:i:s');
$lang = $_SESSION['postease']['lang'];
$first_account      = $_SESSION['postease']['account'];
$first_nickname     = $_SESSION['postease']['nickname'];
$first_password     = blowfish($_SESSION['postease']['password'], $_SESSION['postease']['account']);
$postease_version   = $_SESSION['postease']['postease_version'];
$table_prefix       = $_SESSION['postease']['table_prefix'];
$system_font        = 'uni_sans_serif';
$first_post_hash_id = generateHashId(1);
$preview_hash_salt  = hash('ripemd128', time());

// Set defaul system font by lang
if ($lang == 'ja') $system_font = 'ja_noto_sans';

// Initialize records
$init_records = array
(
	"INSERT INTO `{$table_prefix}configs` VALUES('default_password','core','0000000')",
	"INSERT INTO `{$table_prefix}configs` VALUES('edit_controll','core','9')",
	"INSERT INTO `{$table_prefix}configs` VALUES('publish_role','core','8')",
	"INSERT INTO `{$table_prefix}configs` VALUES('editable_role_category_post','core','7')",
	"INSERT INTO `{$table_prefix}configs` VALUES('editable_role_tag_post','core','8')",
	"INSERT INTO `{$table_prefix}configs` VALUES('editable_role_category_contact','core','2')",
	"INSERT INTO `{$table_prefix}configs` VALUES('dir_name','core','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('domain','core','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('session_key','core','postease')",
	"INSERT INTO `{$table_prefix}configs` VALUES('timezone','core','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('allow_update_flg','core','1')",
	"INSERT INTO `{$table_prefix}configs` VALUES('auto_update_flg','core','1')",
	"INSERT INTO `{$table_prefix}configs` VALUES('update_allowed_role','core','2')",
	"INSERT INTO `{$table_prefix}configs` VALUES('update_level','core','3')",
	"INSERT INTO `{$table_prefix}configs` VALUES('upload_imagesize_main_height','core','0')",
	"INSERT INTO `{$table_prefix}configs` VALUES('upload_imagesize_main_width','core','1200')",
	"INSERT INTO `{$table_prefix}configs` VALUES('media_parameter_flg','core','1')",
	"INSERT INTO `{$table_prefix}configs` VALUES('upload_dir_permission','core','775')",
	"INSERT INTO `{$table_prefix}configs` VALUES('display_errors','core','0')",
	"INSERT INTO `{$table_prefix}configs` VALUES('preview_hash_salt','core','{$preview_hash_salt}')", // added in v3.0.0
	
	// Security
	// "INSERT INTO `{$table_prefix}configs` VALUES('use_secure_login_flg','core','0')",
	// "INSERT INTO `{$table_prefix}configs` VALUES('security_key','core','')",
	
	// API access
	"INSERT INTO `{$table_prefix}configs` VALUES('origin_allowed','core','')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs` VALUES('remote_address_allowed','core','')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs` VALUES('api_force_cache_time','core','0')", // added in v3.2.0 (for API V3)
	
	"INSERT INTO `{$table_prefix}configs` VALUES('database','system','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('table_prefix','system','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('activation_key','system','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('host_activation','system','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('host_update','system','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('verification_key','system','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('postease_version','system','')",
	
	"INSERT INTO `{$table_prefix}configs` VALUES('site_name','general','')",
	"INSERT INTO `{$table_prefix}configs` VALUES('implement_code','general','1')",
	"INSERT INTO `{$table_prefix}configs` VALUES('display_implement_code','general','1')",
	"INSERT INTO `{$table_prefix}configs` VALUES('language','general','{$lang}')",
	"INSERT INTO `{$table_prefix}configs` VALUES('system_font','general','{$system_font}')",
	
	"INSERT INTO `{$table_prefix}configs` VALUES('use_version_flg','option','0')",
	"INSERT INTO `{$table_prefix}configs` VALUES('use_contact_flg','option','1')",
	"INSERT INTO `{$table_prefix}configs` VALUES('use_group_flg','option','0')",
	"INSERT INTO `{$table_prefix}configs` VALUES('use_multilingual_flg','option','0')",
	"INSERT INTO `{$table_prefix}configs` VALUES('use_multisite_flg','option','0')",
	"INSERT INTO `{$table_prefix}configs` VALUES('use_posttype_flg','option','1')",
	
	"INSERT INTO `{$table_prefix}users` (`id`, `account`, `nickname`, `password`, `role`, `site_id`, `posttype_id`, `created_at`, `delete_flg`) VALUES
	(1, '{$first_account}', '{$first_nickname}', '{$first_password}', 1, '0001', '0001,1001', '{$now}', 0)",
	
	"INSERT INTO `{$table_prefix}sites` (`id`, `name`, `slug`, `line_order`, `status`, `delete_flg`) VALUES
	(1, '{$REC_SITE_DEFAULTSITE[$lang]}', 'default', 1, 1, 0)",
	
	"INSERT INTO `{$table_prefix}posttypes` (`id`, `site_id`, `name`, `slug`, `line_order`, `status`, `delete_flg`) VALUES
	(1, '0001', '{$REC_POSTTYPE_DEFAULTPOSTTYPE[$lang]}', 'post', 1, 1, 0)",
	
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'menu_icon', 'pencil-square')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'auto_save_flg', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_wisiwyg_flg', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_customitem_flg', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_multipage_flg', '0')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'comment_type', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_publish_end_at_flg', '1')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_category_flg', '1')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_tag_flg', '1')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_addition_flg', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_content_flg', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_slug_flg', '0')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'use_list_eyecatch_flg', '1')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'eyecatch_frame', 'fr_admin/eyecatch')", // added in v3.0.0
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'customitem_position', '2')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'posts_list_num', '10')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'posts_sort_order', 'DESC')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'posts_column03', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'posts_category_num', '2')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'posts_tag_num', '2')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'comments_list_num', '10')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'review_max_score', '5')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'label_title', '{$REC_POSTTYPE_LABELTITLE[$lang]}')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'label_addition', '{$REC_POSTTYPE_LABELADDITION[$lang]}')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1, 'label_content', '{$REC_POSTTYPE_LABELCONTENT[$lang]}')",
	
	"INSERT INTO `{$table_prefix}posttypes` (`id`, `site_id`, `name`, `slug`, `line_order`, `status`, `delete_flg`) VALUES
	(1001, '0001', '{$REC_POSTTYPE_DEFAULTCONTACT[$lang]}', 'contact', 1, 1, 0)",
	
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'use_customitem_flg', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'contacts_list_num', '10')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'contacts_sort_order', 'DESC')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'contacts_column01', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'contacts_column03', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'contacts_category_num', '2')",
	
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'use_auto_reply_admin', '0')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_language', 'unicode')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_to', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_from', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_from_name', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_subject', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_body_head', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_body_main', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'use_input_values_admin', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_body_bottom', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'admin_signature', '')",
	
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'use_auto_reply_customer', '0')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_language', 'unicode')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_to', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_from', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_from_name', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_subject', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_body_head', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_body_main', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'use_input_values_customer', '1')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_body_bottom', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'customer_signature', '')",
	
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'use_smtp', '0')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'host', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'user_name', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'password', '')",
	"INSERT INTO `{$table_prefix}configs_posttype` (`site_id`, `posttype_id`, `item`, `value`) VALUES(0, 1001, 'port', '')",
	
	
	"INSERT INTO `{$table_prefix}languages` (`id`, `name`, `slug`, `line_order`, `status`, `delete_flg`) VALUES
	(1, '{$REC_LANGUAGE_DEFAULTLANGUAGE[$lang]}', 'default', 1, 1, 0)",
	
	"INSERT INTO `{$table_prefix}image_frames` (`parent_dir`, `child_dir`, `type`, `width`, `height`, `comment`) VALUES ('fr_admin', 'eyecatch', 'auto', '480', '', '{$REC_IMAGEFRAME_ADMINEYECATCH[$lang]}');",
	"INSERT INTO `{$table_prefix}image_frames` (`parent_dir`, `child_dir`, `type`, `width`, `height`, `comment`) VALUES ('fr_admin', 'one', 'auto', '640', '', '{$REC_IMAGEFRAME_ADMINDEFAUTIMAGE[$lang]}');",
	"INSERT INTO `{$table_prefix}image_frames` (`parent_dir`, `child_dir`, `type`, `width`, `height`, `comment`) VALUES ('fr_admin', 'list', 'crop', '120', '120', '{$REC_IMAGEFRAME_ADMINLIST[$lang]}');", // added in v3.0.0
	"INSERT INTO `{$table_prefix}image_frames` (`parent_dir`, `child_dir`, `type`, `width`, `height`, `comment`) VALUES ('fr_admin', 'gallery', 'crop', '360', '360', '{$REC_IMAGEFRAME_ADMINDEFAUTGALLERY[$lang]}');",
	"INSERT INTO `{$table_prefix}image_frames` (`parent_dir`, `child_dir`, `type`, `width`, `height`, `comment`) VALUES ('fr_auto', '01', 'auto', '640', '', '{$REC_IMAGEFRAME_DEFAUTAUTO_01[$lang]}');",
	"INSERT INTO `{$table_prefix}image_frames` (`parent_dir`, `child_dir`, `type`, `width`, `height`, `comment`) VALUES ('fr_crop', '01', 'crop', '480', '480', '{$REC_IMAGEFRAME_DEFAUTCROP_01[$lang]}');",
	
	"INSERT INTO `{$table_prefix}posts_base` (`id`, `hash_id`, `version`, `versioned_at`, `publish_datetime`, `category_id`, `tag_id`, `slug`, `created_at`, `created_by`) VALUES
	(1, '{$first_post_hash_id}', 1, '{$now}', '{$now}', '0000', '0000', 'welcome-postease', '{$now}', 1);",
	
	"INSERT INTO `{$table_prefix}posts_text` (`base_id`, `base_version`, `language_id`, `title`, `addition`, `content`) VALUES
	(1, 1, 1, '{$REC_POSTSTEXT_DUMMYTITLE[$lang]}', '', '{$REC_POSTSTEXT_DUMMYCONTENT[$lang]}');",
	
	"INSERT INTO `{$table_prefix}contacts_base` (`id`, `title`, `content`, `name`, `email`, `tel`, `contacted_at`, `created_at`) VALUES
	(1, '{$REC_CONTACTSTEXT_DUMMYTITLE[$lang]}', '{$REC_CONTACTSTEXT_DUMMYCONTENT[$lang]}', '{$REC_CONTACTSTEXT_DUMMYNAME[$lang]}', '{$REC_CONTACTSTEXT_DUMMYEMAIL[$lang]}', '{$REC_CONTACTSTEXT_DUMMYTEL[$lang]}', '{$now}', '{$now}')",
	
	"INSERT INTO `{$table_prefix}update_histories` (`applied_version`, `applied_level`, `applied_detail`, `applied_at`) VALUES
	('{$postease_version}', 0, '{$REC_UPDATEHISTORIES_APPLIEDDETAIL[$lang]}', '{$now}');",
);

