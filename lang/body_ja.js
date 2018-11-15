/*
 * _reset_system
 * ------------------------------------------------------------------------------------------------ */
var TXT_RESETSYSTEM_ALT_SHIFTDB       = 'データベースを移行します。移行先のデータは全て上書きされます（このシステムで使用しないテーブルには影響ありません）。';
var TXT_RESETSYSTEM_MSG_NOWSHIFTDB    = 'データベースを移行しています。画面を閉じないでください。';
var TXT_RESETSYSTEM_MSG_NOWSETTING    = '設定中です。画面を閉じないでください。';
var TXT_RESETSYSTEM_ALT_INVALID_EMAIL = 'メールアドレスが不正です';
var TXT_RESETSYSTEM_MSG_ISSUED_ACTIVATIONKEY  = 'アクティベーションキーが発行されました。メールを確認してください。';
var TXT_RESETSYSTEM_MSG_ONISSUE_ACTIVATIONKEY = 'アクティベーションキーを発行中です。しばらくお待ち下さい。';
var TXT_RESETSYSTEM_LNK_DOWNLOAD_PASSWORD     = 'パスワードをダウンロード';


/*
 * _update / _index
 * ------------------------------------------------------------------------------------------------ */
var TXT_UPDATE_CLASSIFICATION   = {1: 'マイクロアップデート' , 2: 'マイナーアップデート' , 3: 'メジャーアップデート'};
var TXT_UPDATE_MSG_01           = 'アップデートを確認しています...';
var TXT_UPDATE_MSG_02           = 'アップデートを準備しています...';
var TXT_UPDATE_MSG_02           = 'アップデートしています...（画面を閉じないでください）';
var TXT_UPDATE_MSG_04           = '処理が中止されました。';
var TXT_UPDATE_MSG_61           = 'システムは最新です。';
var TXT_UPDATE_MSG_91           = 'サーバとの通信が混み合っています。アップデート処理をキャンセルします。(ERROR_CODE:91)';
var TXT_UPDATE_MSG_92           = 'アップデート内容の取得に失敗しました。アップデート処理をキャンセルします。(ERROR_CODE:92)';
var TXT_UPDATE_MSG_93           = 'アップデートの準備に失敗しました。アップデート処理をキャンセルします。(ERROR_CODE:93)';
var TXT_UPDATE_MSG_94           = 'アップデート中にエラーが発生しました。アップデート処理をキャンセルします。(ERROR_CODE:94)';
var TXT_UPDATE_MSG_95           = 'アップデート中にエラーが発生しました。アップデート処理をキャンセルします。(ERROR_CODE:95)';
var TXT_UPDATE_MSG_96           = 'アップデート中にエラーが発生しました。アップデート処理をキャンセルします。(ERROR_CODE:96)';
var TXT_INDEX_LNK_EXECUTEUPDATE = '今すぐアップデートする';
var TXT_INDEX_LNK_REFUSEUPDATE  = '今後メジャーアップデートを通知しない';
var TXT_INDEX_CNF_CONFIRMUPDATE = 'アップデートしてもよろしいですか？（下のリンクからアップデート内容を確認することができきます）';
var TXT_INDEX_LBL_VERSION       = 'バージョン';
function TXT_UPDATE_INDEX_NOTICEUPDATE($update_level)        { var $text = '新しい' + TXT_UPDATE_CLASSIFICATION[$update_level] + 'があります。'; return $text;}
function TXT_UPDATE_MSG_03($update_level, $target_version)   { var $text = TXT_UPDATE_CLASSIFICATION[$update_level] + 'が完了しました。新しいバージョン' + $target_version + 'が適用されました。'; return $text;}


/*
 * _posts
 * ------------------------------------------------------------------------------------------------ */
var TXT_POSTS_LBL_CHECKALL   = '全てチェックする';
var TXT_POSTS_LBL_UNCHECKALL = '全てのチェックを外す';
function TXT_POSTS_CFM_DELETE($target) { var $text = 'チェックした' + $target + 'を削除します。削除すると元には戻せません。よろしいですか？'; return $text;}


/*
 * _post
 * ------------------------------------------------------------------------------------------------ */
