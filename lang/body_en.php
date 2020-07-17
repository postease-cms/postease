<?php
/* LBL - ラベル
 * WAR - 警告
 * ALT - アラート
 * MSG - メッセージ
 * COM - コメント
 * LNK - リンク
 * VAL - バリュー
 * SEL - セレクト
 * BTN - ボタン
 * PLH - プレースホルダー
 * THD - テーブルヘディング
 */


/*
 * GLOBAL
 * ------------------------------------------------------------------------------------------------ */
define('TXT_GLOBAL_UNT_COUNT', '');
define('TXT_GLOBAL_UNT_SCORE', '');


/*
 * header
 * ------------------------------------------------------------------------------------------------ */
define('TXT_HEADER_TITLE', 'dashboard');


/*
 * global_navi
 *
 *  */
define('TXT_GNAVI_LNK_LOGOUT', 'logout');


/*
 * main_menu
 * ------------------------------------------------------------------------------------------------ */
define('TXT_MAINMENU_LBL_EDIT',           'Edit');
define('TXT_MAINMENU_LBL_LIST',           'List');
define('TXT_MAINMENU_LBL_NEW',            'New');
define('TXT_MAINMENU_LBL_CATEGORY',       'Categories');
define('TXT_MAINMENU_LBL_TAG',            'Tags');
define('TXT_MAINMENU_LBL_CUSTOMITEM',     'Custom items');
define('TXT_MAINMENU_LBL_CONTACT',        'Contact');
define('TXT_MAINMENU_LBL_CONFIGPOSTTYPE', 'Config');
define('TXT_MAINMENU_LBL_CONFIGCONTACT',  'Config');
define('TXT_MAINMENU_LBL_INQUIRY',        'Query');
define('TXT_MAINMENU_LBL_MEDIA',          'Media');
define('TXT_MAINMENU_LBL_IMAGE_CONFIG',   'Image flame');
define('TXT_MAINMENU_LBL_USER',           'User');
define('TXT_MAINMENU_LBL_GROUP',          'Group');
define('TXT_MAINMENU_LBL_CHANGE_PASS',    'Update Account');
define('TXT_MAINMENU_LBL_SITE_OPTION',    'Site option');
define('TXT_MAINMENU_LBL_SITE',           'Site');
define('TXT_MAINMENU_LBL_POSTTYPE',       'Post-type');
define('TXT_MAINMENU_LBL_LANGUAGE',       'Language');
define('TXT_MAINMENU_LBL_CONFIG',         'Config');
define('TXT_MAINMENU_LBL_GENERAL',        'General');
define('TXT_MAINMENU_LBL_OPTION',         'Option');
define('TXT_MAINMENU_LBL_CORE',           'Core');


/*
 * _reset_system
 * ------------------------------------------------------------------------------------------------ */
define('TXT_RESETSYSTEM_LBL_DATABASE_FIRSTSET', 'Database');
define('TXT_RESETSYSTEM_LBL_DATABASE_CHANGEDB', 'Migration Database');

/*
 * reset_system
 * ------------------------------------------------------------------------------------------------ */
define('TXT_RESETSYSTEM_TITLE',                   'Management screen | Initial settings');
define('TXT_RESETSYSTEM_LNK_BACKCONFIG',          'Back');
define('TXT_RESETSYSTEM_LNK_BACKLOGIN',           'Cancel');
define('TXT_RESETSYSTEM_LBL_HINT_ERR10',          'Why can\'t I connect to the database I\'m setting up?');
define('TXT_RESETSYSTEM_LBL_GETACTIVATIONKEY',    'Get activation key');
define('TXT_RESETSYSTEM_PLH_VALIDEMAIL',          'Enter an email address that can be received');
define('TXT_RESETSYSTEM_BTN_GETACTIVATIONKEY',    'Get');
define('TXT_RESETSYSTEM_LBL_REQUIRED',            'Required');
define('TXT_RESETSYSTEM_LBL_ACTIVATIONKEY',       'Activation key');
define('TXT_RESETSYSTEM_PLH_ACTIVATIONKEY',       'Activation key (please check the email)');
define('TXT_RESETSYSTEM_ALT_ACTIVATIONKEY',       'Enter the activation key provided in the email.');
define('TXT_RESETSYSTEM_ALT_INVALIDEMAIL',        'Enter the correct email address you can receive.');
define('TXT_RESETSYSTEM_LBL_EMAIL',               'Email');
define('TXT_RESETSYSTEM_PLH_EMAIL',               'Email');
define('TXT_RESETSYSTEM_WAR_REUSE_ACTIVATIONKEY', 'If you want to reuse this activation key, please enter the email address you used to download it. If you reuse the activation key, you will not be able to use the previous system that was installed with the same activation key.');
define('TXT_RESETSYSTEM_WAR_RESET_ACTIVATIONKEY', 'If you want to reconfigure your system by copying (moving) the system or changing your domain, enter the email address you used to download it. <br> if you reconfigure this system, you will not be able to use other systems with the same activation key assigned.');
define('TXT_RESETSYSTEM_LBL_SITENAME',            'Site name');
define('TXT_RESETSYSTEM_PLH_SITENAME',            'Site name (you can change it later)');
define('TXT_RESETSYSTEM_LBL_ACCOUNT',             'Account');
define('TXT_RESETSYSTEM_PLH_ACCOUNT',             'Account (email address recommended / can be changed later)');
define('TXT_RESETSYSTEM_ALT_ACCOUNT',             'Start with the alphabet (and use only _) and need between 3 and 32 characters.');
define('TXT_RESETSYSTEM_LBL_NICKNAME',            'Nickname');
define('TXT_RESETSYSTEM_PLH_NICKNAME',            'Nickname (you can change it later)');
define('TXT_RESETSYSTEM_LBL_PASSWORD',            'Password');
define('TXT_RESETSYSTEM_PLH_PASSWORD',            'Password (you can change it later)');
define('TXT_RESETSYSTEM_BTN_AUTOGENERATEPASSWORD','Auto generate');
define('TXT_RESETSYSTEM_ALT_PASSWORD',            'You can use half-width alphanumeric characters and symbols (/*-+.,!? #$% ()-|_). Please enter between 7 and 32 characters.');
define('TXT_RESETSYSTEM_LBL_TIMEZONE',            'Timezone');
define('TXT_RESETSYSTEM_PLH_DATABASE',            'Database');
define('TXT_RESETSYSTEM_LBL_CHANGEDB',            'Migrate databases');
define('TXT_RESETSYSTEM_LBL_TABLEPREFIX',         'Table prefix');
define('TXT_RESETSYSTEM_PLH_TABLEPREFIX',         'Ex) postease_');
define('TXT_RESETSYSTEM_ALT_TABLEPREFIX',         'Please enter between 2 and 8 characters in half-width lowercase letters and 8 characters.');
define('TXT_RESETSYSTEM_BTN_AUTOGENERATEPREFIX',  'Auto generate');
define('TXT_RESETSYSTEM_LBL_DBHOST',              'DB host');
define('TXT_RESETSYSTEM_PLH_DBHOST',              'For MySQL only');
define('TXT_RESETSYSTEM_LBL_DBNAME',              'DB name');
define('TXT_RESETSYSTEM_PLH_DBNAME',              'For MySQL only');
define('TXT_RESETSYSTEM_LBL_DBUSER',              'DB user');
define('TXT_RESETSYSTEM_PLH_DBUSER',              'For MySQL only');
define('TXT_RESETSYSTEM_LBL_DBPASS',              'DB password');
define('TXT_RESETSYSTEM_PLH_DBPASS',              'For MySQL only');
function TXT_RESETSYSTEM_MSG_USINGDB($database)   { return $text = "Currently using {$database}";}
function TXT_RESETSYSTEM_MSG_PREVIOUSACTIVATIONKEY($activation_key) { return $text = "The original activation key is {$activation_key}.";}


/*
 * _login
 * ------------------------------------------------------------------------------------------------ */
define('TXT_LOGIN_WAR_LOGIN',   'Incorrect account or password');
define('TXT_LOGIN_WAR_IP',      'Bad IP address');
define('TXT_LOGIN_WAR_SESSION', 'Unexpected error');

/*
 * login
 * ------------------------------------------------------------------------------------------------ */
define('TXT_LOGIN_LBL_ACCOUNT',        'ACCOUNT');
define('TXT_LOGIN_PLH_ACCOUNT',        'Enter your account');
define('TXT_LOGIN_LBL_PASSWORD',       'PASSWORD');
define('TXT_LOGIN_PLH_PASSWORD',       'Enter your password');
define('TXT_LOGIN_LBL_REMEMBER',       'Remember me');
define('TXT_LOGIN_VAL_DISABLELOGIN',   'Contact system administrator');
define('TXT_LOGIN_LNK_CONFIRMSETTING', '');
define('TXT_LOGIN_VAL_SUBMIT',         'LOGIN');


/*
 * _index
 * ------------------------------------------------------------------------------------------------ */
function TXT_INDEX_LABEL_SMARTCACHE($use_advanced_cache = 0, $license_type = 0)
{
	return $label = ($use_advanced_cache && $license_type > 0) ? 'Smart Cache Advance' : 'Smart Cache';
}
function TXT_INDEX_LINK_TURN_SMARTCACHE($use_advanced_cache = 0, $license_type = 0)
{
	$html = 'Faster "Smart Cache Advance" is available for "Advanced" licenses and above.';
	if ($license_type > 0)
	{
		$html = ($use_advanced_cache) ? '<a href="javascript:turnFunction(\'use_advanced_cache_flg\', 0);">Disabled Smart Cache Advance</a>' : '<a href="javascript:turnFunction(\'use_advanced_cache_flg\', 1);">Enabled Smart Cache Advance</a>';
	}
	return $html;
}
function TXT_INDEX_MSG_SMARTCACHE_VALID($use_advanced_cache = 0, $license_type = 0, $license_valid_to = null)
{
	$text = 'This feature is always enabled by default.';
	if ($use_advanced_cache)
	{
		if ($license_type > 0 && $license_valid_to)
		{
			$valid_to = ($license_valid_to == '9999-99-99') ? 'indefinitely' : ' '. 'until ' . date('Y/m/d', strtotime($license_valid_to));
			$text = "This feature is available {$valid_to}";
		}
	}
	return $text;
}
define('TXT_INDEX_LABEL_VERSION',      'Versioning');
function TXT_INDEX_LINK_TURN_VERSION($use_version = 0, $license_type = 0)
{
	$html = '"Versioning" is available for "Advanced" licenses and above.';
	if ($license_type > 0)
	{
		$html = ($use_version) ? '<a href="javascript:turnFunction(\'use_version_flg\', 0);">Disabled Versioning</a>' : '<a href="javascript:turnFunction(\'use_version_flg\', 1);">Enabled Versioning</a>';
	}
	return $html;
}
function TXT_INDEX_MSG_VERSION_VALID($use_version = 0, $license_type = 0, $license_valid_to = null)
{
	$text = 'This feature is not valid.';
	if ($use_version)
	{
		if ($license_type > 0 && $license_valid_to)
		{
			$valid_to = ($license_valid_to == '9999-99-99') ? 'indefinitely' : ' '. 'until ' . date('Y/m/d', strtotime($license_valid_to));
			$text = "This feature is available {$valid_to}";
		}
	}
	return $text;
}


