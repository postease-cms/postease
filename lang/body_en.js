/*
 * _reset_system
 * ------------------------------------------------------------------------------------------------ */
var TXT_RESETSYSTEM_ALT_SHIFTDB       = 'Migrate the database. All destination data will be overwritten (tables not used on this system will not be affected).';
var TXT_RESETSYSTEM_MSG_NOWSHIFTDB    = 'Migrating databases. Do not close the screen.';
var TXT_RESETSYSTEM_MSG_NOWSETTING    = 'Setting is in progress. Do not close the screen.';
var TXT_RESETSYSTEM_ALT_INVALID_EMAIL = 'Wrong email address.';
var TXT_RESETSYSTEM_MSG_ISSUED_ACTIVATIONKEY  = 'The activation key has been issued. Please check your email.';
var TXT_RESETSYSTEM_MSG_ONISSUE_ACTIVATIONKEY = 'The activation key is being issued. Please wait for a while.';
var TXT_RESETSYSTEM_LNK_DOWNLOAD_PASSWORD     = 'Download the password.';


/*
 * _update / _index
 * ------------------------------------------------------------------------------------------------ */
var TXT_UPDATE_CLASSIFICATION   = {1: 'Micro upadate' , 2: 'Minor update' , 3: 'Major update'};
var TXT_UPDATE_MSG_01           = 'Checking for updates...';
var TXT_UPDATE_MSG_02           = 'Preparing for update...';
var TXT_UPDATE_MSG_02           = 'Updating... (Do not close the screen)';
var TXT_UPDATE_MSG_04           = 'The operation was aborted.';
var TXT_UPDATE_MSG_61           = 'The system is up-to-date.';
var TXT_UPDATE_MSG_91           = 'Communication with the server is crowded. Cancels the update process. (ERROR_CODE:91)';
var TXT_UPDATE_MSG_92           = 'Failed to get updates. Cancels the update process. (ERROR_CODE:92)';
var TXT_UPDATE_MSG_93           = 'Failed to prepare for update. Cancels the update process. (ERROR_CODE:93)';
var TXT_UPDATE_MSG_94           = 'There was an error during the update. Cancels the update process. (ERROR_CODE:94)';
var TXT_UPDATE_MSG_95           = 'There was an error during the update. Cancels the update process. (ERROR_CODE:95)';
var TXT_UPDATE_MSG_96           = 'There was an error during the update. Cancels the update process. (ERROR_CODE:96)';
var TXT_INDEX_LNK_EXECUTEUPDATE = 'Update now';
var TXT_INDEX_LNK_REFUSEUPDATE  = 'Don\'t notify me of major updates';
var TXT_INDEX_CNF_CONFIRMUPDATE = 'Are you sure you want to update?';
var TXT_INDEX_LBL_VERSION       = 'Version';
function TXT_UPDATE_INDEX_NOTICEUPDATE($update_level)        {
	var $text = 'There is a new update ' + TXT_UPDATE_CLASSIFICATION[$update_level];
	if ($update_level == 3) $text = $text + 'This update may take a few minutes to several tens of minutes.';
	return $text;
}
function TXT_UPDATE_MSG_03($update_level, $target_version)   { var $text = 'A new ' + TXT_UPDATE_CLASSIFICATION[$update_level] + ' is complete. A new version ' + $target_version + ' has been applied.'; return $text;}


/*
 * _posts
 * ------------------------------------------------------------------------------------------------ */
var TXT_POSTS_LBL_CHECKALL   = 'Check all';
var TXT_POSTS_LBL_UNCHECKALL = 'Uncheck all';
function TXT_POSTS_CFM_DELETE($target) { var $text = 'Remove the checked ' + $target + '. If you delete it, it cannot be undone. Do you still want to do it?'; return $text;}


/*
 * _post
 * ------------------------------------------------------------------------------------------------ */
var TXT_POST_ALT_NOSAVE         = 'Some changes have not been saved. Do you want to discard and move your changes?';
var TXT_POST_ALT_DELETEBUTTON   = 'Allowed to be deleted.';
var TXT_POST_CFM_DELETE_GALLERY = 'Do you want to delete all galleries?';
var TXT_POST_MSG_SYNTAX         = 'Update with Shift + Enter';
var TXT_POST_LBL_NEWPAGE        = 'New page';
var TXT_POST_MSG_SAVE           = 'Save';
var TXT_POST_CFM_DELETE         = 'Are you sure you want to delete this version? (Deleted version cannot be undone)';
var TXT_POST_CFM_CHANGE_SLUG    = 'If you change the slug, the URL may also change. Are you sure you want to do this?';
var TXT_POST_STATUS_DRAFTED     = 'Draft';
var TXT_POST_STATUS_PUBLISHED   = 'Published';
var TXT_POST_STATUS_SCHEDULED   = 'Reserved';
var TXT_POST_STATUS_ENDED       = 'Closed';
var TXT_POST_STATUS_CANCELED    = 'Unpublish';
var TXT_POST_PREVIEW            = 'Preview';
var TXT_POST_GALLERY_CAPTION    = 'Caption';