var TXT_POST_ALT_NOSAVE         = '保存されていない変更があります。変更を破棄して移動しますか？';
var TXT_POST_ALT_DELETEBUTTON   = '削除を許可しました。';
var TXT_POST_CFM_DELETE_GALLERY = 'ギャラリーを全て削除しますか？';
var TXT_POST_MSG_SYNTAX         = '「Shift」 + 「Enter」 で更新反映';
var TXT_POST_LBL_NEWPAGE        = '新しいページ';
var TXT_POST_MSG_SAVE           = '保存';
var TXT_POST_CFM_DELETE         = 'このバージョンを削除しますか？（削除したバージョンは元に戻せません。）';


/*
 * _comments
 * ------------------------------------------------------------------------------------------------ */
var TXT_COMMENT_LBL_CHECKALL   = '全てチェックする';
var TXT_COMMENT_LBL_UNCHECKALL = '全てのチェックを外す';
function TXT_COMMENT_CFM_DELETE($target) { var $text = 'チェックした' + $target + 'を削除します。削除すると元には戻せません。よろしいですか？'; return $text;}

/*
 * _comment
 * ------------------------------------------------------------------------------------------------ */
var TXT_COMMENT_ALT_DELETEBUTTON = '画面左下の削除ボタンで削除できます。一度削除すると元に戻せません。';


/*
 * _contacts
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONTACTS_LBL_CHECKALL   = '全てチェックする';
var TXT_CONTACTS_LBL_UNCHECKALL = '全てのチェックを外す';
var TXT_CONTACTS_CFM_DELETE     = 'チェックしたコンタクトを削除します。削除すると元には戻せません。よろしいですか？';


/*
 * _contact
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONTACT_CNF_UPDATE       = 'このコンタクトはフォームから直接入力されています。本当に内容を変更しますか？';
var TXT_CONTACT_CNF_ALLOWDELETE  = 'このコンタクトはフォームから直接入力されています。本当に削除を許可しますか？';
var TXT_CONTACT_ALT_DELETEBUTTON = '画面左下の削除ボタンで削除できます。一度削除すると元に戻せません。';


/*
 * _image_frame
 * ------------------------------------------------------------------------------------------------ */
var TXT_IMAGEFRAME_LBL_WIDTH_AUTO  = '横最大サイズ';
var TXT_IMAGEFRAME_LBL_WIDTH_CROP  = '横固定サイズ';
var TXT_IMAGEFRAME_LBL_HEIGHT_AUTO = '縦最大サイズ';
var TXT_IMAGEFRAME_LBL_HEIGHT_CROP = '縦固定サイズ';


/*
 * _config_core
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONFICORE_CFM_UPDATE = 'コア設定の更新を許可してもよろしいですか？';


/*
 * _config_option
 * ------------------------------------------------------------------------------------------------ */
var TXT_CONFIGOPTION_CFM_USEPOSTTYPE = 'この機能を有効にするにはマルチポストタイプを有効にする必要があります。';


/*
 * _user
 * ------------------------------------------------------------------------------------------------ */
var TXT_USER_WAR_OVERLAPACCOUNT = 'すでに登録されているアカウントです。';
var TXT_USER_ALT_CANTSETGROUP   = 'サイト管理者はグループに設定できません。グループ設定を解除します。';


/*
 * edit_hierarchy
 * ------------------------------------------------------------------------------------------------ */
function TXT_EDITHIERARCHY_ALT_DELETE($target_name) { var $text = '画面右の削除ボタンで' + $target_name + 'が削除されます。\n一度削除した' + $target_name + 'は元に戻せません。'; return $text;};


/*
 * check_slug
 * ------------------------------------------------------------------------------------------------ */
var TXT_CHECKSLUG_WAR_OVERLAPSLUG = 'すでに使用されているスラッグです。';


/*
 * taxonomy
 * ------------------------------------------------------------------------------------------------ */
var TXT_TAXONOMY_ALT_NOLABEL    = 'ラベルを入力してください。';
var TXT_TAXONOMY_CFM_HASNOLABEL = '未入力のラベルがありますがこのまま登録してよろしいですか？';


/*
 * tinymce_auto_save
 * ------------------------------------------------------------------------------------------------ */
var TXT_TINYMCEAUTOSAVE_FILEMANAGERTITLE = 'ファイルマネージャー';