/*
 * index
 * ------------------------------------------------------------------------------------------------ */
define('TXT_INDEX_WAR_PASSWORD_01',         'Password remains the default. <a href="?view_page=change_password">Change from here</a>.');
define('TXT_INDEX_WAR_PASSWORD_02',         'Your password has not been changed for more than 3 months.');
define('TXT_INDEX_LBL_SUMMARY',             'Summary');
define('TXT_INDEX_LBL_POST_TOTAL',          'Total posts');
define('TXT_INDEX_LBL_PAGE',                'Underlying pages');
define('TXT_INDEX_LBL_POSTPAGE',            'Total pages');
define('TXT_INDEX_WAR_NO_POSTTYPE',         'There is no post type set for this site.');
define('TXT_INDEX_WAR_CORRECT_DOMAIN',      'Applying domain changes. Do not take action while this message is issued.');
define('TXT_INDEX_WAR_CORRECT_DIRNAME',     'Applying path changes. Do not take action while this message is issued.');
define('TXT_INDEX_LBL_CONTACT_TOTAL',       'Total contacts');
define('TXT_INDEX_WAR_NO_CONTACT',          'There is no contact type set for this site.');
define('TXT_INDEX_LBL_IMPLEMENT_CODE',      'Common implementation code');
define('TXT_INDEX_MSG_LOGINASSITEADMIN',    'You are logged in as Site Administrator.');
define('TXT_INDEX_MSG_LOGINASSYSTEMADMIN',  'You are logged in as System Administrator. All operations are possible.');
define('TXT_INDEX_MSG_ABOUTSYSTEM',         'About this system');
define('TXT_INDEX_MSG_SMARTCACHE',          'This feature is always enabled');
define('TXT_INDEX_MSG_VERSION',             'Versioning');

function TXT_INDEX_WELCOME($nickname)                { return $text = 'Hello, ' . $nickname . ' ！';}
function TXT_INDEX_WAR_DOMAIN($domain)               { return $text = 'The domain you are accessing is different from the configuration domain. Configuration domain is ' . $domain . '. Please correct it in the menu "Settings" "Core".';}
function TXT_INDEX_WAR_DIR($dir)                     { return $text = 'The directory name you are accessing is different from the configuration directory name. Configuration directory name is ' . $dir . '. Please correct it in the menu "Settings" "Core".';}
function TXT_INDEX_WAR_SQLITEPERMISSION($perm)       { return $text = 'SQLite does not have write permission. Change to the appropriate permissions. The current permission is ' . $perm . '.';}
function TXT_INDEX_WAR_BUSINESSLICENSE($days, $date) { return $text = 'Advanced License expires in ' . $days . ' days(Expiration date is ' . date('Y-m-d', strtotime($date)) . ' ). Please purchase a new Advanced License from <a target="_blank" href="https://classic.postease.org/license/">the service site</a>.<br><a href="?view_page=about_system">Here</a> you can check the activation key required to purchase an advanced license.';}
function TXT_INDEX_MSG_LOGIN_DATETIME($datetime)     { return $text = 'Logged in at ' . $datetime;}
function TXT_INDEX_LBL_SMARTCACHE($license = 0)
{
	$label = 'Smart Cache';
	if ($license > 0)
	{
		$label = 'Smart Cache Advance';
	}
	return $label;
}
function TXT_INDEX_LBL_NOTICE_DRAFT($count_parent = 0, $count_child = 0)
{
	$txt_post = ($count_parent == 1) ? "There is one draft post." : "There are {$count_parent} draft posts.";
	$txt_page = ($count_child == 1) ? "There is one draft page." : "There are {$count_child} draft pages.";
	if ($count_parent > 0 && $count_child == 0)
	{
		return $text = $txt_post;
	}
	elseif ($count_parent == 0 && $count_child > 0)
	{
		return $text = $txt_page;
	}
	elseif ($count_parent > 0 && $count_child > 0)
	{
		
		return $text = $txt_post . ' / ' . $txt_page;
	}
	return false;
}


/*
 * about_system
 * ------------------------------------------------------------------------------------------------ */
define('TXT_ABOUTSYSTEM_LBL_TITLE',            'About POSTEASE');
define('TXT_ABOUTSYSTEM_THD_THISVERSION',      'Version');
define('TXT_ABOUTSYSTEM_THD_LICENSE',          'License');
define('TXT_ABOUTSYSTEM_LBL_LICENSEBASIC',     'Basic');
define('TXT_ABOUTSYSTEM_LBL_LICENSEADVANCED',  'Advanced');
define('TXT_ABOUTSYSTEM_LBL_LICENSEBUSINESS',  'Business');
define('TXT_ABOUTSYSTEM_ALT_FAILLICENSE',      'Failed to obtain a license.');
define('TXT_ABOUTSYSTEM_LBL_UNLIMITED',        'Indefinitely');
define('TXT_ABOUTSYSTEM_THD_ACTIVATIONKEY',    'Activation Key');
define('TXT_ABOUTSYSTEM_THD_DATABASE',         'Database');
define('TXT_ABOUTSYSTEM_LBL_UPDATEHISTORIY',   'Update history');
define('TXT_ABOUTSYSTEM_LBL_APPLYLEVEL',       'Update type');
define('TXT_ABOUTSYSTEM_THD_APPLIEDVERSION',   'Version');
define('TXT_ABOUTSYSTEM_THD_APPLIEDLEVEL',     'Update type');
define('TXT_ABOUTSYSTEM_LBL_DELTEXT_UPDATE',   'Update');
define('TXT_ABOUTSYSTEM_THD_APPLIEDAT',        'Application date');
define('TXT_ABOUTSYSTEM_THD_APPLIEDDETAIL',    'Detail');
define('TXT_ABOUTSYSTEM_LBL_PURCHASEHISTORIY', 'Purchased history');
define('TXT_ABOUTSYSTEM_THD_PURCHASEDAT',      'Purchased date');
define('TXT_ABOUTSYSTEM_THD_EXTRALICENSECODE', 'Purchased license');
define('TXT_ABOUTSYSTEM_THD_PURCHASEPRICE',    'Price');
define('TXT_ABOUTSYSTEM_THD_VALID',            'Expiration date');
function TXT_ABOUTSYSTEM_MSG_VALIDTO($valid_to) { return $text = 'Valid until ' . $valid_to;}