/*
 * _comments
 * ------------------------------------------------------------------------------------------------ */
var TXT_COMMENT_LBL_CHECKALL   = 'Check All';
var TXT_COMMENT_LBL_UNCHECKALL = 'Uncheck All';
function TXT_COMMENT_CFM_DELETE($target) { var $text = 'Remove the checked ' + $target + '. If you delete it, it cannot be undone. Do you still want to do it?'; return $text;}

/*
 * _comment
 * ------------------------------------------------------------------------------------------------ */
var TXT_COMMENT_ALT_DELETEBUTTON = 'You can delete it with the delete button at the bottom left of the screen. Once deleted, it cannot be undone.';


/*
 * _contacts
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONTACTS_LBL_CHECKALL   = 'Check All';
var TXT_CONTACTS_LBL_UNCHECKALL = 'Uncheck All';
var TXT_CONTACTS_CFM_DELETE     = 'Remove the checked contact. If you delete it, it cannot be undone. Do you still want to do it?';


/*
 * _contact
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONTACT_CNF_UPDATE       = 'This contact is entered directly from the form. Are you sure you want to change the content?';
var TXT_CONTACT_CNF_ALLOWDELETE  = 'This contact is entered directly from the form. Are you sure you want to allow the deletion?';
var TXT_CONTACT_ALT_DELETEBUTTON = 'You can delete it with the delete button at the bottom left of the screen. Once deleted, it cannot be undone.';


/*
 * _image_frame
 * ------------------------------------------------------------------------------------------------ */
var TXT_IMAGEFRAME_LBL_WIDTH_AUTO  = 'Max Width';
var TXT_IMAGEFRAME_LBL_WIDTH_CROP  = 'Fixed Width';
var TXT_IMAGEFRAME_LBL_HEIGHT_AUTO = 'Max Height';
var TXT_IMAGEFRAME_LBL_HEIGHT_CROP = 'Fixed Height';


/*
 * _config_core
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONFICORE_CFM_UPDATE = 'Are you sure you want to allow core settings to be updated?';


/*
 * _config_option
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONFIGOPTION_CFM_USEPOSTTYPE = 'Multi Post-types must be enabled for this feature to take effect.';


/*
 * _config_posttype
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONFIGPOSTTYPE_WAR_LACKOFITEM = 'The required fields for the permalink have not yet been entered.';


/*
 * _user
 * ------------------------------------------------------------------------------------------------ */
var TXT_USER_WAR_OVERLAPACCOUNT = 'This account is already registered.';
var TXT_USER_ALT_CANTSETGROUP   = 'Site administrators cannot be set to groups. Removes the group setting.';


/*
 * change_password
 * ------------------------------------------------------------------------------------------------ */
var TXT_POST_CFM_CHANGE_ACCOUNT    = 'Are you sure you want to do this?';

/*
 * edit_hierarchy
 * ------------------------------------------------------------------------------------------------ */
function TXT_EDITHIERARCHY_ALT_DELETE($target_name) { var $text = 'Remove the checked ' + $target_name + ' by the delete button at the bottom right of the screen. If you delete it, it cannot be undone. Do you still want to do it?'; return $text;};


/*
 * check_slug
 * ------------------------------------------------------------------------------------------------ */
var TXT_CHECKSLUG_WAR_OVERLAPSLUG = 'Slugs that have already been used.';


/*
 * taxonomy
 * ------------------------------------------------------------------------------------------------ */
var TXT_TAXONOMY_ALT_NOLABEL    = 'Please enter a label.';
var TXT_TAXONOMY_CFM_HASNOLABEL = 'There are some unfilled labels, but are you sure you want to register it as it is?';


/*
 * tinymce_auto_save
 * ------------------------------------------------------------------------------------------------ */
var TXT_TINYMCEAUTOSAVE_FILEMANAGERTITLE = 'File Manager';