/*
 * _posts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTS_PAGETITLE_SUB', 'List');
define('TXT_POSTS_MSG_NEWPOST',   'New post completed');
function TXT_POSTS_MSG_UPDATE($number, $target){ return $text = "{$number} updated";}
function TXT_POSTS_MSG_CLONE($number, $target){ return $text = "{$number} copied";}
function TXT_POSTS_MSG_DELETE($number, $target){ return $text = "{$number} deleted";}

/*
 * posts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTS_LBL_CHANGE_LANGUAGE',       'Change Language');
define('TXT_POSTS_SEL_DEFAULT_STATUS',        'All Status');
define('TXT_POSTS_SEL_DEFAULT_CATEGORY',      'All Categories');
define('TXT_POSTS_SEL_DEFAULT_TAG',           'All Tags');
define('TXT_POSTS_PLH_SEARCH_TEXT',           'Search text');
define('TXT_POSTS_PLH_SEARCH_STARTDATE',      'Publish date (from)');
define('TXT_POSTS_PLH_SEARCH_ENDDATE',        'Publish date (to)');
define('TXT_POSTS_PLH_SEARCH_CREATEDBY',      'All Contributors');
define('TXT_POSTS_SEL_DEFAULT_ANCHOR',        'All Anchors (or none)');
define('TXT_POSTS_SEL_HAS_ANCHOR',            'With Anchor');
define('TXT_POSTS_LBL_ANCHOR',                'Anchor');
define('TXT_POSTS_SEL_NO_ANCHOR',             'Without Anchor');
define('TXT_POSTS_LBL_SEARCH_CLEAR',          'Clear');
define('TXT_POSTS_THD_STATUS',                'Status');
define('TXT_POSTS_THD_CATEGORY',              'Categories');
define('TXT_POSTS_THD_TAG',                   'Tags');
define('TXT_POSTS_THD_POSTEDBY',              'Created by');
define('TXT_POSTS_THD_UPDATEDBY',             'Updated by');
define('TXT_POSTS_THD_COMMENT',               'Comment');
define('TXT_POSTS_THD_REVIEW',                'Review');
define('TXT_POSTS_THD_SUBPOST',               'Sub Post');
define('TXT_POSTS_THD_PUBLISHDATE',           'Publish date');
define('TXT_POSTS_LBL_FUTURE',                'reserved');
define('TXT_POSTS_LBL_PUBLISHED',             'published');
define('TXT_POSTS_LBL_ENDED',                 'closed');
define('TXT_POSTS_LBL_DRAFT',                 'draft');
define('TXT_POSTS_LBL_PRIVATE',               'unpublish');
define('TXT_POSTS_LBL_NOTITLE',               '（..no title）');
define('TXT_POSTS_LNK_OTHERS',                '..other');
define('TXT_POSTS_LBL_NOSETTING',             'No setting');
define('TXT_POSTS_LBL_CHECKALL',              'Check all');
define('TXT_POSTS_LBL_ALLOWDELETE',           'Allow delete');
define('TXT_POSTS_BTN_TO_PUBLISH',            'publish');
define('TXT_POSTS_BTN_TO_DRAFT',              'draft');
define('TXT_POSTS_BTN_TO_PRIVATE',            'unpublish');
define('TXT_POSTS_LBL_CLONE',                 'Copy');
define('TXT_POSTS_BTN_CLONE',                 'copy');
define('TXT_POSTS_LBL_DELETE',                'Delete');
define('TXT_POSTS_BTN_DELETE',                'delete');
define('TXT_POSTS_PLH_CHANGEPUBLISHDATETIME', 'publish date');
define('TXT_POSTS_LBL_CHANGEPUBLISHDATETIME', 'update publish date');
define('TXT_POSTS_LBL_ADDTAXONOMY',           'Add');
define('TXT_POSTS_LBL_DELETETAXONOMY',        'Delete');
define('TXT_POSTS_SEL_OPERATION_CATEGORY',    'Categories');
define('TXT_POSTS_SEL_OPERATION_TAG',         'Tags');
define('TXT_POSTS_LBL_IMPLEMENT_CODE',        'Implementation code');
function TXT_POSTS_WAR_NOPOST($target)            { return $text = "There are no {$target} for this condition";}
function TXT_POSTS_LBL_CHANGESTATU_TO($target)    { return $text = "For checked {$target}";}
function TXT_POSTS_LBL_CHANGECATEGORY_TO($target) { return $text = "For checked {$target}";}
function TXT_POSTS_LBL_PUBLISHTENDAT($datetime)   { return $text = "until {$datetime}";}
function TXT_POSTS_LNK_GETSDKPHP($url) { return $text = '<a target="_blank" href="' . $url . '">Get an SDK </a>to retrieve data from the POSTSEASE API.';}


/*
 * _post
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POST_LBL_NEW',                'New');
define('TXT_POST_LBL_EDIT',               'Edit');
define('TXT_POST_BTN_UPDATE',             'Update and Republish');
define('TXT_POST_BTN_PUBLISH',            'Publish');
define('TXT_POST_BTN_VERSIONPUBLISH',     'Replace(publish)');
define('TXT_POST_LNK_BACKTOLIST',         'back to list');
define('TXT_POST_LNK_PREVIEWLINK',        'preview');
define('TXT_POST_MSG_PERMALINKNOTYET',    'No permlink has been created.');
define('TXT_POST_LNK_PERMALINKLACKITEMS', 'Slug or title and publish date and time are required to generate a perm link.');
define('TXT_POST_LNK_PERMALINK',          'permalink');
define('TXT_POST_MSG_CHILDNEWPOST',       'Added a new page.');
define('TXT_POST_MSG_CHILDUPDATE',        'The page has been updated.');
define('TXT_POST_MSG_CHILDDELETE',        'The page has been deleted.');
define('TXT_POST_MSG_VERSIONDELETE',      'The version has been Deleted.');
define('TXT_POST_LBL_IMPLEMENT_CODE',     'Implementation code');
function TXT_POST_LNK_PREVIEW($preview_link) { return $text = "Preview ({$preview_link})";} // no use after v3.0.0
function TXT_POST_STATUSTEXT($status, $label, $current_flg = 1)
{
	$status_text = array(
		'primary' => 'published',
		'warning' => 'draft',
		'default' => 'unpublish',
	);
	$publish_status_text = array(
		'primary' => 'published',
		'info'    => 'reserved',
		'default' => 'closed',
	);
	if ($current_flg == 0 && $status == 1)
	{
		$text = 'archived';
	}
	else {
		$text = ($status) ? ($status == 1) ? $publish_status_text[$label] : $status_text[$label] : 'Uncreated';
	}
	return $text;
}

/*
 * post
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POST_LBL_NEWPAGE',                       'New page');
define('TXT_POST_LBL_RELEASEDVERSION',               'Published version');
define('TXT_POST_LBL_PRIVATEVERSION',                'Unpublished version');
define('TXT_POST_MSG_UNEDITABLE',                    'You do not have edit permission.');
define('TXT_POST_LBL_AUTOSAVEMODE',                  'Autosave');
define('TXT_POST_MSG_SAVED',                         'saving..');
define('TXT_POST_LBL_HAS_NEW_DRAFTVERSION'         , 'There is a new draft version that you are editing.');
define('TXT_POST_LBL_AUTOSAVEMODE_CANCELED_PUBLISH', 'Autosave is disabled when published. The data is not updated until "Update and Republish"');
define('TXT_POST_LBL_AUTOSAVEMODE_CANCELED_ARCHIVE', 'Autosave is disabled when archived. The data is not updated until "Replace(publish)".');
define('TXT_POST_PLH_LIST',                          'The list separator is a newline.');
define('TXT_POST_PLH_GALLERY_CAPTION',               'Caption');
define('TXT_POST_LBL_SELECTDEFAULT',                 'Select');
define('TXT_POST_BTN_IMG_SET',                       'Set / Reset');
define('TXT_POST_BTN_IMG_DELETE',                    'Delete');
define('TXT_POST_LBL_TITLE',                         'Title');
define('TXT_POST_LBL_ADDITION',                      'Description');
define('TXT_POST_LBL_CONTENT',                       'Content');
define('TXT_POST_BTN_SAVE',                          'Save');
define('TXT_POST_BTN_DELETE',                        'Delete');
define('TXT_POST_BTN_NEW_VERSION',                   'Draft a new version');
define('TXT_POST_MSG_VERSION_OFF',                   'Versioning is currently disabled.');
define('TXT_POST_MSG_DELETEPOSTNORMAL',              'Once a post has been deleted, it cannot be undone. Are you sure you want to delete this post?');
define('TXT_POST_MSG_DELETEPOSTCHILD',               'Once a page has been deleted, it cannot be undone. Are you sure you want to delete this page?');
define('TXT_POST_MSG_DELETEPOSTPRIVATE',             'Once deleted, the version cannot be undone. Are you sure you want to delete this version?');
define('TXT_POST_MSG_DELETEPOSTPRIVATEALL',          'If you delete this version, all related pages will also be Deleted at the same time. Once delete, it can not be undone. Are you sure you want to delete it?');
define('TXT_POST_MSG_DELETEPOSTCHILDLEN',            'If you delete this post, all related pages will also be Deleted at the same time. Once delete, it can not be undone. Are you sure you want to delete it?');
define('TXT_POST_MSG_DELETEPOSTCURRENT',             'If you delete this post, all relevant versions will also be Deleted at the same time. Once delete, it can not be undone. Are you sure you want to delete it?');
define('TXT_POST_MSG_DELETEPOSTRELATEDALL',          'If you delete this post, all relevant pages and all versions will also be Deleted at the same time. Once delete, it can not be undone. Are you sure you want to delete it?');
define('TXT_POST_LBL_VERSION',                       'Versioning');
define('TXT_POST_LBL_VERSION_ARCHIVED',              'Archived version');
define('TXT_POST_LBL_VERSION_CURRENT',               'Current published version');
define('TXT_POST_LBL_VERSION_DRAFT',                 'Draft version in Edit');
define('TXT_POST_LBL_CHANGECURRENT',                 'Replace(publish)');
define('TXT_POST_LBL_DELETEVERSION',                 'Delete this version');
define('TXT_POST_LBL_NEWVERSION',                    'New version');
define('TXT_POST_LBL_ALLOWDELETEVERSION',            'Allow deletion of archived versions');
define('TXT_POST_LBL_SLUG',                          'Slug');
define('TXT_POST_LBL_CHANGE_SLUG',                   'Update');
define('TXT_POST_PLH_SLUG',                          'It becomes a part of the URL. Alphanumeric characters and "_" and "-" are available.');
define('TXT_POST_PLH_TITLEWITHSLUG',                 'If slug is not set, it will be part of the URL.');
define('TXT_POST_LBL_PUBLISHDATETIME',               'Publish date and time');
define('TXT_POST_LBL_PUBLISHENDAT',                  'Publish end date and time');
define('TXT_POST_PLH_PUBLISHDATE',                   'Publish date');
define('TXT_POST_PLH_PUBLISHTIME',                   'Publish time');
define('TXT_POST_LBL_ANCHOR',                        'Anchor');
define('TXT_POST_LBL_STATUS',                        'Publishing status');
define('TXT_POST_LBL_PUBLISHED',                     'published');
define('TXT_POST_LBL_PRIVATE',                       'unpublish');
define('TXT_POST_LBL_SITE',                          'Site');
define('TXT_POST_LBL_POSTTYPE',                      'Post-type');
define('TXT_POST_LBL_EYECATCH',                      'Eyecatch image');
define('TXT_POST_LBL_CATEGORY',                      'Categories');
define('TXT_POST_LBL_NOLABEL',                       '..No label');
define('TXT_POST_MSG_NOCATEGORY',                    'No category');
define('TXT_POST_LBL_TAG',                           'Tags');
define('TXT_POST_LBL_CREATEATBY',                    'Post');
define('TXT_POST_LBL_UPDATEATBY',                    'Last updated');
define('TXT_POST_MSG_NOTAG',                         'No Tag');
define('TXT_POST_LBL_NEWCOMMENT',                    'New');
define('TXT_POST_MSG_ALLOWDELETEPOST',               'Allow post deletion');
define('TXT_POST_MSG_ALLOWDELETEPAGE',               'Allow page deletion');
define('TXT_POST_MSG_ALLOWDELETEVERSION',            'Allow version deletion');
define('TXT_POST_WAR_NOLANGUAGE',                    'This site does not have a language setting. Please set it from "Options" "Multilingual".');
function TXT_POST_LBL_CHANGESTATUS_SAVE($status){ return $text = "Update to \"{$status}\"";}
function TXT_POST_PLH_TABLE($delimiter)         { return $text = "The column is delimited by {$delimiter}. Line breaks are line breaks.";}
function TXT_POST_LNK_TURN_AUTOSAVE($turn_from)
{
	$turn = ($turn_from) ? 'Disabled' : 'Enabled';
	return $text = "Make autosave \"{$turn}\"";
};


/*
 * _comments
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COMMENTS_PAGETITLE_SUB',     'List');
define('TXT_COMMENTS_MSG_NEWPOST',       'New post completed');
define('TXT_COMMENTS_LBL_POSTNOTITLE',   '（..No title）');
define('TXT_COMMENTS_LBL_POSTNOCONTENT', '（..No content）');
function TXT_COMMENTS_MSG_UPDATE($number, $target){ return $text = "Updated {$number} {$target}";}
function TXT_COMMENTS_MSG_DELETE($number, $target){ return $text = "Deleted {$number} {$target}";}

/*
 * comments
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COMMENTS_LBL_SUBSTRATUM',       '下層');
define('TXT_COMMENTS_SEL_DEFAULT_STATUS',   '全てのステータス');
define('TXT_COMMENTS_SEL_DEFAULT_SCORE',    'スコア指定なし');
define('TXT_COMMENTS_PLH_SEARCH_TEXT',      'テキスト検索');
define('TXT_COMMENTS_PLH_SEARCH_STARTDATE', '投稿日指定（始まり）');
define('TXT_COMMENTS_PLH_SEARCH_ENDDATE',   '投稿日指定（終わり）');
define('TXT_COMMENTS_LBL_SEARCH_CLEAR',     'クリア');
define('TXT_COMMENTS_LBL_TARGETCOMMENT',    '対象コメント');
define('TXT_COMMENTS_THD_STATUS',           'ステータス');
define('TXT_COMMENTS_THD_TITLECONTENT',     'タイトル [内容]');
define('TXT_COMMENTS_THD_AUTHOR',           '投稿者');
define('TXT_COMMENTS_THD_SCORE',            'スコア');
define('TXT_COMMENTS_THD_POSTDATETIME',     '投稿日時');
define('TXT_COMMENTS_LBL_NEW',              'New');
define('TXT_COMMENTS_LBL_UPDATE',           '更新');
define('TXT_COMMENTS_LBL_FUTURE',           '未来');
define('TXT_COMMENTS_LBL_PUBLISHED',        'published');
define('TXT_COMMENTS_LBL_RESERVATION',      '保留');
define('TXT_COMMENTS_LBL_PRIVATE',          'unpublish');
define('TXT_COMMENTS_LBL_NOTITLE',          '（..無題）');
define('TXT_COMMENTS_LINK_NEW',             'New');
define('TXT_COMMENTS_LBL_CHECKALL',         '全てチェックする');
define('TXT_COMMENTS_LBL_ALLOWDELETE',      'Deleteを許可する');
define('TXT_COMMENTS_BTN_TO_PUBLISH',       '公開にする');
define('TXT_COMMENTS_BTN_TO_RESERVATION',   '保留にする');
define('TXT_COMMENTS_BTN_TO_PRIVATE',       '非公開にする');
define('TXT_COMMENTS_LBL_DELETE',           'Delete');
define('TXT_COMMENTS_BTN_DELETE',           'Deleteする');
function TXT_COMMENTS_NARROWDOWN_POSTID($target)  { return $text = "対象{$target}で絞込";}
function TXT_COMMENTS_LBL_TARGET($target)         { return $text = "対象{$target}";}
function TXT_COMMENTS_LNK_CREATE($target)         { return $text = "{$target}をNew作成する";}
function TXT_COMMENTS_LNK_REPLY($target)          { return $text = "関連{$target}をNew作成する";}
function TXT_COMMENTS_THD_RELATEDCOMMENT($target) { return $text = "関連{$target}";}
function TXT_COMMENTS_LBL_ACTION_TO($target)      { return $text = "チェックした{$target}を";}
function TXT_COMMENTS_WAR_NOCOMMENT($target)      { return $text = "この条件の{$target} はありません。";}


/*
 * _comment
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COMMENT_LBL_NEW',              'New投稿');
define('TXT_COMMENT_LBL_EDIT',             'Edit');
define('TXT_COMMENT_LBL_TARGET_NOTITLE',   '（..無題）');
define('TXT_COMMENT_LBL_TARGET_NOCONTENT', '（..内容の入力はありません）');
define('TXT_COMMENT_BTN_SUBMIT_POST',      '投稿');
define('TXT_COMMENT_BTN_SUBMIT_UPDATE',    '更新');
define('TXT_COMMENT_LNK_BACKLINK_CANCEL',  'キャンセル');
define('TXT_COMMENT_LNK_BACKLINK_BACK',    '一覧へ戻る');

/*
 * comment
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COMMENT_LBL_SCORE',       'スコア');
define('TXT_COMMENT_LBL_TITLE',       'タイトル');
define('TXT_COMMENT_LBL_CONTENT',     '内容');
define('TXT_COMMENT_VAL_PUBLISH',     '公開する');
define('TXT_COMMENT_VAL_PRIVATE',     '非公開にする');
define('TXT_COMMENT_LBL_AUTHORNAME',  '投稿者名');
define('TXT_COMMENT_LBL_AUTHOREMAIL', '投稿者メールアドレス');
define('TXT_COMMENT_LBL_AUTHORIP',    '投稿者IPアドレス');
define('TXT_COMMENT_LBL_MEMO',        'メモ');
define('TXT_COMMENT_BTN_DELETE',      'Delete');
define('TXT_COMMENT_LBL_POSTEDAT',    '投稿日時');
define('TXT_COMMENT_PLH_POSTEDAT',    '投稿日時');
define('TXT_COMMENT_LBL_STATUS',      '公開ステータス');
define('TXT_COMMENT_LBL_SITEID',      '対象サイト');
define('TXT_COMMENT_LBL_POSTTYPE',    '対象投稿タイプ');
define('TXT_COMMENT_LBL_CREATEDATBY',  '投稿');
define('TXT_COMMENT_LBL_UPDATEDATBY',  '最終更新');
define('TXT_COMMENT_LBL_NEWCOMMENT',  'New作成');
function TXT_COMMENT_LBL_CHANGESTATUS_SAVE ($status) { return $text = "{$status}にして閉じる";}
function TXT_COMMENT_MSG_NOCOMMENT ($target, $admin) { return $text = "この{$target}は管理画面から{$admin}により投稿されました。";}
function TXT_COMMENT_LBL_EDIT ($target)              { return $text = "この{$target}をEditする";}
function TXT_COMMENT_LBL_DELETE ($target)            { return $text = "この{$target}をDeleteする";}
function TXT_COMMENT_LBL_CHILDREN ($target)          { return $text = "子{$target}";}


/*
 * _contacts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACTS_PAGETITLE_MAIN', 'Contact');
define('TXT_CONTACTS_PAGETITLE_SUB',  'List');
define('TXT_CONTACTS_MSG_NEWCONTACT', 'New post completed');
function TXT_CONTACTS_MSG_UPDATE($number, $target){ return $text = "Updated {$number} {$target}";}
function TXT_CONTACTS_MSG_DELETE($number, $target){ return $text = "Deleted {$number} {$target}";}

/*
 * contacts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACTS_SEL_DEFAULT_STATUS',     'All Status');
define('TXT_CONTACTS_SEL_DEFAULT_WAY',        'All Contact route');
define('TXT_CONTACTS_SEL_DEFAULT_CATEGORY',   'All Categories');
define('TXT_CONTACTS_PLH_SEARCH_KEYWORD',     'Search text');
define('TXT_CONTACTS_PLH_SEARCH_DATESTART',   'Contact date (from)');
define('TXT_CONTACTS_PLH_SEARCH_DATEEND',     'Contact date (to)');
define('TXT_CONTACTS_LNK_SEARCH_CLEAR',       'Clear');
define('TXT_CONTACTS_THD_STATUS',             'Status');
define('TXT_CONTACTS_THD_TITLE',              'Title');
define('TXT_CONTACTS_THD_CONTENT',            'Body');
define('TXT_CONTACTS_THD_WAY',                'Contact route');
define('TXT_CONTACTS_THD_CATEGORY',           'Categories');
define('TXT_CONTACTS_THD_NAME',               'Name');
define('TXT_CONTACTS_THD_EMAIL',              'Email');
define('TXT_CONTACTS_THD_TEL',                'Phone number');
define('TXT_CONTACTS_THD_CONTACTEDAT',        'Contact date');
define('TXT_CONTACTS_LBL_NEW',                'New');
define('TXT_CONTACTS_LBL_UPDATE',             'Edit');
define('TXT_CONTACTS_LBL_COMPLETED',          'Done');
define('TXT_CONTACTS_LBL_ONGOING',            'In progress');
define('TXT_CONTACTS_LBL_UNCONFIRMED',        'Untreated');
define('TXT_CONTACTS_LBL_NOTITLE',            '（..No title）');
define('TXT_CONTACTS_LBL_CATEGORY_OTHER',     '..Other');
define('TXT_CONTACTS_LBL_CATEGORY_NOSETTING', 'No setting');
define('TXT_CONTACTS_LBL_CHECKALL',           'Check All');
define('TXT_CONTACTS_LBL_ALLOWDELETE',        'Allow delete');
define('TXT_CONTACTS_LBL_ACTION_TO',          'Change checked Contact to');
define('TXT_CONTACTS_BTN_TO_COMPLETED',       'Done');
define('TXT_CONTACTS_BTN_TO_ONGOING',         'In progress');
define('TXT_CONTACTS_BTN_TO_UNCONFIRMED',     'Untreated');
define('TXT_CONTACTS_LBL_DELETE',             'Delete');
define('TXT_CONTACTS_BTN_DELETE',             'Delete');
function TXT_CONTACTS_WAR_NOCONTACT($target){ return $text = "There are no {$target} for this condition";}


/*
 * _contact
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACT_PAGETITLEMAIN',        'Contact');
define('TXT_CONTACT_PAGETITLESUB_NEW',     'New');
define('TXT_CONTACT_PAGETITLESUB_INQUIRY', 'Query');
define('TXT_CONTACT_LNK_BACKTOLIST',       'Back to list');

/*
 * contact
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACT_LBL_TITLE',        'Title');
define('TXT_CONTACT_LBL_LANGUAGE',     'Receiving language');
define('TXT_CONTACT_LBL_CONTENT',      'Body');
define('TXT_CONTACT_LBL_NAME',         'Name');
define('TXT_CONTACT_LBL_EMAIL',        'Email');
define('TXT_CONTACT_LBL_TEL',          'Phone number');
define('TXT_CONTACT_LBL_ZIPCODE',      'Zip code');
define('TXT_CONTACT_LBL_ADDRESS',      'Address');
define('TXT_CONTACT_BTN_IMG_SET',      'Configure');
define('TXT_CONTACT_BTN_IMG_DELETE',   'Delete');
define('TXT_CONTACT_LBL_NOTE',         'Note');
define('TXT_CONTACT_BTN_CREATE',       'Create');
define('TXT_CONTACT_BTN_UPDATE',       'Edit');
define('TXT_CONTACT_BTN_DELETE',       'Delete');
define('TXT_CONTACT_BTN_TO_COMPLETED', 'Done');
define('TXT_CONTACT_BTN_TO_ONGOING',   'In progress');
define('TXT_CONTACT_LBL_CONTACTEDAT',  'Contact date');
define('TXT_CONTACT_LBL_STATUS',       'Status');
define('TXT_CONTACT_LBL_CONTACTWAY',   'Contact route');
define('TXT_CONTACT_LBL_LANGUAGEID',   'Receiving language');
define('TXT_CONTACT_LBL_CATEGORY',     'Categories');
define('TXT_CONTACT_MSG_NOCATEGORY',   'No registration category');
define('TXT_CONTACT_LBL_CREATEDATBY',  'New');
define('TXT_CONTACT_LBL_UPDATEDATBY',  'Last update at');
define('TXT_CONTACT_LBL_EDITCHECK',    'Edit contact');
define('TXT_CONTACT_LBL_DELETECHECK',  'Delete contact');
function TXT_CONTACT_LBL_CHANGESTATUS_SAVE ($status) { return $text = "Close with {$status}";}


/*
 * _media
 * ------------------------------------------------------------------------------------------------ */
define('TXT_MEDIA_PAGETITLEMAIN', 'Image');
define('TXT_MEDIA_PAGETITLESUB',  'Edit');


/*
 * _image_frame
 * ------------------------------------------------------------------------------------------------ */
define('TXT_IMAGEFRAME_PAGETITLEMAIN', 'Image flame');
define('TXT_IMAGEFRAME_PAGETITLESUB',  'Configure');
define('TXT_IMAGEFRAME_MSG_CREATED',   'New creation completed');
define('TXT_IMAGEFRAME_MSG_UPDATED',   'Update completed');
define('TXT_IMAGEFRAME_MSG_DELETED',   'Delete completed');

/*
 * image_frame
 * ------------------------------------------------------------------------------------------------ */
function TXT_IMAGEFRAME_LBL_NOWEDIT($target){ return $text = "Editing {$target}";}
define('TXT_IMAGEFRAME_LBL_IMAGEFRAME',     'Image settings');
define('TXT_IMAGEFRAME_LBL_DISALLOWDELETE', 'fr_admin directory cannot be deleted');
define('TXT_IMAGEFRAME_LBL_ALLOWDELETE',    'Allow delete');
define('TXT_IMAGEFRAME_LBL_CANCELEDIT',     'Cancel edit');
define('TXT_IMAGEFRAME_LBL_NEW',            'New');
define('TXT_IMAGEFRAME_LBL_TYPE',           'Type');
define('TXT_IMAGEFRAME_LBL_WIDTH',          'Width');
define('TXT_IMAGEFRAME_LBL_HEIGHT',         'Height');
define('TXT_IMAGEFRAME_LBL_COMMENT',        'Comment');
define('TXT_IMAGEFRAME_LBL_STATUS',         'Status');
define('TXT_IMAGEFRAME_BTN_UPDATE',         'Submit');
define('TXT_IMAGEFRAME_BTN_DELETE',         'Delete');
define('TXT_IMAGEFRAME_LBL_LIST',           'List');
define('TXT_IMAGEFRAME_THD_PARENT_DIR',     'Directory');
define('TXT_IMAGEFRAME_THD_TYPE',           'Type');
define('TXT_IMAGEFRAME_THD_WIDTH',          'Width');
define('TXT_IMAGEFRAME_THD_HEIGHT',         'Height');
define('TXT_IMAGEFRAME_THD_COMMENT',        'Comment');
define('TXT_IMAGEFRAME_THD_STATUS',         'Status');
define('TXT_IMAGEFRAME_LBL_USE',            'Enabled');
define('TXT_IMAGEFRAME_LBL_UNUSE',          'Disabled');
define('TXT_IMAGEFRAME_LBL_EDIT',           'Edit');
define('TXT_IMAGEFRAME_LBL_SIZEMAX',        'Max');


/*
 * _user
 * ------------------------------------------------------------------------------------------------ */
define('TXT_USER_PAGETITLEMAIN',       'User');
define('TXT_USER_PAGETITLESUB',        'Edit');
define('TXT_USER_MSG_USEDACCOUNT',     'The account is already in use.');
define('TXT_USER_MSG_UPDATED',         'Update completed');
define('TXT_USER_MSG_DELETED',         'Delete completed');
function TXT_USER_MSG_ADDED($default_password){ return $text = "The user addition is complete. The initial password is {$default_password}.";}

/*
 * user
 * ------------------------------------------------------------------------------------------------ */
define('TXT_USER_LBL_ALLOWDELETE',     'Allow delete');
define('TXT_USER_LBL_CANCELEDIT',      'Cancel edit');
define('TXT_USER_LBL_NEW',             'New');
define('TXT_USER_LBL_ACCOUNT',         'Account(email address recommended)');
define('TXT_USER_PLH_ACCOUNT',         'richard@postease.org');
define('TXT_USER_LBL_NICKNAME',        'Nickname');
define('TXT_USER_PLH_NICKNAME',        'Ric');
define('TXT_USER_LBL_SITEID',          'Accessible sites');
define('TXT_USER_LBL_POSTTYPEID',      'Accessible post-type');
define('TXT_USER_LBL_POSTTYPEEXTRAID', 'Accessible contact');
define('TXT_USER_LBL_CONTACTACCESS',   'Access to contacts');
define('TXT_USER_LBL_GROUPID',         'Group');
define('TXT_USER_SEL_NOGROUP',         'No group');
define('TXT_USER_LBL_STATUS',          'Role');
define('TXT_USER_BTN_UPDATE',          'Submit');
define('TXT_USER_BTN_DELETE',          'Delete');
define('TXT_USER_LBL_LIST',            'List');
define('TXT_USER_THD_ID',              'ID');
define('TXT_USER_THD_ACCOUNT',         'Account');
define('TXT_USER_THD_NICKNAME',        'Nickname');
define('TXT_USER_THD_GROUPNAME',       'Group');
define('TXT_USER_THD_ROLE',            'Role');
define('TXT_USER_LBL_EDIT',            'Edit');
function TXT_USER_LBL_DEFAULTPASSWORD($default_password){ return $text = "Default password: {$default_password}";}
function TXT_USER_LBL_NOWEDIT($target){ return $text = "Editing {$target}";}


/*
 * _change_password
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CHANGEPASSWORD_PAGETITLEMAIN',   'User');
define('TXT_CHANGEPASSWORD_PAGETITLESUB',    'Account renewal');
define('TXT_CHANGEPASSWORD_MSG_CHANGED',     'Your account has been renewed.');

/*
 * change_password
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CHANGEPASSWORD_LBL_CURRENT',     'Current password');
define('TXT_CHANGEPASSWORD_PLH_CURRENT',     'Enter current password');
define('TXT_CHANGEPASSWORD_LBL_NEW',         'New password');
define('TXT_CHANGEPASSWORD_PLH_NEW',         'Enter new password');
define('TXT_CHANGEPASSWORD_LBL_CONFIRM',     'New password (re-enter)');
define('TXT_CHANGEPASSWORD_PLH_CONFIRM',     'Enter new password (re-enter)');
define('TXT_CHANGEPASSWORD_LBL_AUTOGENERATE','Automatically generate new password');
define('TXT_CHANGEPASSWORD_LBL_ACCOUNT',     'Change your account name (email address recommended)');
define('TXT_POST_LBL_CHANGE_ACCOUNT',        'Change');
define('TXT_CHANGEPASSWORD_LBL_NICKNAME',    'Change nickname');
define('TXT_CHANGEPASSWORD_PLH_ACCOUNT',     'Enter new account');
define('TXT_CHANGEPASSWORD_PLH_NICKNAME',    'Enter new nickname');
define('TXT_CHANGEPASSWORD_BTN_SUBMIT',      'Renew');


/*
 * _config_core
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGCORE_PAGETITLEMAIN',   'Settings');
define('TXT_CONFIGCORE_PAGETITLESUB',    'Core');

/*
 * config_core
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGCORE_MSG_UPDATED',                     'Updated core settings.');
define('TXT_CONFIGCORE_LBL_TITLE',                       'Core settings');
define('TXT_CONFIGCORE_LBL_SYSTEM',                      'System');
define('TXT_CONFIGCORE_LBL_AUTHORITY',                   'Edit permissions');
define('TXT_CONFIGCORE_LBL_MEDIA',                       'Media');
define('TXT_CONFIGCORE_LBL_UPDATE',                      'System Update');
define('TXT_CONFIGCORE_LBL_DATAMANIPULATION',            'Data manipulation');
define('TXT_CONFIGCORE_LBL_ALLOWUPDATE',                 'Allow core settings to be updated');
define('TXT_CONFIGCORE_LNK_CHANGEDATABASE',              'Perform a database migration');
define('TXT_CONFIGCORE_LBL_DOMAIN',                      'Domain');
define('TXT_CONFIGCORE_LBL_DIRNAME',                     'Directory');
define('TXT_CONFIGCORE_BTN_FIXURLDIRNAME',               'Automatically correct domain and directory');
define('TXT_CONFIGCORE_LBL_TIMEZONE',                    'Timezone');
define('TXT_CONFIGCORE_LBL_SESSIONKEY',                  'Session key');
define('TXT_CONFIGCORE_LBL_UPLOADDIRPERMISSION',         'Upload directory permission');
define('TXT_CONFIGCORE_LBL_DISPLAYERRORS',               'Error indication');
define('TXT_CONFIGCORE_LBL_EDITCONTROLL',                'Role to edit Post');
define('TXT_CONFIGCORE_LBL_PUBLISHROLE',                 'Role to publish Post');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYPOST',    'Role to edit Post Categories');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLTAGPOST',         'Role to edit Post Tags');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCONFIGGENERAL',   'Setting (General) edit role');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCONFIGPOSTTYPE',  'Role to edit Post Custom settings');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYCONTACT', 'Role to edit Contact Categories');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCONFIGCONTACT',   'Role to edit Contact Custom settings');
define('TXT_CONFIGCORE_LBL_DEFAULTPASSWORD',             'User initial password');
define('TXT_CONFIGCORE_LBL_UPLOADIMAGESIZEMAIN',         'Body image default size');
define('TXT_CONFIGCORE_LBL_MAXWIDTH',                    'Max width');
define('TXT_CONFIGCORE_LBL_MAXHEIGHT',                   'Max height');
define('TXT_CONFIGCORE_LBL_MEDIAPARAMETERFLG',           'Media parameters');
define('TXT_CONFIGCORE_LBL_UPDATEALLOWEDROLE',           'Role to allow updates');
define('TXT_CONFIGCORE_LBL_UPDATELEVELOROVER',           'above');
define('TXT_CONFIGCORE_LBL_ALLOWUPDATEFLG',              'Role to check system update');
define('TXT_CONFIGCORE_LBL_AUTOUPDATEFLG',               'Automatic updates');
define('TXT_CONFIGCORE_LBL_UPDATELEVEL',                 'Update level');
define('TXT_CONFIGCORE_LBL_APIACCESS',                   'API access');
define('TXT_CONFIGCORE_LBL_REMOTE_ADDRESS_ALLOWED',      'Allowed IP');
define('TXT_CONFIGCORE_LBL_ORIGIN_ALLOWED',              'Allowed domain');
define('TXT_CONFIGCORE_LBL_APIFORCECACHETIME',           'Forced cache time (minutes)');
define('TXT_CONFIGCORE_LBL_CHANGEDATABASE',              'Database migration');
define('TXT_CONFIGCORE_BTN_SUBMIT',                      'Update');
function TXT_CONFIGCORE_LBL_MORETHAN($target){ return $text = "{$target} (above)";}


/*
 * _config_general
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGGENERAL_PAGETITLEMAIN',              'Settings');
define('TXT_CONFIGGENERAL_PAGETITLESUB',               'General');
define('TXT_CONFIGGENERAL_LBL_IMPLEMENTCODE',          'Implementation code');
define('TXT_CONFIGGENERAL_LBL_DISPLAYIMPLEMENTCODE',   'Implementation code display');
define('TXT_CONFIGGENERAL_LBL_IMPLEMENTCODETYPE',      'Implementation code type');

/*
 * config_general
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGGENERAL_MSG_UPDATED',      'Updated general settings.');
define('TXT_CONFIGGENERAL_LBL_TITLECOMMON',  'Overall');
define('TXT_CONFIGGENERAL_LBL_SITENAME',     'Site name');
define('TXT_CONFIGGENERAL_LBL_LANGUAGE',     'System language');
define('TXT_CONFIGGENERAL_LBL_SYSTEMFONT',   'System font');
define('TXT_CONFIGGENERAL_BTN_SUBMIT',       'Update');


/*
 * _config_option
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGOPTION_PAGETITLEMAIN',   'Settings');
define('TXT_CONFIGOPTION_PAGETITLESUB',    'Option');

/*
 * config_option
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGOPTION_MSG_UPDATED',              'Updated option settings.');
define('TXT_CONFIGOPTION_LBL_TITLE_OTHERS',         'More options');
define('TXT_CONFIGOPTION_LBL_USECOMMENTFLG',        'Comment');
define('TXT_CONFIGOPTION_LBL_USEVERSIONFLG',        'Versioning');
define('TXT_CONFIGOPTION_LBL_USEADVANCEDCACHEFLG',  'Smart Cache Advance');
define('TXT_CONFIGOPTION_LBL_TITLE_CONTACT',        'Contact option');
define('TXT_CONFIGOPTION_LBL_TITLE_USER',           'User option');
define('TXT_CONFIGOPTION_LBL_USECONTACTFLG',        'Contact');
define('TXT_CONFIGOPTION_LBL_USEGROUPFLG',          'Group');
define('TXT_CONFIGOPTION_LBL_TITLE_SITE',           'Site option');
define('TXT_CONFIGOPTION_LBL_USEMULTISITEFLG',      'Multi Site');
define('TXT_CONFIGOPTION_LBL_USEPOSTTYPEFLG',       'Multi Post-type');
define('TXT_CONFIGOPTION_LBL_USEMULTILINGUALFLG',   'Multilingual');
define('TXT_CONFIGOPTION_LBL_ADVANCEOPTION',        'Advanced option');
define('TXT_CONFIGOPTION_LBL_BUSINESSOPTION',       'Business option');
define('TXT_CONFIGOPTION_BTN_SUBMIT',               'Update');


/*
 * _category
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CATEGORY_PAGETITLE_CONTACT', 'Contact');
define('TXT_CATEGORY_PAGETITLESUB',      'Edit');
define('TXT_CATEGORY_MSG_CREATED',       'New creation completed');
define('TXT_CATEGORY_MSG_UPDATED',       'Update completed');
define('TXT_CATEGORY_MSG_DELETED',       'Delete completed');
function TXT_CATEGORY_PAGETITLEMAIN($target){ return $text = "{$target} Categories";}

/*
 * category
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CATEGORY_LBL_CATEGORY',      'Categories');
define('TXT_CATEGORY_LBL_ALLOWDELETE',   'Allow delete');
define('TXT_CATEGORY_LBL_CANCELEDIT',    'Cancel edit');
define('TXT_CATEGORY_WAR_NOLABEL',       'Some categories do not have labels registered.');
define('TXT_CATEGORY_LBL_NEW',           'New');
define('TXT_CATEGORY_LBL_LABEL',         'Label');
define('TXT_CATEGORY_PLH_LABEL',         'Enter label');
define('TXT_CATEGORY_LBL_SLUG',          'Slug');
define('TXT_CATEGORY_PLH_SLUG',          'Enter slug');
define('TXT_CATEGORY_LBL_PARENT',        'Parent category');
define('TXT_CATEGORY_LBL_STATUS',        'Status');
define('TXT_CATEGORY_BTN_UPDATE',        'Submit');
define('TXT_CATEGORY_BTN_DELETE',        'Delete');
define('TXT_CATEGORY_LBL_LIST',          'List');
define('TXT_CATEGORY_THD_ID',            'ID');
define('TXT_CATEGORY_THD_HIERARCHY',     'Hierarchy');
define('TXT_CATEGORY_THD_LABEL',         'Label');
define('TXT_CATEGORY_THD_SLUG',          'Slug');
define('TXT_CATEGORY_THD_PARENT',        'Parent category');
define('TXT_CATEGORY_THD_STATUS',        'Status');
define('TXT_CATEGORY_LBL_DISPLAY',       'Enabled');
define('TXT_CATEGORY_LBL_UNDISPLAY',     'Disabled');
define('TXT_CATEGORY_LBL_EDIT',          'Edit');
function TXT_CATEGORY_LBL_NOWEDIT($target){ return $text = "Editing ID:{$target}";}


/*
 * _tag
 * ------------------------------------------------------------------------------------------------ */
define('TXT_TAG_PAGETITLESUB',    'Edit');
define('TXT_TAG_MSG_CREATED',     'New creation completed');
define('TXT_TAG_MSG_UPDATED',     'Update completed');
define('TXT_TAG_MSG_DELETED',     'Delete completed');
function TXT_TAG_PAGETITLEMAIN($target){ return $text = "{$target} Tags";}

/*
 * tag
 * ------------------------------------------------------------------------------------------------ */
define('TXT_TAG_WAR_NOLABEL',     'Some tags do not have a label registered.');
define('TXT_TAG_LBL_TAG',         'Tags');
define('TXT_TAG_LBL_ALLOWDELETE', 'Allow delete');
define('TXT_TAG_LBL_CANCELEDIT',  'Cancel edit');
define('TXT_TAG_LBL_NEW',         'New');
define('TXT_TAG_LBL_LABEL',       'Label');
define('TXT_TAG_PLH_NAME',        'Enter label');
define('TXT_TAG_LBL_SLUG',        'Slug');
define('TXT_TAG_PLH_SLUG',        'Enter slug');
define('TXT_TAG_LBL_STATUS',      'Status');
define('TXT_TAG_BTN_UPDATE',      'Submit');
define('TXT_TAG_BTN_DELETE',      'Delete');
define('TXT_TAG_LBL_LIST',        'List');
define('TXT_TAG_THD_ID',          'ID');
define('TXT_TAG_THD_LABEL',       'Label');
define('TXT_TAG_THD_SLUG',        'Slug');
define('TXT_TAG_THD_STATUS',      'Status');
define('TXT_TAG_LBL_DISPLAY',     'Show');
define('TXT_TAG_LBL_UNDISPLAY',   'Hide');
define('TXT_TAG_LBL_EDIT',        'Edit');
function TXT_TAG_LBL_NOWEDIT($target){ return $text = "Editing ID: {$target}";}


/*
 * _config_posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGPOSTTYPE_PAGETITLE_CONTACT', 'Custom settings');
function TXT_CONFIGPOSTTYPE_PAGETITLEMAIN($target){ return $text = "{$target} Custom settings";}

/*
 * config_posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGPOSTTYPE_LBL_XXX',         '');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEBASE',            'Default');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEPERMALINK',       'Permalink');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEOPTION',          'Additional features');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEPOSTDETAIL',      'Post details');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEPOSTLIST',        'Post list');
define('TXT_CONFIGPOSTTYPE_LBL_TITLECOMMENTLIST',     'Comment list');
define('TXT_CONFIGPOSTTYPE_LBL_MENUICON',             'Menu icon');
define('TXT_CONFIGPOSTTYPE_LBL_ICONSEEMORE',          'see more');
define('TXT_CONFIGPOSTTYPE_LBL_POSTAUTOSAVEFLG',      'Autosave');
define('TXT_CONFIGPOSTTYPE_LBL_USEWISIWYGFLG',        'WISIWYG Editor');
define('TXT_CONFIGPOSTTYPE_LBL_USECUSTOMITEMFLG',     'Custom items');
define('TXT_CONFIGPOSTTYPE_LBL_USEMULTIPAGEFLG',      'Multi page');
define('TXT_CONFIGPOSTTYPE_LBL_COMMNETTYPE',          'Comment type');
define('TXT_CONFIGPOSTTYPE_LBL_USEPUBLISHENDATFLG',   'Publish end date and time');
define('TXT_CONFIGPOSTTYPE_LBL_USEADDITIONFLG',       'Description');
define('TXT_CONFIGPOSTTYPE_LBL_USECONTENTFLG',        'Content');
define('TXT_CONFIGPOSTTYPE_LBL_USESLUGFLG',           'Slug');
define('TXT_CONFIGPOSTTYPE_LBL_USECATEGORYFLG',       'Categories');
define('TXT_CONFIGPOSTTYPE_LBL_USETAGFLG',            'Tags');
define('TXT_CONFIGPOSTTYPE_LBL_EYECATCHFRAME',        'Eyecatch image');
define('TXT_CONFIGPOSTTYPE_LBL_PREVIEWURL',           'Preview URL');
define('TXT_CONFIGPOSTTYPE_LBL_PARAMETERKEY',         'Parameter key');
define('TXT_CONFIGPOSTTYPE_LBL_PERMALINKSTYLE',       'Permalink style');
define('TXT_CONFIGPOSTTYPE_LBL_PERMALINKKEY',         'Permalink key');
define('TXT_CONFIGPOSTTYPE_LBL_RESOURCE_URL',         'Original URL');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITE_URL',          'Rewrite URL');
define('TXT_CONFIGPOSTTYPE_LBL_PERMALINK_SAMPLE',     'Permalink sample');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITEOPERATORFLG',   'Added rules to access with URL without extension');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITEOPERATOR',      'File extensions to remove from URL');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITE_RULE',         'Rewrite rule');
define('TXT_CONFIGPOSTTYPE_LBL_LABELTITLE',           'Title label');
define('TXT_CONFIGPOSTTYPE_LBL_LABELADDITION',        'Description label');
define('TXT_CONFIGPOSTTYPE_LBL_LABELCONTENT',         'Body label');
define('TXT_CONFIGPOSTTYPE_LBL_CUSTOMITEMPOSITION',   'Custom items display position');
define('TXT_CONFIGPOSTTYPE_LBL_LISTNUM',              'Number of listed');
define('TXT_CONFIGPOSTTYPE_LBL_SORTORDER',            'Sort order');
define('TXT_CONFIGPOSTTYPE_LBL_USELISTEYECATCHFLG',   'Eyecatch');
define('TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN03',        'Initial user display');
define('TXT_CONFIGPOSTTYPE_LBL_TITLELENGTH',          'Title display character length');
define('TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMCATEGORY',   'Number of categories displayed');
define('TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMTAG',        'Number of tags displayed');
define('TXT_CONFIGPOSTTYPE_LBL_CONTACTSCOLUMN04',     'Column 4 Initial Display');;
define('TXT_CONFIGPOSTTYPE_LBL_REVIEWMAXSCORE',       'Review Max Score');
define('TXT_CONFIGPOSTTYPE_LBL_UNLIMITED',            'No limit');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEDATAIMPORT',      'Data import');
define('TXT_CONFIGPOSTTYPE_LBL_DATATYPE',             'Types of data to import');
define('TXT_CONFIGPOSTTYPE_LBL_FILETYPE',             'File type');
define('TXT_CONFIGPOSTTYPE_LBL_DATAFILE',             'Data file');
define('TXT_CONFIGPOSTTYPE_LBL_DELIMITER',            'Delimiter (CSV)');
define('TXT_CONFIGPOSTTYPE_LBL_CUSTOMLISTS',          'Custom lists');
define('TXT_CONFIGPOSTTYPE_LBL_KEYCOLUMN',            'Field to use as key');
define('TXT_CONFIGPOSTTYPE_BTN_SUBMIT',               'Update');
define('TXT_CONFIGPOSTTYPE_BTN_UPLOAD',               'Upload');


/*
 * config_posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGCONTACT_LBL_ADMINAUTOREPLYSETTING',    'Administrator Auto Reply Email Settings');
define('TXT_CONFIGCONTACT_LBL_USEAUTOREPLYADMIN',        'Administrator auto-reply email');
define('TXT_CONFIGCONTACT_LBL_ADMINLANGUAGE',            'language');
define('TXT_CONFIGCONTACT_LBL_ADMINTO',                  'Send-to e-mail address (to)');
define('TXT_CONFIGCONTACT_LBL_ADMINFROM',                'Sent-from e-mail address (from)');
define('TXT_CONFIGCONTACT_LBL_ADMINFROMNAME',            'Sent-from name（from name）');
define('TXT_CONFIGCONTACT_LBL_ADMINSUBJECT',             'Subject');
define('TXT_CONFIGCONTACT_LBL_ADMINBODYHEAD',            'Body header');
define('TXT_CONFIGCONTACT_LBL_ADMINBODYMAIN',            'Body main');
define('TXT_CONFIGCONTACT_LBL_USEINPUTVALUESADMIN',      'Form input values');
define('TXT_CONFIGCONTACT_LBL_ADMINBODYBOTTOM',          'Body footer');
define('TXT_CONFIGCONTACT_LBL_ADMINSIGNATURE',           'Signature');

define('TXT_CONFIGCONTACT_LBL_CUSTOMERAUTOREPLYSETTING',   'Customer Auto Reply Email Settings');
define('TXT_CONFIGCONTACT_LBL_USEAUTOREPLYCUSTOMER',       'Customer auto-reply email');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERLANGUAGE',           'language');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERFROM',               'Sent-from e-mail address (from)');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERFROMNAME',           'Sent-from name（from name）');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERSUBJECT',            'Subject');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERBODYHEAD',           'Body header');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERBODYMAIN',           'Body main');
define('TXT_CONFIGCONTACT_LBL_USEINPUTVALUESCUSTOMER',     'Form input values');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERBODYBOTTOM',         'Body footer');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERSIGNATURE',          'Signature');

define('TXT_CONFIGCONTACT_LBL_SMTP',                'SMTP Server Settings');
define('TXT_CONFIGCONTACT_LBL_USE_SMTP',            'Use SMTP server');
define('TXT_CONFIGCONTACT_LBL_HOST',                'Server name');
define('TXT_CONFIGCONTACT_LBL_USER_NAME',           'User name');
define('TXT_CONFIGCONTACT_LBL_PASSWORD',            'Password');
define('TXT_CONFIGCONTACT_LBL_PORT',                'Port');

define('TXT_CONFIGCONTACT_LBL_TITLEOPTION',          'Additional features');
define('TXT_CONFIGCONTACT_LBL_TITLELIST',            'List view');
define('TXT_CONFIGCONTACT_LBL_USECUSTOMITEMFLG',     'Custom items');
define('TXT_CONFIGCONTACT_LBL_ADMINEMAIL',           'Administrator email address');
define('TXT_CONFIGCONTACT_LBL_LISTNUM',              'Number of listed');
define('TXT_CONFIGCONTACT_LBL_SORTORDER',            'Sort order');
define('TXT_CONFIGCONTACT_LBL_POSTSCOLUMN01',        'Column 1 Initial Display');
define('TXT_CONFIGCONTACT_LBL_POSTSCOLUMN03',        'Column 3 Initial Display');
define('TXT_CONFIGCONTACT_LBL_COLUMN01LENGTH',       'Column 1 display character length');
define('TXT_CONFIGCONTACT_LBL_DISPLAYNUMCATEGORY',   'Number of categories displayed');
define('TXT_CONFIGCONTACT_LBL_DISPLAYNUMTAG',        'Number of tags displayed');
define('TXT_CONFIGCONTACT_BTN_SUBMIT',               'Update');


/*
 * _site
 * ------------------------------------------------------------------------------------------------ */
define('TXT_SITE_PAGETITLEMAIN',      'Site');
define('TXT_SITE_PAGETITLESUB',       'Edit');
define('TXT_SITE_MSG_CREATED',        'New creation completed');
define('TXT_SITE_MSG_FOR_USER',       'Only users with the System Administrator and Site Administrator role can access the newly added site. For users with "Editor" and "Writer" role, please set the role individually from the menu [User] [Edit].');
define('TXT_SITE_MSG_FOR_POSTTYPE',   'Newly added sites do not have a post-type associated with them. Associate post-type from "Associated Sites" in the menu [Site options] [Multi Post-type].');
define('TXT_SITE_MSG_UPDATED',        'Update completed');
define('TXT_SITE_MSG_DELETED',        'Delete completed');

/*
 * site
 * ------------------------------------------------------------------------------------------------ */
function TXT_SITE_LBL_NOWEDIT($target){ return $text = "Editing {$target}";}
define('TXT_SITE_LBL_MULTISITE',      'Multi Site');
define('TXT_SITE_LBL_DISALLOWDELETE', 'ID:1 cannot be Delete');
define('TXT_SITE_LBL_ALLOWDELETE',    'Allow delete');
define('TXT_SITE_LBL_CANCELEDIT',     'Cancel edit');
define('TXT_SITE_LBL_NEW',            'New');
define('TXT_SITE_LBL_NAME',           'Label');
define('TXT_SITE_PLH_NAME',           'Sample Site');
define('TXT_SITE_LBL_SLUG',           'Slug');
define('TXT_SITE_PLH_SLUG',           'sample_site');
define('TXT_SITE_LBL_STATUS',         'Status');
define('TXT_SITE_BTN_UPDATE',         'Submit');
define('TXT_SITE_BTN_DELETE',         'Delete');
define('TXT_SITE_LBL_LISTSITE',       'Site list');
define('TXT_SITE_THD_ID',             'ID');
define('TXT_SITE_THD_NAME',           'Label');
define('TXT_SITE_THD_SLUG',           'Slug');
define('TXT_SITE_THD_STATUS',         'Status');
define('TXT_SITE_LBL_DISPLAY',        'Show');
define('TXT_SITE_LBL_UNDISPLAY',      'Hide');
define('TXT_SITE_LBL_EDIT',           'Edit');


/*
 * _group
 * ------------------------------------------------------------------------------------------------ */
define('TXT_GROUP_PAGETITLEMAIN',      'Group');
define('TXT_GROUP_PAGETITLESUB',       'Edit');
define('TXT_GROUP_MSG_CREATED',        'New creation completed');
define('TXT_GROUP_MSG_UPDATED',        'Update completed');
define('TXT_GROUP_MSG_DELETED',        'Delete completed');

/*
 * group
 * ------------------------------------------------------------------------------------------------ */
function TXT_GROUP_LBL_NOWEDIT($target){ return $text = "Editing {$target}";}
define('TXT_GROUP_LBL_MULTIGROUP',     'Group');
define('TXT_GROUP_LBL_DISALLOWDELETE', 'ID:1 cannot be Delete');
define('TXT_GROUP_LBL_ALLOWDELETE',    'Allow delete');
define('TXT_GROUP_LBL_CANCELEDIT',     'Cancel edit');
define('TXT_GROUP_LBL_NEW',            'New');
define('TXT_GROUP_LBL_NAME',           'Label');
define('TXT_GROUP_PLH_NAME',           'Enter label');
define('TXT_GROUP_LBL_SLUG',           'Slug');
define('TXT_GROUP_PLH_SLUG',           'Enter slug');
define('TXT_GROUP_LBL_STATUS',         'Status');
define('TXT_GROUP_BTN_UPDATE',         'Submit');
define('TXT_GROUP_BTN_DELETE',         'Delete');
define('TXT_GROUP_LBL_LIST',           'List');
define('TXT_GROUP_THD_ID',             'ID');
define('TXT_GROUP_THD_NAME',           'Label');
define('TXT_GROUP_THD_SLUG',           'Slug');
define('TXT_GROUP_THD_STATUS',         'Status');
define('TXT_GROUP_LBL_DISPLAY',        'Show');
define('TXT_GROUP_LBL_UNDISPLAY',      'Hide');
define('TXT_GROUP_LBL_EDIT',           'Edit');


/*
 * _posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTTYPE_PAGETITLEMAIN',    'Multi post-type');
define('TXT_POSTTYPE_PAGETITLESUB',     'Edit');
define('TXT_POSTTYPE_MSG_FOR_USER',     'Only users with the System Administrator and Site Administrator role can access the newly added post type. For users with "Editor" and "Writer" role, please set the permissions individually from the menu [User] [Edit].');
define('TXT_POSTTYPE_MSG_CREATED',      'New creation completed');
define('TXT_POSTTYPE_MSG_UPDATED',      'Update completed');
define('TXT_POSTTYPE_MSG_DELETED',      'Delete completed');

/*
 * posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTTYPE_LBL_MULTIPOST',             'Multi Post-type');
define('TXT_POSTTYPE_LBL_DISALLOWDELETEPOST',    'Default post cannot be deleted');
define('TXT_POSTTYPE_LBL_DISALLOWDELETECONTACT', 'Default contact cannot be deleted');
define('TXT_POSTTYPE_LBL_ALLOWDELETE',           'Allow delete');
define('TXT_POSTTYPE_LBL_CANCELEDIT',            'Cancel edit');
define('TXT_POSTTYPE_LBL_NEW',                   'New');
define('TXT_POSTTYPE_LBL_POST',                  'Post-type');
define('TXT_POSTTYPE_LBL_CONTACT',               'Contact');
define('TXT_POSTTYPE_MSG_CREATION_LIMIT',        'It is already the creation limit.');
define('TXT_POSTTYPE_LBL_NAME',                  'Label');
define('TXT_POSTTYPE_PLH_NAME',                  'What\'s new');
define('TXT_POSTTYPE_LBL_TYPE',                  'Type');
define('TXT_POSTTYPE_LBL_SLUG',                  'Slug');
define('TXT_POSTTYPE_PLH_SLUG',                  'news');
define('TXT_POSTTYPE_LBL_WISIWYGFLG',            'WISIWYG editor');
define('TXT_POSTTYPE_LBL_COMMENTTYPE',           'Comment type');
define('TXT_POSTTYPE_LBL_SITEID',                'Associated Sites');
define('TXT_POSTTYPE_LBL_LANGUAGEID',            'Associated Languages');
define('TXT_POSTTYPE_LBL_LANGUAGEDEFAULT',       '(default)');
define('TXT_POSTTYPE_LBL_STATUS',                'Status');
define('TXT_POSTTYPE_BTN_UPDATE',                'Submit');
define('TXT_POSTTYPE_BTN_DELETE',                'Delete');
define('TXT_POSTTYPE_LBL_LISTPOST',              'Post-type list');
define('TXT_POSTTYPE_LBL_LISTCONTACT',           'Contact list');
define('TXT_POSTTYPE_THD_ID',                    'ID');
define('TXT_POSTTYPE_THD_NAME',                  'Label');
define('TXT_POSTTYPE_THD_SLUG',                  'Slug');
define('TXT_POSTTYPE_THD_COMMENTTYPE',           'Comment');
define('TXT_POSTTYPE_THD_SITEID',                'Associated Site');
define('TXT_POSTTYPE_THD_LANGUAGEID',            'Associated Languages');
define('TXT_POSTTYPE_THD_STATUS',                'Status');
define('TXT_POSTTYPE_LBL_DISPLAY',               'Enabled');
define('TXT_POSTTYPE_LBL_UNDISPLAY',             'Disabled');
define('TXT_POSTTYPE_LBL_EDIT',                  'Edit');
function TXT_POSTTYPE_LBL_NOWEDIT($target)       { return $text = "Editing {$target}";}
function TXT_POSTTYPE_MSG_CREATION_LEFT($left)   { return $text = "{$left} more can be created";}


/*
 * _language
 * ------------------------------------------------------------------------------------------------ */
define('TXT_LANGUAGE_PAGETITLEMAIN',      'Language');
define('TXT_LANGUAGE_PAGETITLESUB',       'Edit');
define('TXT_LANGUAGE_MSG_CREATED',        'New creation completed');
define('TXT_LANGUAGE_MSG_FOR_POSTTYPE',   'To use the newly created language, set it from the menu [Site Options] [Multi Post-type].');
define('TXT_LANGUAGE_MSG_UPDATED',        'Update completed');
define('TXT_LANGUAGE_MSG_DELETED',        'Delete completed');

/*
 * language
 * ------------------------------------------------------------------------------------------------ */
function TXT_LANGUAGE_LBL_NOWEDIT($target){ return $text = "Editing {$target}";}
define('TXT_LANGUAGE_LBL_MULTILANGUAGE',  'Multilingual');
define('TXT_LANGUAGE_LBL_DISALLOWDELETE', 'ID:1 cannot be Delete');
define('TXT_LANGUAGE_LBL_ALLOWDELETE',    'Allow delete');
define('TXT_LANGUAGE_LBL_CANCELEDIT',     'Cancel edit');
define('TXT_LANGUAGE_LBL_NEW',            'New');
define('TXT_LANGUAGE_LBL_NAME',           'Label');
define('TXT_LANGUAGE_PLH_NAME',           'English');
define('TXT_LANGUAGE_LBL_SLUG',           'Slug');
define('TXT_LANGUAGE_PLH_SLUG',           'english');
define('TXT_LANGUAGE_LBL_STATUS',         'Status');
define('TXT_LANGUAGE_BTN_UPDATE',         'Submit');
define('TXT_LANGUAGE_BTN_DELETE',         'Delete');
define('TXT_LANGUAGE_LBL_LISTLANGUAGE',   'Language List');
define('TXT_LANGUAGE_THD_ID',             'ID');
define('TXT_LANGUAGE_THD_NAME',           'Label');
define('TXT_LANGUAGE_THD_SLUG',           'Slug');
define('TXT_LANGUAGE_THD_STATUS',         'Status');
define('TXT_LANGUAGE_LBL_DISPLAY',        'Show');
define('TXT_LANGUAGE_LBL_UNDISPLAY',      'Hide');
define('TXT_LANGUAGE_LBL_EDIT',           'Edit');


/*
 * cover
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COVER_LBL_TOCOVER',     'Cover image');
define('TXT_COVER_LBL_SETFRAME',    'Flame setting');
define('TXT_COVER_LNK_BACKTOTEXT',  'Text');


/*
 * _custom_item
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMITEM_PAGETITLE_CONTACT',  'Contact');
define('TXT_CUSTOMITEM_PAGETITLESUB',       'Edit');
define('TXT_CUSTOMITEM_MSG_CREATED',        'New creation completed');
define('TXT_CUSTOMITEM_MSG_UPDATED',        'Update completed');
define('TXT_CUSTOMITEM_MSG_DELETED',        'Delete completed');
function TXT_CUSTOMITEM_PAGETITLEMAIN($target){ return $text = "{$target} Custom items";}

/*
 * custom_item
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMITEM_LBL_EDITCUSTOMLIST',  'Edit Custom lists');
define('TXT_CUSTOMITEM_LBL_CUSTOMITEM',      'Custom items');
define('TXT_CUSTOMITEM_LBL_ALLOWDELETE',     'Allow delete');
define('TXT_CUSTOMITEM_LBL_CANCELEDIT',      'Cancel edit');
define('TXT_CUSTOMITEM_LBL_NEW',             'New');
define('TXT_CUSTOMITEM_LBL_NAME',            'Label');
define('TXT_CUSTOMITEM_PLH_NAME',            'Enter label');
define('TXT_CUSTOMITEM_LBL_SLUG',            'Slug');
define('TXT_CUSTOMITEM_PLH_SLUG',            'Enter slug');
define('TXT_CUSTOMITEM_LBL_TYPE',            'Type');
define('TXT_CUSTOMITEM_LBL_TARGETLIST',      'Select Custom lists');
define('TXT_CUSTOMITEM_MSG_NOTARGETLIST',    'no Custom lists to select');
define('TXT_CUSTOMITEM_LBL_TARGETDELIMITER', 'Select delimiter');
define('TXT_CUSTOMITEM_LBL_TARGETIMAGE',     'Select image');
define('TXT_CUSTOMITEM_LBL_TARGETPOSTTYPE',  'Select post-type');
define('TXT_CUSTOMITEM_LBL_TARGETSYNTAX',    'Select syntax-type');
define('TXT_CUSTOMITEM_LBL_STATUS',          'Status');
define('TXT_CUSTOMITEM_BTN_UPDATE',          'Submit');
define('TXT_CUSTOMITEM_BTN_DELETE',          'Delete');
define('TXT_CUSTOMITEM_LBL_LIST',            'List');
define('TXT_CUSTOMITEM_THD_ID',              'ID');
define('TXT_CUSTOMITEM_THD_NAME',            'Label');
define('TXT_CUSTOMITEM_THD_SLUG',            'Slug');
define('TXT_CUSTOMITEM_THD_TYPE',            'Type');
define('TXT_CUSTOMITEM_THD_TARGET',          'Options');
define('TXT_CUSTOMITEM_THD_STATUS',          'Status');
define('TXT_CUSTOMITEM_LBL_DISPLAY',         'Show');
define('TXT_CUSTOMITEM_LBL_UNDISPLAY',       'Hide');
define('TXT_CUSTOMITEM_LBL_EDIT',            'Edit');
function TXT_CUSTOMITEM_LBL_NOWEDIT($target){ return $text = "Editing ID {$target}";}


/*
 * _custom_list
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMLIST_PAGETITLEMAIN',      'Custom lists');
define('TXT_CUSTOMLIST_PAGETITLESUB',       'Edit');
define('TXT_CUSTOMLIST_MSG_CREATED',        'New creation completed');
define('TXT_CUSTOMLIST_MSG_UPDATED',        'Update completed');
define('TXT_CUSTOMLIST_MSG_DELETED',        'Delete completed');
define('TXT_CUSTOMLIST_LBL_MULTIUSE',       'shared'); // also use in custom_list

/*
 * custom_list
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMLIST_LNK_CUSTOMITEM',     'Custom items');
define('TXT_CUSTOMLIST_LBL_CUSTOMLIST',     'Custom lists');
define('TXT_CUSTOMLIST_LBL_ALLOWDELETE',    'Allow delete');
define('TXT_CUSTOMLIST_LBL_CANCELEDIT',     'Cancel edit');
define('TXT_CUSTOMLIST_LBL_NEW',            'New');
define('TXT_CUSTOMLIST_LBL_NAME',           'List name');
define('TXT_CUSTOMLIST_PLH_NAME',           'Enter list name');
define('TXT_CUSTOMLIST_LBL_SLUG',           'Slug');
define('TXT_CUSTOMLIST_PLH_SLUG',           'Enter slug');
define('TXT_CUSTOMLIST_LBL_BELONGTO',       'Belong');
define('TXT_CUSTOMLIST_LBL_STATUS',         'Status');
define('TXT_CUSTOMLIST_BTN_UPDATE',         'Submit');
define('TXT_CUSTOMLIST_BTN_DELETE',         'Delete');
define('TXT_CUSTOMLIST_LBL_LIST',           'List');
define('TXT_CUSTOMLIST_THD_ID',             'ID');
define('TXT_CUSTOMLIST_THD_NAME',           'Label');
define('TXT_CUSTOMLIST_THD_SLUG',           'Slug');
define('TXT_CUSTOMLIST_THD_BELONGTO',       'Belong');
define('TXT_CUSTOMLIST_THD_STATUS',         'Status');
define('TXT_CUSTOMLIST_LNK_CUSTOMVALUE',    'Edit Custom values');
define('TXT_CUSTOMLIST_LBL_DISPLAY',        'Show');
define('TXT_CUSTOMLIST_LBL_UNDISPLAY',      'Hide');
define('TXT_CUSTOMLIST_LBL_EDIT',           'Edit');
function TXT_CUSTOMLIST_LBL_NOWEDIT($target){ return $text = "Editing ID {$target}";}


/*
 * _custom_value
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMVALUE_PAGETITLEMAIN',      'Custom values');
define('TXT_CUSTOMVALUE_PAGETITLESUB',       'Edit');
define('TXT_CUSTOMVALUE_MSG_CREATED',        'New creation completed');
define('TXT_CUSTOMVALUE_MSG_UPDATED',        'Update completed');
define('TXT_CUSTOMVALUE_MSG_DELETED',        'Delete completed');

/*
 * custom_value
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMVALUE_LNK_CUSTOMLIST',     'Custom lists');
define('TXT_CUSTOMVALUE_WAR_NOLABEL',        'There are some custom values that does not have a label registered. If the label is not registered, it cannot be selected at the time of input.');
define('TXT_CUSTOMVALUE_LBL_CUSTOMVALUE',    'Custom values');
define('TXT_CUSTOMVALUE_LBL_ALLOWDELETE',    'Allow delete');
define('TXT_CUSTOMVALUE_LBL_CANCELEDIT',     'Cancel edit');
define('TXT_CUSTOMVALUE_LBL_NEW',            'New');
define('TXT_CUSTOMVALUE_LBL_VALUE',          'Value');
define('TXT_CUSTOMVALUE_PLH_VALUE',          'Enter value');
define('TXT_CUSTOMVALUE_LBL_STATUS',         'Status');
define('TXT_CUSTOMVALUE_BTN_UPDATE',         'Submit');
define('TXT_CUSTOMVALUE_BTN_DELETE',         'Delete');
define('TXT_CUSTOMVALUE_LBL_LIST',           'List');
define('TXT_CUSTOMVALUE_THD_ID',             'ID');
define('TXT_CUSTOMVALUE_THD_VALUE',          'Value');
define('TXT_CUSTOMVALUE_THD_STATUS',         'Status');
define('TXT_CUSTOMVALUE_LBL_DISPLAY',        'Show');
define('TXT_CUSTOMVALUE_LBL_UNDISPLAY',      'Hide');
define('TXT_CUSTOMVALUE_LBL_EDIT',           'Edit');
function TXT_CUSTOMVALUE_LBL_NOWEDIT($target) { return $text = "Editing {$target}";}


/*
 * code
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CODE_LNK_CHANGE_LANGUAGE',               'Change implementation code display settings');
define('TXT_CODE_COM_IMPLEMENT_REMOTEPHP01',         'Set endpoint (POSTEASE API URL)');
define('TXT_CODE_COM_IMPLEMENT_GETPOSTKEY',          'Get post_key');
define('TXT_CODE_COM_IMPLEMENT_REMOTEPHP02',         'Read sdk (client tool) to retrieve data from THE POSTSEASE API');
define('TXT_CODE_COM_IMPLEMENT_JQUERY',              'No common code is required.');
define('TXT_CODE_COM_IMPLEMENT_JQUERYATTENTION',     'If you are connecting from a remote server, place .htaccess describing CORS opening in the following directory:');

define('TXT_CODE_COM_IMPLEMENT_POSTSCONFIG',         'Set the conditions for retrieving post lists');
define('TXT_CODE_COM_IMPLEMENT_GETPOSTS',            'Get post list');
define('TXT_CODE_COM_IMPLEMENT_POSTCONFIG',          'Set the acquisition conditions for the post (in the case of Slug use)');
define('TXT_CODE_COM_IMPLEMENT_POSTCONFIGBYPOSTKEY', 'Get post');
define('TXT_CODE_COM_IMPLEMENT_RENDERPOSTS',         'Export post data to HTML');

define('TXT_CODE_COM_IMPLEMENT_CATEGORIESCONFIG',  'Set conditions for retrieving categorical data');
define('TXT_CODE_COM_IMPLEMENT_GETCATEGORIES',     'Get categorical data');
define('TXT_CODE_COM_IMPLEMENT_TAGSCONFIG',        'Set the conditions for retrieving tag data');
define('TXT_CODE_COM_IMPLEMENT_GETTAGS',           'Get tag data');
define('TXT_CODE_COM_IMPLEMENT_CATEGORYTITLE',     'List of categories');
define('TXT_CODE_COM_IMPLEMENT_TAGTITLE',          'Tag list');


/*
 * error
 * ------------------------------------------------------------------------------------------------ */
function TXT_ERROR_MSG_ERROROCCURED($page, $read_error) { return $text = "An reading error \"{$read_error}\" occurred on the {$page} page.";}
