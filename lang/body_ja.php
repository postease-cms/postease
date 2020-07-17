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
define('TXT_GLOBAL_UNT_COUNT', '件');
define('TXT_GLOBAL_UNT_SCORE', '点');


/*
 * header
 * ------------------------------------------------------------------------------------------------ */
define('TXT_HEADER_TITLE', '管理画面');


/*
 * global_navi
 *
 *  */
define('TXT_GNAVI_LNK_LOGOUT', 'ログアウト');


/*
 * main_menu
 * ------------------------------------------------------------------------------------------------ */
define('TXT_MAINMENU_LBL_EDIT',           '編集');
define('TXT_MAINMENU_LBL_LIST',           '一覧');
define('TXT_MAINMENU_LBL_NEW',            '新規');
define('TXT_MAINMENU_LBL_CATEGORY',       'カテゴリ');
define('TXT_MAINMENU_LBL_TAG',            'タグ');
define('TXT_MAINMENU_LBL_CUSTOMITEM',     'カスタムアイテム');
define('TXT_MAINMENU_LBL_CONTACT',        'コンタクト');
define('TXT_MAINMENU_LBL_CONFIGPOSTTYPE', '設定');
define('TXT_MAINMENU_LBL_CONFIGCONTACT',  '設定');
define('TXT_MAINMENU_LBL_INQUIRY',        '照会');
define('TXT_MAINMENU_LBL_MEDIA',          'メディア');
define('TXT_MAINMENU_LBL_IMAGE_CONFIG',   'イメージフレーム');
define('TXT_MAINMENU_LBL_USER',           'ユーザ');
define('TXT_MAINMENU_LBL_GROUP',          'グループ');
define('TXT_MAINMENU_LBL_CHANGE_PASS',    'アカウント更新');
define('TXT_MAINMENU_LBL_SITE_OPTION',    'サイトオプション');
define('TXT_MAINMENU_LBL_SITE',           'サイト');
define('TXT_MAINMENU_LBL_POSTTYPE',       'ポストタイプ');
define('TXT_MAINMENU_LBL_LANGUAGE',       '言語');
define('TXT_MAINMENU_LBL_CONFIG',         '設定');
define('TXT_MAINMENU_LBL_GENERAL',        '一般');
define('TXT_MAINMENU_LBL_OPTION',         'オプション');
define('TXT_MAINMENU_LBL_CORE',           'コア');


/*
 * _reset_system
 * ------------------------------------------------------------------------------------------------ */
define('TXT_RESETSYSTEM_LBL_DATABASE_FIRSTSET', 'データベース');
define('TXT_RESETSYSTEM_LBL_DATABASE_CHANGEDB', '移行先データベース');

/*
 * reset_system
 * ------------------------------------------------------------------------------------------------ */
define('TXT_RESETSYSTEM_TITLE',                   '管理画面 | 初期設定');
define('TXT_RESETSYSTEM_LNK_BACKCONFIG',          '戻る');
define('TXT_RESETSYSTEM_LNK_BACKLOGIN',           'キャンセル');
define('TXT_RESETSYSTEM_LBL_HINT_ERR10',          '設定中のデータベースに接続できない理由は何ですか？');
define('TXT_RESETSYSTEM_LBL_GETACTIVATIONKEY',    'アクティベーションキーを取得');
define('TXT_RESETSYSTEM_PLH_VALIDEMAIL',          '受信可能なメールアドレスを入力してください');
define('TXT_RESETSYSTEM_BTN_GETACTIVATIONKEY',    '取得');
define('TXT_RESETSYSTEM_LBL_REQUIRED',            '必須');
define('TXT_RESETSYSTEM_LBL_ACTIVATIONKEY',       'アクティベーションキー');
define('TXT_RESETSYSTEM_PLH_ACTIVATIONKEY',       'アクティベーションキー（メールを確認してください）');
define('TXT_RESETSYSTEM_ALT_ACTIVATIONKEY',       'メールに記載されたアクティベーションキーを入力してください。');
define('TXT_RESETSYSTEM_ALT_INVALIDEMAIL',        '受信可能な正しいメールアドレスを入力してください。');
define('TXT_RESETSYSTEM_LBL_EMAIL',               'メールアドレス');
define('TXT_RESETSYSTEM_PLH_EMAIL',               'メールアドレス');
define('TXT_RESETSYSTEM_WAR_REUSE_ACTIVATIONKEY', 'このアクティベーションキーを再利用する場合はダウンロードの際に使用したメールアドレスを入力してください。アクティベーションキーを再利用した場合、同じアクティベーションキーでインストールした以前のシステムは使用できなくなります。');
define('TXT_RESETSYSTEM_WAR_RESET_ACTIVATIONKEY', 'システムのコピー（移動）もしくはドメインの変更でシステムを再設定する場合は、ダウンロードの際に使用したメールアドレスを入力してください。<br>このシステムを再設定した場合、同じアクティベーションキーが割当てられた他のシステムは使用できなくなります。');
define('TXT_RESETSYSTEM_LBL_SITENAME',            'サイト名');
define('TXT_RESETSYSTEM_PLH_SITENAME',            'サイト名（あとから変更できます）');
define('TXT_RESETSYSTEM_LBL_ACCOUNT',             'アカウント');
define('TXT_RESETSYSTEM_PLH_ACCOUNT',             'ログインアカウント（メールアドレス推奨 / あとから変更できます）');
define('TXT_RESETSYSTEM_ALT_ACCOUNT',             'アルファベットで始まる[ 半角英数小文字_ ]３文字以上32文字以内で入力してください。');
define('TXT_RESETSYSTEM_LBL_NICKNAME',            'ニックネーム');
define('TXT_RESETSYSTEM_PLH_NICKNAME',            'ログイン表示名（あとから変更できます）');
define('TXT_RESETSYSTEM_LBL_PASSWORD',            'パスワード');
define('TXT_RESETSYSTEM_PLH_PASSWORD',            'ログインパスワード（あとから変更できます）');
define('TXT_RESETSYSTEM_BTN_AUTOGENERATEPASSWORD','自動生成');
define('TXT_RESETSYSTEM_ALT_PASSWORD',            '使用できるのは半角英数字と記号（/*-+.,!?#$%()~|_）です。７文字以上32文字以内で入力してください。');
define('TXT_RESETSYSTEM_LBL_TIMEZONE',            'タイムゾーン');
define('TXT_RESETSYSTEM_PLH_DATABASE',            'データベース');
define('TXT_RESETSYSTEM_LBL_CHANGEDB',            'データベースを移行する');
define('TXT_RESETSYSTEM_LBL_TABLEPREFIX',         'テーブル接頭辞');
define('TXT_RESETSYSTEM_PLH_TABLEPREFIX',         '例) postease_');
define('TXT_RESETSYSTEM_ALT_TABLEPREFIX',         '半角英数小文字2文字以上8文字以内と _ で入力してください。');
define('TXT_RESETSYSTEM_BTN_AUTOGENERATEPREFIX',  '自動生成');
define('TXT_RESETSYSTEM_LBL_DBHOST',              'DBホスト');
define('TXT_RESETSYSTEM_PLH_DBHOST',              'MySQLの場合のみ');
define('TXT_RESETSYSTEM_LBL_DBNAME',              'DB名');
define('TXT_RESETSYSTEM_PLH_DBNAME',              'MySQLの場合のみ');
define('TXT_RESETSYSTEM_LBL_DBUSER',              'DBユーザ');
define('TXT_RESETSYSTEM_PLH_DBUSER',              'MySQLの場合のみ');
define('TXT_RESETSYSTEM_LBL_DBPASS',              'DBパスワード');
define('TXT_RESETSYSTEM_PLH_DBPASS',              'MySQLの場合のみ');
function TXT_RESETSYSTEM_MSG_USINGDB($database)   { return $text = '現在 ' . $database . ' を使用しています。';}
function TXT_RESETSYSTEM_MSG_PREVIOUSACTIVATIONKEY($activation_key) { return $text = '元のアクティベーションキーは ' . $activation_key . ' です。';}


/*
 * _login
 * ------------------------------------------------------------------------------------------------ */
define('TXT_LOGIN_WAR_LOGIN',   'アカウントかパスワードが間違っています。');
define('TXT_LOGIN_WAR_IP',      '不正なIPアドレスからアクセスされました。');
define('TXT_LOGIN_WAR_SESSION', '予期せぬ理由によりログイン状態が破棄されました。');

/*
 * login
 * ------------------------------------------------------------------------------------------------ */
define('TXT_LOGIN_LBL_ACCOUNT',        'アカウント');
define('TXT_LOGIN_PLH_ACCOUNT',        'アカウントを入力してください');
define('TXT_LOGIN_LBL_PASSWORD',       'パスワード');
define('TXT_LOGIN_PLH_PASSWORD',       'パスワードを入力してください');
define('TXT_LOGIN_LBL_REMEMBER',       'アカウントとパスワードを記憶');
define('TXT_LOGIN_VAL_DISABLELOGIN',   'システム管理者に連絡してください。');
define('TXT_LOGIN_LNK_CONFIRMSETTING', '再度アクセスする');
define('TXT_LOGIN_VAL_SUBMIT',         'ログイン');


/*
 * _index
 * ------------------------------------------------------------------------------------------------ */
function TXT_INDEX_LABEL_SMARTCACHE($use_advanced_cache = 0, $license_type = 0)
{
  return $label = ($use_advanced_cache && $license_type > 0) ? 'スマートキャッシュ・アドバンス' : 'スマートキャッシュ';
}
function TXT_INDEX_LINK_TURN_SMARTCACHE($use_advanced_cache = 0, $license_type = 0)
{
  $html = 'さらに高速な “スマートキャッシュ・アドバンス” は「アドバンス」ライセンス以上で利用できます。';
  if ($license_type > 0)
  {
    $html = ($use_advanced_cache) ? '<a href="javascript:turnFunction(\'use_advanced_cache_flg\', 0);">スマートキャッシュ・アドバンスを無効にする</a>' : '<a href="javascript:turnFunction(\'use_advanced_cache_flg\', 1);">さらに高速なスマートキャッシュ・アドバンスを有効にする</a>';
  }
  return $html;
}
function TXT_INDEX_MSG_SMARTCACHE_VALID($use_advanced_cache = 0, $license_type = 0, $license_valid_to = null)
{
  $text = 'この機能は標準で常に有効です。';
  if ($use_advanced_cache)
  {
    if ($license_type > 0 && $license_valid_to)
    {
      $valid_to = ($license_valid_to == '9999-99-99') ? '無期限で' : ' '. date('Y年m月d日', strtotime($license_valid_to)) . ' まで';
      $text = "この機能は{$valid_to}利用可能です。";
    }
  }
  return $text;
}
define('TXT_INDEX_LABEL_VERSION',      'バージョン管理');
function TXT_INDEX_LINK_TURN_VERSION($use_version = 0, $license_type = 0)
{
  $html = '公開ポストのリライトや復元が自由にできる “バージョン管理” は「アドバンス」ライセンス以上で利用できます。';
  if ($license_type > 0)
  {
    $html = ($use_version) ? '<a href="javascript:turnFunction(\'use_version_flg\', 0);">バージョン管理を無効にする</a>' : '<a href="javascript:turnFunction(\'use_version_flg\', 1);">バージョン管理を有効にする</a>';
  }
  return $html;
}
function TXT_INDEX_MSG_VERSION_VALID($use_version = 0, $license_type = 0, $license_valid_to = null)
{
  $text = 'この機能は無効です。';
  if ($use_version)
  {
    if ($license_type > 0 && $license_valid_to)
    {
      $valid_to = ($license_valid_to == '9999-99-99') ? '無期限で' : ' '. date('Y年m月d日', strtotime($license_valid_to)) . ' まで';
      $text = "この機能は{$valid_to}利用可能です。";
    }
  }
  return $text;
}


/*
 * index
 * ------------------------------------------------------------------------------------------------ */
define('TXT_INDEX_WAR_PASSWORD_01',         'パスワードが初期設定のままです。<a href="?view_page=change_password">こちら</a>から変更してください');
define('TXT_INDEX_WAR_PASSWORD_02',         '３ヶ月以上パスワードが変更されていません。メニュー「ユーザ」「アカウント更新」で変更してください。');
define('TXT_INDEX_LBL_SUMMARY',             'サマリー');
define('TXT_INDEX_LBL_POST_TOTAL',          'ポスト合計');
define('TXT_INDEX_LBL_PAGE',                '下層ページ');
define('TXT_INDEX_LBL_POSTPAGE',            '総ページ');
define('TXT_INDEX_WAR_NO_POSTTYPE',         'このサイトにはポストタイプが設定されていません。');
define('TXT_INDEX_WAR_CORRECT_DOMAIN',      'ドメインの変更を適用しています。このメッセージが出ている間は操作をしないでください。');
define('TXT_INDEX_WAR_CORRECT_DIRNAME',     'パスの変更を適用しています。このメッセージが出ている間は操作をしないでください。');
define('TXT_INDEX_LBL_CONTACT_TOTAL',       'コンタクト合計');
define('TXT_INDEX_WAR_NO_CONTACT',          'このサイトにはコンタクトが設定されていません。');
define('TXT_INDEX_LBL_IMPLEMENT_CODE',      '共通実装コード');
define('TXT_INDEX_MSG_LOGINASSITEADMIN',    '[サイト管理者] 権限でログインしています。');
define('TXT_INDEX_MSG_LOGINASSYSTEMADMIN',  '[システム管理者] 権限でログインしています。全ての操作が可能です。');
define('TXT_INDEX_MSG_ABOUTSYSTEM',         'このシステムについて');
define('TXT_INDEX_MSG_SMARTCACHE',          'この機能は常に有効です');
define('TXT_INDEX_MSG_VERSION',             'バージョン管理');

function TXT_INDEX_WELCOME($nickname)                { return $text = 'ようこそ ' . $nickname . ' さん！';}
function TXT_INDEX_WAR_DOMAIN($domain)               { return $text = 'アクセス中のドメインと設定ドメインが違います（設定ドメインは ' . $domain . ' ）。メニュー「設定」「コア」で修正してください。';}
function TXT_INDEX_WAR_DIR($dir)                     { return $text = 'アクセス中のディレクトリ名と設定ディレクトリ名が違います（設定ディレクトリ名は ' . $dir . ' ）。メニュー「設定」「コア」で修正してください。';}
function TXT_INDEX_WAR_SQLITEPERMISSION($perm)       { return $text = 'SQLite に書込権限がありません。適切なパーミッションに変更して下さい（現在のパーミッションは ' . $perm . ' ）。';}
function TXT_INDEX_WAR_BUSINESSLICENSE($days, $date) { return $text = 'アドバンスライセンスの有効期限が残り ' . $days . '日 になりました（有効期限は ' . date('Y年m月d日', strtotime($date)) . ' ）。<a target="_blank" href="https://classic.postease.org/license/">サービスサイト</a>より新しいアドバンスライセンスを購入してください。<br>アドバンスライセンスの購入に必要なアクティベーションキーの確認は<a href="?view_page=about_system">こちら</a>から。';}
function TXT_INDEX_MSG_LOGIN_DATETIME($datetime)     { return $text = $datetime . ' にログインしました。';}
function TXT_INDEX_LBL_SMARTCACHE($license = 0)
{
  $label = 'スマートキャッシュ';
  if ($license > 0)
  {
    $label = 'スマートキャッシュ・アドバンス';
  }
  return $label;
}
function TXT_INDEX_LBL_NOTICE_DRAFT($count_parent = 0, $count_child = 0)
{
	if ($count_parent > 0 && $count_child == 0)
	{
		return $text = $count_parent . '件の下書きポストがあります。';
	}
	elseif ($count_parent == 0 && $count_child > 0)
	{
		return $text = $count_child . '件の下書きページがあります。';
	}
	elseif ($count_parent > 0 && $count_child > 0)
	{
		return $text = $count_parent . '件の下書きポストと'.$count_child . '件の下書きページがあります。';
	}
	return false;
}


/*
 * about_system
 * ------------------------------------------------------------------------------------------------ */
define('TXT_ABOUTSYSTEM_LBL_TITLE',            'POSTEASE について');
define('TXT_ABOUTSYSTEM_THD_THISVERSION',      'バージョン');
define('TXT_ABOUTSYSTEM_THD_LICENSE',          'ライセンス');
define('TXT_ABOUTSYSTEM_LBL_LICENSEBASIC',     'ベーシック');
define('TXT_ABOUTSYSTEM_LBL_LICENSEADVANCED',  'アドバンス');
define('TXT_ABOUTSYSTEM_LBL_LICENSEBUSINESS',  'ビジネス');
define('TXT_ABOUTSYSTEM_ALT_FAILLICENSE',      'ライセンスの取得に失敗しました。');
define('TXT_ABOUTSYSTEM_LBL_UNLIMITED',        '無期限');
define('TXT_ABOUTSYSTEM_THD_ACTIVATIONKEY',     'アクティベーションキー');
define('TXT_ABOUTSYSTEM_THD_DATABASE',         'データベース');
define('TXT_ABOUTSYSTEM_LBL_UPDATEHISTORIY',   'アップデート履歴');
define('TXT_ABOUTSYSTEM_LBL_APPLYLEVEL',       'アップデート種別');
define('TXT_ABOUTSYSTEM_THD_APPLIEDVERSION',   'バージョン');
define('TXT_ABOUTSYSTEM_THD_APPLIEDLEVEL',     'アップデート種別');
define('TXT_ABOUTSYSTEM_LBL_DELTEXT_UPDATE',   'アップデート');
define('TXT_ABOUTSYSTEM_THD_APPLIEDAT',        '適用日時');
define('TXT_ABOUTSYSTEM_THD_APPLIEDDETAIL',    '詳細');
define('TXT_ABOUTSYSTEM_LBL_PURCHASEHISTORIY', '購入履歴');
define('TXT_ABOUTSYSTEM_THD_PURCHASEDAT',      '購入日時');
define('TXT_ABOUTSYSTEM_THD_EXTRALICENSECODE', '購入ライセンス');
define('TXT_ABOUTSYSTEM_THD_PURCHASEPRICE',    '購入単価');
define('TXT_ABOUTSYSTEM_THD_VALID',            '有効期限');
function TXT_ABOUTSYSTEM_MSG_VALIDTO($valid_to) { return $text = $valid_to . 'まで有効';}


/*
 * _posts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTS_PAGETITLE_SUB', '一覧');
define('TXT_POSTS_MSG_NEWPOST',   '新規投稿が完了しました。');
function TXT_POSTS_MSG_UPDATE($number, $target){ return $text = "{$number}件の{$target}を更新しました。";}
function TXT_POSTS_MSG_CLONE($number, $target){ return $text = "{$number}件の{$target}を複製しました。";}
function TXT_POSTS_MSG_DELETE($number, $target){ return $text = "{$number}件の{$target}を削除しました。";}

/*
 * posts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTS_LBL_CHANGE_LANGUAGE',       '言語切替');
define('TXT_POSTS_SEL_DEFAULT_STATUS',        '全てのステータス');
define('TXT_POSTS_SEL_DEFAULT_CATEGORY',      '全てのカテゴリ');
define('TXT_POSTS_SEL_DEFAULT_TAG',           '全てのタグ');
define('TXT_POSTS_PLH_SEARCH_TEXT',           'テキスト検索');
define('TXT_POSTS_PLH_SEARCH_STARTDATE',      '公開日指定（始まり）');
define('TXT_POSTS_PLH_SEARCH_ENDDATE',        '公開日指定（終わり）');
define('TXT_POSTS_PLH_SEARCH_CREATEDBY',      '全ての投稿者');
define('TXT_POSTS_SEL_DEFAULT_ANCHOR',        'アンカー条件なし');
define('TXT_POSTS_SEL_HAS_ANCHOR',            'アンカーあり');
define('TXT_POSTS_LBL_ANCHOR',                'アンカー');
define('TXT_POSTS_SEL_NO_ANCHOR',             'アンカーなし');
define('TXT_POSTS_LBL_SEARCH_CLEAR',          'クリア');
define('TXT_POSTS_THD_STATUS',                'ステータス');
define('TXT_POSTS_THD_CATEGORY',              'カテゴリ');
define('TXT_POSTS_THD_TAG',                   'タグ');
define('TXT_POSTS_THD_POSTEDBY',              '投稿者');
define('TXT_POSTS_THD_UPDATEDBY',             '更新者');
define('TXT_POSTS_THD_COMMENT',               'コメント');
define('TXT_POSTS_THD_REVIEW',                'レビュー');
define('TXT_POSTS_THD_SUBPOST',               'サブポスト');
define('TXT_POSTS_THD_PUBLISHDATE',           '公開日時');
define('TXT_POSTS_LBL_FUTURE',                '公開予定');
define('TXT_POSTS_LBL_PUBLISHED',             '公開中');
define('TXT_POSTS_LBL_ENDED',                 '公開終了');
define('TXT_POSTS_LBL_DRAFT',                 '下書き');
define('TXT_POSTS_LBL_PRIVATE',               '非公開');
define('TXT_POSTS_LBL_NOTITLE',               '（..無題）');
define('TXT_POSTS_LNK_OTHERS',                '..他');
define('TXT_POSTS_LBL_NOSETTING',             '設定なし');
define('TXT_POSTS_LBL_CHECKALL',              '全てチェックする');
define('TXT_POSTS_LBL_ALLOWDELETE',           '削除を許可する');
define('TXT_POSTS_BTN_TO_PUBLISH',            '公開にする');
define('TXT_POSTS_BTN_TO_DRAFT',              '下書きにする');
define('TXT_POSTS_BTN_TO_PRIVATE',            '非公開にする');
define('TXT_POSTS_LBL_CLONE',                 '複製');
define('TXT_POSTS_BTN_CLONE',                 '複製する');
define('TXT_POSTS_LBL_DELETE',                '削除');
define('TXT_POSTS_BTN_DELETE',                '削除する');
define('TXT_POSTS_PLH_CHANGEPUBLISHDATETIME', '公開日時');
define('TXT_POSTS_LBL_CHANGEPUBLISHDATETIME', '公開日時更新');
define('TXT_POSTS_LBL_ADDTAXONOMY',           '追加');
define('TXT_POSTS_LBL_DELETETAXONOMY',        '削除');
define('TXT_POSTS_SEL_OPERATION_CATEGORY',    'カテゴリ');
define('TXT_POSTS_SEL_OPERATION_TAG',         'タグ');
define('TXT_POSTS_LBL_IMPLEMENT_CODE',        '実装コード');
function TXT_POSTS_WAR_NOPOST($target)            { return $text = "この条件の {$target} はありません。";}
function TXT_POSTS_LBL_CHANGESTATU_TO($target)    { return $text = "チェックした{$target}を";}
function TXT_POSTS_LBL_CHANGECATEGORY_TO($target) { return $text = "チェックした{$target}に";}
function TXT_POSTS_LBL_PUBLISHTENDAT($datetime)   { return $text = "{$datetime}まで";}
function TXT_POSTS_LNK_GETSDKPHP($url) { return $text = 'POSTEASE APIからデータを取得するためのSDK（クライアントツール） <a target="_blank" href="' . $url . '">SDK "Pec" を手に入れる</a>';}


/*
 * _post
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POST_LBL_NEW',                '新規');
define('TXT_POST_LBL_EDIT',               '編集');
define('TXT_POST_BTN_UPDATE',             '更新して公開');
define('TXT_POST_BTN_PUBLISH',            '公開');
define('TXT_POST_BTN_VERSIONPUBLISH',     '差し換え公開');
define('TXT_POST_LNK_BACKTOLIST',         '一覧へ戻る');
define('TXT_POST_LNK_PREVIEWLINK',        'プレビュー');
define('TXT_POST_MSG_PERMALINKNOTYET',    'パーマリンクは作成されていません。');
define('TXT_POST_LNK_PERMALINKLACKITEMS', 'パーマリンクの生成にはスラッグかタイトルと公開日時が必要です。');
define('TXT_POST_LNK_PERMALINK',          'パーマリンク');
define('TXT_POST_MSG_CHILDNEWPOST',       '新しいページを追加しました。');
define('TXT_POST_MSG_CHILDUPDATE',        'ページを更新しました。');
define('TXT_POST_MSG_CHILDDELETE',        'ページを削除しました。');
define('TXT_POST_MSG_VERSIONDELETE',      'バージョンを削除しました。');
define('TXT_POST_LBL_IMPLEMENT_CODE',     '実装コード');
function TXT_POST_LNK_PREVIEW($preview_link) { return $text = "プレビュー ({$preview_link})";} // no use after v3.0.0
function TXT_POST_STATUSTEXT($status, $label, $current_flg = 1)
{
	$status_text = array(
		'primary' => '公開中',
		'warning' => '下書き',
		'default' => '非公開',
	);
	$publish_status_text = array(
		'primary' => '公開中',
		'info'    => '公開予定',
		'default' => '公開終了',
	);
	if ($current_flg == 0 && $status == 1)
  {
    $text = 'アーカイブ';
  }
  else {
    $text = ($status) ? ($status == 1) ? $publish_status_text[$label] : $status_text[$label] : '作成前';
  }
	return $text;
}

/*
 * post
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POST_LBL_NEWPAGE',                       '新しいページ');
define('TXT_POST_LBL_RELEASEDVERSION',               '公開バージョン');
define('TXT_POST_LBL_PRIVATEVERSION',                '非公開バージョン');
define('TXT_POST_MSG_UNEDITABLE',                    '編集権限がありません。');
define('TXT_POST_LBL_AUTOSAVEMODE',                  '自動保存');
define('TXT_POST_MSG_SAVED',                         '保存しています');
define('TXT_POST_LBL_HAS_NEW_DRAFTVERSION'         , '新しい編集中の下書きバージョンがあります。（編集中の下書きバージョンに移動）');
define('TXT_POST_LBL_AUTOSAVEMODE_CANCELED_PUBLISH', '公開中は自動保存が無効化されます。「更新して公開」するまでデータは更新されません。');
define('TXT_POST_LBL_AUTOSAVEMODE_CANCELED_ARCHIVE', 'アーカイブは自動保存が無効化されます。「差し換え公開」するまでデータは更新されません。');
define('TXT_POST_PLH_LIST',                          'リストの区切りは改行です。');
define('TXT_POST_PLH_GALLERY_CAPTION',               'キャプション');
define('TXT_POST_LBL_SELECTDEFAULT',                 '選択');
define('TXT_POST_BTN_IMG_SET',                       '設定');
define('TXT_POST_BTN_IMG_DELETE',                    '削除');
define('TXT_POST_LBL_TITLE',                         'タイトル');
define('TXT_POST_LBL_ADDITION',                      'ディスクリプション');
define('TXT_POST_LBL_CONTENT',                       '本文');
define('TXT_POST_BTN_SAVE',                          '保存');
define('TXT_POST_BTN_DELETE',                        '削除');
define('TXT_POST_BTN_NEW_VERSION',                   '新しいバージョンを下書き作成');
define('TXT_POST_MSG_VERSION_OFF',                   '現在、バージョン管理は無効になっています。');
define('TXT_POST_MSG_DELETEPOSTNORMAL',              '一度削除したポストは元に戻せません。このポストを削除してもよろしいですか？');
define('TXT_POST_MSG_DELETEPOSTCHILD',               '一度削除したページは元に戻せません。このページを削除してもよろしいですか？');
define('TXT_POST_MSG_DELETEPOSTPRIVATE',             '一度削除したバージョンは元に戻せません。このバージョンを削除してもよろしいですか？');
define('TXT_POST_MSG_DELETEPOSTPRIVATEALL',          'このバージョンを削除すると関連する全てのページも同時に削除されます。一度削除すると元に戻せません。削除してもよろしいですか？');
define('TXT_POST_MSG_DELETEPOSTCHILDLEN',            'このポストを削除すると関連する全てのページも同時に削除されます。一度削除すると元に戻せません。削除してもよろしいですか？');
define('TXT_POST_MSG_DELETEPOSTCURRENT',             'このポストを削除すると関連する全てのバージョンも同時に削除されます。一度削除すると元に戻せません。削除してもよろしいですか？');
define('TXT_POST_MSG_DELETEPOSTRELATEDALL',          'このポストを削除すると関連する全てのページと全てのバージョンも同時に削除されます。一度削除すると元に戻せません。削除してもよろしいですか？');
define('TXT_POST_LBL_VERSION',                       'バージョン管理');
define('TXT_POST_LBL_VERSION_ARCHIVED',              'アーカイブバージョン');
define('TXT_POST_LBL_VERSION_CURRENT',               '現在の公開バージョン');
define('TXT_POST_LBL_VERSION_DRAFT',                 '編集中の下書きバージョン');
define('TXT_POST_LBL_CHANGECURRENT',                 'このバージョンに差し替え公開');
define('TXT_POST_LBL_DELETEVERSION',                 'このバージョンを削除する');
define('TXT_POST_LBL_NEWVERSION',                    '新しいバージョン');
define('TXT_POST_LBL_ALLOWDELETEVERSION',            'アーカイブバージョンの削除を許可する');
define('TXT_POST_LBL_SLUG',                          'スラッグ');
define('TXT_POST_LBL_CHANGE_SLUG',                   '変更する');
define('TXT_POST_PLH_SLUG',                          'タイトルより優先的にURLの一部になります。半角英数字と「_」「-」が利用可能です。');
define('TXT_POST_PLH_TITLEWITHSLUG',                 'スラッグが設定されていない場合はURLの一部になります。');
define('TXT_POST_LBL_PUBLISHDATETIME',               '公開日時');
define('TXT_POST_LBL_PUBLISHENDAT',                  '公開終了日時');
define('TXT_POST_PLH_PUBLISHDATE',                   '公開日');
define('TXT_POST_PLH_PUBLISHTIME',                   '公開時間');
define('TXT_POST_LBL_ANCHOR',                        '優先表示アンカー');
define('TXT_POST_LBL_STATUS',                        '公開ステータス');
define('TXT_POST_LBL_PUBLISHED',                     '公開');
define('TXT_POST_LBL_PRIVATE',                       '非公開');
define('TXT_POST_LBL_SITE',                          'サイト');
define('TXT_POST_LBL_POSTTYPE',                      '投稿タイプ');
define('TXT_POST_LBL_EYECATCH',                      'アイキャッチ画像');
define('TXT_POST_LBL_CATEGORY',                      'カテゴリ');
define('TXT_POST_LBL_NOLABEL',                       '..ラベルなし');
define('TXT_POST_MSG_NOCATEGORY',                    '登録カテゴリなし');
define('TXT_POST_LBL_TAG',                           'タグ');
define('TXT_POST_LBL_CREATEATBY',                    '投稿');
define('TXT_POST_LBL_UPDATEATBY',                    '最終更新');
define('TXT_POST_MSG_NOTAG',                         '登録タグなし');
define('TXT_POST_LBL_NEWCOMMENT',                    '新規作成');
define('TXT_POST_MSG_ALLOWDELETEPOST',               'ポストの削除を許可する');
define('TXT_POST_MSG_ALLOWDELETEPAGE',               'ページの削除を許可する');
define('TXT_POST_MSG_ALLOWDELETEVERSION',            'バージョンの削除を許可する');
define('TXT_POST_WAR_NOLANGUAGE',                    'このサイトは言語の設定がありません。「オプション」&gt;「多言語」から設定を行ってください。');
function TXT_POST_LBL_CHANGESTATUS_SAVE($status){ return $text = "{$status}にして更新";}
function TXT_POST_PLH_TABLE($delimiter)         { return $text = "列の区切りは{$delimiter}です。行の区切りは改行です。";}
function TXT_POST_LNK_TURN_AUTOSAVE($turn_from)
{
  $turn = ($turn_from) ? '無効' : '有効';
  return $text = "自動保存を{$turn}にする";
};


/*
 * _comments
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COMMENTS_PAGETITLE_SUB',     '一覧');
define('TXT_COMMENTS_MSG_NEWPOST',       '新規投稿が完了しました。');
define('TXT_COMMENTS_LBL_POSTNOTITLE',   '（..無題）');
define('TXT_COMMENTS_LBL_POSTNOCONTENT', '（..内容の入力はありません）');
function TXT_COMMENTS_MSG_UPDATE($number, $target){ return $text = "{$number} 件の{$target}を更新しました。";}
function TXT_COMMENTS_MSG_DELETE($number, $target){ return $text = "{$number} 件の{$target}を削除しました。";}

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
define('TXT_COMMENTS_LBL_NEW',              '新規');
define('TXT_COMMENTS_LBL_UPDATE',           '更新');
define('TXT_COMMENTS_LBL_FUTURE',           '未来');
define('TXT_COMMENTS_LBL_PUBLISHED',        '公開');
define('TXT_COMMENTS_LBL_RESERVATION',      '保留');
define('TXT_COMMENTS_LBL_PRIVATE',          '非公開');
define('TXT_COMMENTS_LBL_NOTITLE',          '（..無題）');
define('TXT_COMMENTS_LINK_NEW',             '新規');
define('TXT_COMMENTS_LBL_CHECKALL',         '全てチェックする');
define('TXT_COMMENTS_LBL_ALLOWDELETE',      '削除を許可する');
define('TXT_COMMENTS_BTN_TO_PUBLISH',       '公開にする');
define('TXT_COMMENTS_BTN_TO_RESERVATION',   '保留にする');
define('TXT_COMMENTS_BTN_TO_PRIVATE',       '非公開にする');
define('TXT_COMMENTS_LBL_DELETE',           '削除');
define('TXT_COMMENTS_BTN_DELETE',           '削除する');
function TXT_COMMENTS_NARROWDOWN_POSTID($target)  { return $text = "対象{$target}で絞込";}
function TXT_COMMENTS_LBL_TARGET($target)         { return $text = "対象{$target}";}
function TXT_COMMENTS_LNK_CREATE($target)         { return $text = "{$target}を新規作成する";}
function TXT_COMMENTS_LNK_REPLY($target)          { return $text = "関連{$target}を新規作成する";}
function TXT_COMMENTS_THD_RELATEDCOMMENT($target) { return $text = "関連{$target}";}
function TXT_COMMENTS_LBL_ACTION_TO($target)      { return $text = "チェックした{$target}を";}
function TXT_COMMENTS_WAR_NOCOMMENT($target)      { return $text = "この条件の{$target} はありません。";}


/*
 * _comment
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COMMENT_LBL_NEW',              '新規投稿');
define('TXT_COMMENT_LBL_EDIT',             '編集');
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
define('TXT_COMMENT_BTN_DELETE',      '削除');
define('TXT_COMMENT_LBL_POSTEDAT',    '投稿日時');
define('TXT_COMMENT_PLH_POSTEDAT',    '投稿日時');
define('TXT_COMMENT_LBL_STATUS',      '公開ステータス');
define('TXT_COMMENT_LBL_SITEID',      '対象サイト');
define('TXT_COMMENT_LBL_POSTTYPE',    '対象投稿タイプ');
define('TXT_COMMENT_LBL_CREATEDATBY',  '投稿');
define('TXT_COMMENT_LBL_UPDATEDATBY',  '最終更新');
define('TXT_COMMENT_LBL_NEWCOMMENT',  '新規作成');
function TXT_COMMENT_LBL_CHANGESTATUS_SAVE ($status) { return $text = "{$status}にして閉じる";}
function TXT_COMMENT_MSG_NOCOMMENT ($target, $admin) { return $text = "この{$target}は管理画面から{$admin}により投稿されました。";}
function TXT_COMMENT_LBL_EDIT ($target)              { return $text = "この{$target}を編集する";}
function TXT_COMMENT_LBL_DELETE ($target)            { return $text = "この{$target}を削除する";}
function TXT_COMMENT_LBL_CHILDREN ($target)          { return $text = "子{$target}";}


/*
 * _contacts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACTS_PAGETITLE_MAIN', 'コンタクト');
define('TXT_CONTACTS_PAGETITLE_SUB',  '一覧');
define('TXT_CONTACTS_MSG_NEWCONTACT', '新規投稿が完了しました。');
function TXT_CONTACTS_MSG_UPDATE($number, $target){ return $text = "{$number} 件の{$target}を更新しました。";}
function TXT_CONTACTS_MSG_DELETE($number, $target){ return $text = "{$number} 件の{$target}を削除しました。";}

/*
 * contacts
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACTS_SEL_DEFAULT_STATUS',     '全てのステータス');
define('TXT_CONTACTS_SEL_DEFAULT_WAY',        '全てのコンタクト経路');
define('TXT_CONTACTS_SEL_DEFAULT_CATEGORY',   '全てのカテゴリ');
define('TXT_CONTACTS_PLH_SEARCH_KEYWORD',     'キーワード検索');
define('TXT_CONTACTS_PLH_SEARCH_DATESTART',   '公開日指定（始まり）');
define('TXT_CONTACTS_PLH_SEARCH_DATEEND',     '公開日指定（終わり）');
define('TXT_CONTACTS_LNK_SEARCH_CLEAR',       'クリア');
define('TXT_CONTACTS_THD_STATUS',             'ステータス');
define('TXT_CONTACTS_THD_TITLE',              'タイトル');
define('TXT_CONTACTS_THD_CONTENT',            '本文');
define('TXT_CONTACTS_THD_WAY',                '経路');
define('TXT_CONTACTS_THD_CATEGORY',           'カテゴリ');
define('TXT_CONTACTS_THD_NAME',               '名前');
define('TXT_CONTACTS_THD_EMAIL',              'Eメールアドレス');
define('TXT_CONTACTS_THD_TEL',                '電話番号');
define('TXT_CONTACTS_THD_CONTACTEDAT',        'コンタクト日時');
define('TXT_CONTACTS_LBL_NEW',                '新規');
define('TXT_CONTACTS_LBL_UPDATE',             '更新');
define('TXT_CONTACTS_LBL_COMPLETED',          '対応済');
define('TXT_CONTACTS_LBL_ONGOING',            '対応中');
define('TXT_CONTACTS_LBL_UNCONFIRMED',        '未確認');
define('TXT_CONTACTS_LBL_NOTITLE',            '（..無題）');
define('TXT_CONTACTS_LBL_CATEGORY_OTHER',     '..他');
define('TXT_CONTACTS_LBL_CATEGORY_NOSETTING', '設定なし');
define('TXT_CONTACTS_LBL_CHECKALL',           '全てチェックする');
define('TXT_CONTACTS_LBL_ALLOWDELETE',        '削除を許可する');
define('TXT_CONTACTS_LBL_ACTION_TO',          'チェックしたコンタクトを');
define('TXT_CONTACTS_BTN_TO_COMPLETED',       '対応済にする');
define('TXT_CONTACTS_BTN_TO_ONGOING',         '対応中にする');
define('TXT_CONTACTS_BTN_TO_UNCONFIRMED',     '未確認にする');
define('TXT_CONTACTS_LBL_DELETE',             '削除');
define('TXT_CONTACTS_BTN_DELETE',             '削除する');
function TXT_CONTACTS_WAR_NOCONTACT($target){ return $text = "この条件の{$target} はありません。";}


/*
 * _contact
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACT_PAGETITLEMAIN',        'コンタクト');
define('TXT_CONTACT_PAGETITLESUB_NEW',     '新規');
define('TXT_CONTACT_PAGETITLESUB_INQUIRY', '照会');
define('TXT_CONTACT_LNK_BACKTOLIST',       '一覧へ戻る');

/*
 * contact
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONTACT_LBL_TITLE',        'タイトル');
define('TXT_CONTACT_LBL_LANGUAGE',     '受付言語');
define('TXT_CONTACT_LBL_CONTENT',      '内容');
define('TXT_CONTACT_LBL_NAME',         '名前');
define('TXT_CONTACT_LBL_EMAIL',        'メールアドレス');
define('TXT_CONTACT_LBL_TEL',          '電話番号');
define('TXT_CONTACT_LBL_ZIPCODE',      '郵便番号');
define('TXT_CONTACT_LBL_ADDRESS',      '住所');
define('TXT_CONTACT_BTN_IMG_SET',      '設定');
define('TXT_CONTACT_BTN_IMG_DELETE',   '削除');
define('TXT_CONTACT_LBL_NOTE',         'メモ');
define('TXT_CONTACT_BTN_CREATE',       '作成');
define('TXT_CONTACT_BTN_UPDATE',       '更新');
define('TXT_CONTACT_BTN_DELETE',       '削除');
define('TXT_CONTACT_BTN_TO_COMPLETED', '対応済にする');
define('TXT_CONTACT_BTN_TO_ONGOING',   '対応中にする');
define('TXT_CONTACT_LBL_CONTACTEDAT',  'コンタクト日時');
define('TXT_CONTACT_LBL_STATUS',       'ステータス');
define('TXT_CONTACT_LBL_CONTACTWAY',   'コンタクト経路');
define('TXT_CONTACT_LBL_LANGUAGEID',   '受付言語');
define('TXT_CONTACT_LBL_CATEGORY',     'カテゴリ');
define('TXT_CONTACT_MSG_NOCATEGORY',   '登録カテゴリなし');
define('TXT_CONTACT_LBL_CREATEDATBY',  '作成');
define('TXT_CONTACT_LBL_UPDATEDATBY',  '最終更新');
define('TXT_CONTACT_LBL_EDITCHECK',    'このコンタクトを編集する');
define('TXT_CONTACT_LBL_DELETECHECK',  'このコンタクトを削除する');
function TXT_CONTACT_LBL_CHANGESTATUS_SAVE ($status) { return $text = "{$status}にして閉じる";}


/*
 * _media
 * ------------------------------------------------------------------------------------------------ */
define('TXT_MEDIA_PAGETITLEMAIN', 'イメージ');
define('TXT_MEDIA_PAGETITLESUB',  '編集');


/*
 * _image_frame
 * ------------------------------------------------------------------------------------------------ */
define('TXT_IMAGEFRAME_PAGETITLEMAIN', 'イメージフレーム');
define('TXT_IMAGEFRAME_PAGETITLESUB',  '設定');
define('TXT_IMAGEFRAME_MSG_CREATED',   '新規作成が完了しました。');
define('TXT_IMAGEFRAME_MSG_UPDATED',   '更新が完了しました。');
define('TXT_IMAGEFRAME_MSG_DELETED',   '削除が完了しました。');

/*
 * image_frame
 * ------------------------------------------------------------------------------------------------ */
function TXT_IMAGEFRAME_LBL_NOWEDIT($target){ return $text = "{$target} を編集中";}
define('TXT_IMAGEFRAME_LBL_IMAGEFRAME',     'イメージ設定');
define('TXT_IMAGEFRAME_LBL_DISALLOWDELETE', 'fr_admin ディレクトリは削除できません');
define('TXT_IMAGEFRAME_LBL_ALLOWDELETE',    '削除を許可');
define('TXT_IMAGEFRAME_LBL_CANCELEDIT',     '編集をキャンセル');
define('TXT_IMAGEFRAME_LBL_NEW',            '新規');
define('TXT_IMAGEFRAME_LBL_TYPE',           'タイプ');
define('TXT_IMAGEFRAME_LBL_WIDTH',          '横サイズ');
define('TXT_IMAGEFRAME_LBL_HEIGHT',         '縦サイズ');
define('TXT_IMAGEFRAME_LBL_COMMENT',        'コメント');
define('TXT_IMAGEFRAME_LBL_STATUS',         '状態');
define('TXT_IMAGEFRAME_BTN_UPDATE',         '送信');
define('TXT_IMAGEFRAME_BTN_DELETE',         '削除');
define('TXT_IMAGEFRAME_LBL_LIST',           '一覧');
define('TXT_IMAGEFRAME_THD_PARENT_DIR',     'ディレクトリ');
define('TXT_IMAGEFRAME_THD_TYPE',           'タイプ');
define('TXT_IMAGEFRAME_THD_WIDTH',          '横サイズ');
define('TXT_IMAGEFRAME_THD_HEIGHT',         '縦サイズ');
define('TXT_IMAGEFRAME_THD_COMMENT',        'コメント');
define('TXT_IMAGEFRAME_THD_STATUS',         '状態');
define('TXT_IMAGEFRAME_LBL_USE',            '使用');
define('TXT_IMAGEFRAME_LBL_UNUSE',          '不使用');
define('TXT_IMAGEFRAME_LBL_EDIT',           '編集');
define('TXT_IMAGEFRAME_LBL_SIZEMAX',        '最大');


/*
 * _user
 * ------------------------------------------------------------------------------------------------ */
define('TXT_USER_PAGETITLEMAIN',       'ユーザ');
define('TXT_USER_PAGETITLESUB',        '編集');
define('TXT_USER_MSG_USEDACCOUNT',     'すでに使用されているアカウントです。');
define('TXT_USER_MSG_UPDATED',         '更新が完了しました。');
define('TXT_USER_MSG_DELETED',         '削除が完了しました。');
function TXT_USER_MSG_ADDED($default_password){ return $text = "ユーザの追加が完了しました。初期パスワードは {$default_password} です。";}

/*
 * user
 * ------------------------------------------------------------------------------------------------ */
define('TXT_USER_LBL_ALLOWDELETE',     '削除を許可');
define('TXT_USER_LBL_CANCELEDIT',      '編集をキャンセル');
define('TXT_USER_LBL_NEW',             '新規');
define('TXT_USER_LBL_ACCOUNT',         'アカウント（メールアドレス推奨）');
define('TXT_USER_PLH_ACCOUNT',         'richard@postease.co.jp');
define('TXT_USER_LBL_NICKNAME',        'ニックネーム');
define('TXT_USER_PLH_NICKNAME',        'リチャード');
define('TXT_USER_LBL_SITEID',          'アクセス可能サイト');
define('TXT_USER_LBL_POSTTYPEID',      'アクセス可能ポストタイプ');
define('TXT_USER_LBL_POSTTYPEEXTRAID', 'アクセス可能コンタクト');
define('TXT_USER_LBL_CONTACTACCESS',   'コンタクトへのアクセス');
define('TXT_USER_LBL_GROUPID',         'グループ');
define('TXT_USER_SEL_NOGROUP',         'グループなし');
define('TXT_USER_LBL_STATUS',          '権限');
define('TXT_USER_BTN_UPDATE',          '送信');
define('TXT_USER_BTN_DELETE',          '削除');
define('TXT_USER_LBL_LIST',            '一覧');
define('TXT_USER_THD_ID',              'ID');
define('TXT_USER_THD_ACCOUNT',         'アカウント（メールアドレス推奨）');
define('TXT_USER_THD_NICKNAME',        'ニックネーム');
define('TXT_USER_THD_GROUPNAME',       'グループ');
define('TXT_USER_THD_ROLE',            '権限');
define('TXT_USER_LBL_EDIT',            '編集');
function TXT_USER_LBL_DEFAULTPASSWORD($default_password){ return $text = "初期パスワード: {$default_password}";}
function TXT_USER_LBL_NOWEDIT($target){ return $text = "{$target} を編集中";}


/*
 * _change_password
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CHANGEPASSWORD_PAGETITLEMAIN',   'ユーザ');
define('TXT_CHANGEPASSWORD_PAGETITLESUB',    'アカウント更新');
define('TXT_CHANGEPASSWORD_MSG_CHANGED',     'アカウントを更新しました。');

/*
 * change_password
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CHANGEPASSWORD_LBL_CURRENT',     '現在のパスワード');
define('TXT_CHANGEPASSWORD_PLH_CURRENT',     '現在のパスワードを入力してください');
define('TXT_CHANGEPASSWORD_LBL_NEW',         '新しいパスワード');
define('TXT_CHANGEPASSWORD_PLH_NEW',         '新しいパスワードを入力してください');
define('TXT_CHANGEPASSWORD_LBL_CONFIRM',     '新しいパスワード（再入力）');
define('TXT_CHANGEPASSWORD_PLH_CONFIRM',     '新しいパスワードを入力してください（再入力）');
define('TXT_CHANGEPASSWORD_LBL_AUTOGENERATE','新しいパスワードを自動生成');
define('TXT_CHANGEPASSWORD_LBL_ACCOUNT',     'アカウント名の変更（メールアドレス推奨）');
define('TXT_POST_LBL_CHANGE_ACCOUNT',        '変更する');
define('TXT_CHANGEPASSWORD_LBL_NICKNAME',    'ニックネームの変更');
define('TXT_CHANGEPASSWORD_PLH_ACCOUNT',     'アカウント名を入力してください');
define('TXT_CHANGEPASSWORD_PLH_NICKNAME',    'ニックネームを入力してください');
define('TXT_CHANGEPASSWORD_BTN_SUBMIT',      '変更');


/*
 * _config_core
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGCORE_PAGETITLEMAIN',   '設定');
define('TXT_CONFIGCORE_PAGETITLESUB',    'コア');

/*
 * config_core
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGCORE_MSG_UPDATED',                     'コア設定を更新しました。');
define('TXT_CONFIGCORE_LBL_TITLE',                       'コア設定');
define('TXT_CONFIGCORE_LBL_SYSTEM',                      'システム');
define('TXT_CONFIGCORE_LBL_AUTHORITY',                   '編集権限');
define('TXT_CONFIGCORE_LBL_MEDIA',                       'メディア');
define('TXT_CONFIGCORE_LBL_UPDATE',                      'アップデート');
define('TXT_CONFIGCORE_LBL_DATAMANIPULATION',            'データ操作');
define('TXT_CONFIGCORE_LBL_ALLOWUPDATE',                 'コア設定の更新を許可する');
define('TXT_CONFIGCORE_LNK_CHANGEDATABASE',              'データベース移行を実行する');
define('TXT_CONFIGCORE_LBL_DOMAIN',                      'ドメイン');
define('TXT_CONFIGCORE_LBL_DIRNAME',                     'ディレクトリ名');
define('TXT_CONFIGCORE_BTN_FIXURLDIRNAME',               'ドメイン / ディレクトリ名を自動修正する');
define('TXT_CONFIGCORE_LBL_TIMEZONE',                    'タイムゾーン');
define('TXT_CONFIGCORE_LBL_SESSIONKEY',                  'セッションキー');
define('TXT_CONFIGCORE_LBL_UPLOADDIRPERMISSION',         'アップロードディレクトリパーミッション');
define('TXT_CONFIGCORE_LBL_DISPLAYERRORS',               'エラー表示');
define('TXT_CONFIGCORE_LBL_EDITCONTROLL',                'ポスト編集制限');
define('TXT_CONFIGCORE_LBL_PUBLISHROLE',                 'ポスト公開権限');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYPOST',    'ポスト カテゴリ編集権限');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLTAGPOST',         'ポスト タグ編集権限');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCONFIGGENERAL',   '設定(一般)編集権限');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCONFIGPOSTTYPE',  'ポストタイプ カスタム設定編集権限');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCATEGORYCONTACT', 'コンタクト カテゴリ編集権限');
define('TXT_CONFIGCORE_LBL_EDITABLEROLLCONFIGCONTACT',   'コンタクト カスタム設定編集権限');
define('TXT_CONFIGCORE_LBL_DEFAULTPASSWORD',             'ユーザ初期パスワード');
define('TXT_CONFIGCORE_LBL_UPLOADIMAGESIZEMAIN',         '本文画像デフォルトサイズ');
define('TXT_CONFIGCORE_LBL_MAXWIDTH',                    '横最大');
define('TXT_CONFIGCORE_LBL_MAXHEIGHT',                   '縦最大');
define('TXT_CONFIGCORE_LBL_MEDIAPARAMETERFLG',           'メディアパラメータ');
define('TXT_CONFIGCORE_LBL_UPDATEALLOWEDROLE',           'アップデート許可権限');
define('TXT_CONFIGCORE_LBL_UPDATELEVELOROVER',           '以上');
define('TXT_CONFIGCORE_LBL_ALLOWUPDATEFLG',              'アップデートのチェック');
define('TXT_CONFIGCORE_LBL_AUTOUPDATEFLG',               '自動アップデート');
define('TXT_CONFIGCORE_LBL_UPDATELEVEL',                 'アップデートレベル');
define('TXT_CONFIGCORE_LBL_APIACCESS',                   'APIアクセス');
define('TXT_CONFIGCORE_LBL_REMOTE_ADDRESS_ALLOWED',      '許可IP');
define('TXT_CONFIGCORE_LBL_ORIGIN_ALLOWED',              '許可ドメイン');
define('TXT_CONFIGCORE_LBL_APIFORCECACHETIME',           '強制キャッシュ時間(分)');
define('TXT_CONFIGCORE_LBL_CHANGEDATABASE',              'データベース移行');
define('TXT_CONFIGCORE_BTN_SUBMIT',                      '更新');
function TXT_CONFIGCORE_LBL_MORETHAN($target){ return $text = "{$target} (以上)";}


/*
 * _config_general
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGGENERAL_PAGETITLEMAIN',              '設定');
define('TXT_CONFIGGENERAL_PAGETITLESUB',               '一般');
define('TXT_CONFIGGENERAL_LBL_IMPLEMENTCODE',          '実装コード');
define('TXT_CONFIGGENERAL_LBL_DISPLAYIMPLEMENTCODE',   '実装コード 表示');
define('TXT_CONFIGGENERAL_LBL_IMPLEMENTCODETYPE',      '実装コード種別');

/*
 * config_general
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGGENERAL_MSG_UPDATED',      '一般設定を更新しました。');
define('TXT_CONFIGGENERAL_LBL_TITLECOMMON',  '全般');
define('TXT_CONFIGGENERAL_LBL_SITENAME',     'サイト名');
define('TXT_CONFIGGENERAL_LBL_LANGUAGE',     'システム基本言語');
define('TXT_CONFIGGENERAL_LBL_SYSTEMFONT',   'システムフォント');
define('TXT_CONFIGGENERAL_BTN_SUBMIT',       '更新');


/*
 * _config_option
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGOPTION_PAGETITLEMAIN',   '設定');
define('TXT_CONFIGOPTION_PAGETITLESUB',    'オプション');

/*
 * config_option
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGOPTION_MSG_UPDATED',              'オプション設定を更新しました。');
define('TXT_CONFIGOPTION_LBL_TITLE_OTHERS',         'その他オプション');
define('TXT_CONFIGOPTION_LBL_USECOMMENTFLG',        'コメント');
define('TXT_CONFIGOPTION_LBL_USEVERSIONFLG',        'バージョン管理');
define('TXT_CONFIGOPTION_LBL_USEADVANCEDCACHEFLG',  'スマートキャッシュ・アドバンス');
define('TXT_CONFIGOPTION_LBL_TITLE_CONTACT',        'コンタクトオプション');
define('TXT_CONFIGOPTION_LBL_TITLE_USER',           'ユーザオプション');
define('TXT_CONFIGOPTION_LBL_USECONTACTFLG',        'コンタクト');
define('TXT_CONFIGOPTION_LBL_USEGROUPFLG',          'グループ');
define('TXT_CONFIGOPTION_LBL_TITLE_SITE',           'サイトオプション');
define('TXT_CONFIGOPTION_LBL_USEMULTISITEFLG',      'マルチサイト');
define('TXT_CONFIGOPTION_LBL_USEPOSTTYPEFLG',       'マルチポストタイプ');
define('TXT_CONFIGOPTION_LBL_USEMULTILINGUALFLG',   '多言語');
define('TXT_CONFIGOPTION_LBL_ADVANCEOPTION',        'アドバンスオプション');
define('TXT_CONFIGOPTION_LBL_BUSINESSOPTION',       'ビジネスオプション');
define('TXT_CONFIGOPTION_BTN_SUBMIT',               '更新');


/*
 * _category
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CATEGORY_PAGETITLE_CONTACT', 'コンタクト');
define('TXT_CATEGORY_PAGETITLESUB',      '編集');
define('TXT_CATEGORY_MSG_CREATED',       '新規作成が完了しました。');
define('TXT_CATEGORY_MSG_UPDATED',       '更新が完了しました。');
define('TXT_CATEGORY_MSG_DELETED',       '削除が完了しました。');
function TXT_CATEGORY_PAGETITLEMAIN($target){ return $text = "{$target}カテゴリ";}

/*
 * category
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CATEGORY_LBL_CATEGORY',      'カテゴリ');
define('TXT_CATEGORY_LBL_ALLOWDELETE',   '削除を許可');
define('TXT_CATEGORY_LBL_CANCELEDIT',    '編集をキャンセル');
define('TXT_CATEGORY_WAR_NOLABEL',       'ラベルが登録されていないカテゴリがあります。');
define('TXT_CATEGORY_LBL_NEW',           '新規');
define('TXT_CATEGORY_LBL_LABEL',         'ラベル');
define('TXT_CATEGORY_PLH_LABEL',         'ラベルを入力してください');
define('TXT_CATEGORY_LBL_SLUG',          'スラッグ');
define('TXT_CATEGORY_PLH_SLUG',          'スラッグを入力してください');
define('TXT_CATEGORY_LBL_PARENT',        '親カテゴリ');
define('TXT_CATEGORY_LBL_STATUS',        '状態');
define('TXT_CATEGORY_BTN_UPDATE',        '送信');
define('TXT_CATEGORY_BTN_DELETE',        '削除');
define('TXT_CATEGORY_LBL_LIST',          '一覧');
define('TXT_CATEGORY_THD_ID',            'ID');
define('TXT_CATEGORY_THD_HIERARCHY',     '階層');
define('TXT_CATEGORY_THD_LABEL',         'ラベル');
define('TXT_CATEGORY_THD_SLUG',          'スラッグ');
define('TXT_CATEGORY_THD_PARENT',        '親カテゴリ');
define('TXT_CATEGORY_THD_STATUS',        '状態');
define('TXT_CATEGORY_LBL_DISPLAY',       '表示');
define('TXT_CATEGORY_LBL_UNDISPLAY',     '非表示');
define('TXT_CATEGORY_LBL_EDIT',          '編集');
function TXT_CATEGORY_LBL_NOWEDIT($target){ return $text = "ID {$target} を編集中";}


/*
 * _tag
 * ------------------------------------------------------------------------------------------------ */
define('TXT_TAG_PAGETITLESUB',    '編集');
define('TXT_TAG_MSG_CREATED',     '新規作成が完了しました。');
define('TXT_TAG_MSG_UPDATED',     '更新が完了しました。');
define('TXT_TAG_MSG_DELETED',     '削除が完了しました。');
function TXT_TAG_PAGETITLEMAIN($target){ return $text = "{$target}タグ";}

/*
 * tag
 * ------------------------------------------------------------------------------------------------ */
define('TXT_TAG_WAR_NOLABEL',     'ラベルが登録されていないタグがあります。');
define('TXT_TAG_LBL_TAG',         'タグ');
define('TXT_TAG_LBL_ALLOWDELETE', '削除を許可');
define('TXT_TAG_LBL_CANCELEDIT',  '編集をキャンセル');
define('TXT_TAG_LBL_NEW',         '新規');
define('TXT_TAG_LBL_LABEL',       'ラベル');
define('TXT_TAG_PLH_NAME',        '表示名を入力してください');
define('TXT_TAG_LBL_SLUG',        'スラッグ');
define('TXT_TAG_PLH_SLUG',        'スラッグを入力してください');
define('TXT_TAG_LBL_STATUS',      '状態');
define('TXT_TAG_BTN_UPDATE',      '送信');
define('TXT_TAG_BTN_DELETE',      '削除');
define('TXT_TAG_LBL_LIST',        '一覧');
define('TXT_TAG_THD_ID',          'ID');
define('TXT_TAG_THD_LABEL',       'ラベル');
define('TXT_TAG_THD_SLUG',        'スラッグ');
define('TXT_TAG_THD_STATUS',      '状態');
define('TXT_TAG_LBL_DISPLAY',     '表示');
define('TXT_TAG_LBL_UNDISPLAY',   '非表示');
define('TXT_TAG_LBL_EDIT',        '編集');
function TXT_TAG_LBL_NOWEDIT($target){ return $text = "ID {$target} を編集中";}


/*
 * _config_posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGPOSTTYPE_PAGETITLE_CONTACT', 'カスタム設定');
function TXT_CONFIGPOSTTYPE_PAGETITLEMAIN($target){ return $text = "{$target} カスタム設定";}

/*
 * config_posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGPOSTTYPE_LBL_XXX',         '');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEBASE',            '基本');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEPERMALINK',       'パーマリンク');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEOPTION',          '追加機能');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEPOSTDETAIL',      'ポスト 詳細表示');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEPOSTLIST',        'ポスト 一覧表示');
define('TXT_CONFIGPOSTTYPE_LBL_TITLECOMMENTLIST',     'コメント 一覧表示');
define('TXT_CONFIGPOSTTYPE_LBL_MENUICON',             'メニューアイコン');
define('TXT_CONFIGPOSTTYPE_LBL_ICONSEEMORE',          'もっと見る');
define('TXT_CONFIGPOSTTYPE_LBL_POSTAUTOSAVEFLG',      'オートセーブ');
define('TXT_CONFIGPOSTTYPE_LBL_USEWISIWYGFLG',        'WISIWYG エディタ');
define('TXT_CONFIGPOSTTYPE_LBL_USECUSTOMITEMFLG',     'カスタムアイテム');
define('TXT_CONFIGPOSTTYPE_LBL_USEMULTIPAGEFLG',      'マルチページ');
define('TXT_CONFIGPOSTTYPE_LBL_COMMNETTYPE',          'コメントタイプ');
define('TXT_CONFIGPOSTTYPE_LBL_USEPUBLISHENDATFLG',   '公開終了日時');
define('TXT_CONFIGPOSTTYPE_LBL_USEADDITIONFLG',       'ディスクリプション');
define('TXT_CONFIGPOSTTYPE_LBL_USECONTENTFLG',        '本文');
define('TXT_CONFIGPOSTTYPE_LBL_USESLUGFLG',           'スラッグ');
define('TXT_CONFIGPOSTTYPE_LBL_USECATEGORYFLG',       'カテゴリー');
define('TXT_CONFIGPOSTTYPE_LBL_USETAGFLG',            'タグ');
define('TXT_CONFIGPOSTTYPE_LBL_EYECATCHFRAME',        'アイキャッチ画像');
define('TXT_CONFIGPOSTTYPE_LBL_PREVIEWURL',           'プレビューURL');
define('TXT_CONFIGPOSTTYPE_LBL_PARAMETERKEY',         'パラメータキー');
define('TXT_CONFIGPOSTTYPE_LBL_PERMALINKSTYLE',       'パーマリンクスタイル');
define('TXT_CONFIGPOSTTYPE_LBL_PERMALINKKEY',         'パーマリンクキー');
define('TXT_CONFIGPOSTTYPE_LBL_RESOURCE_URL',         'もとのURL');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITE_URL',          '書き換え後のURL');
define('TXT_CONFIGPOSTTYPE_LBL_PERMALINK_SAMPLE',     'パーマリンクサンプル');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITEOPERATORFLG',   'サイト全体で拡張子なしURLでアクセスするルールを追加');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITEOPERATOR',      'URLから除去するファイル拡張子');
define('TXT_CONFIGPOSTTYPE_LBL_REWRITE_RULE',         'リライトルール');
define('TXT_CONFIGPOSTTYPE_LBL_LABELTITLE',           'タイトルラベル');
define('TXT_CONFIGPOSTTYPE_LBL_LABELADDITION',        'ディスクリプションラベル');
define('TXT_CONFIGPOSTTYPE_LBL_LABELCONTENT',         '本文ラベル');
define('TXT_CONFIGPOSTTYPE_LBL_CUSTOMITEMPOSITION',   'カスタムアイテム表示位置');
define('TXT_CONFIGPOSTTYPE_LBL_LISTNUM',              '一覧表示件数');
define('TXT_CONFIGPOSTTYPE_LBL_SORTORDER',            'ソート順');
define('TXT_CONFIGPOSTTYPE_LBL_USELISTEYECATCHFLG',   'アイキャッチ');
define('TXT_CONFIGPOSTTYPE_LBL_POSTSCOLUMN03',        'ユーザ初期表示');
define('TXT_CONFIGPOSTTYPE_LBL_TITLELENGTH',          'タイトル表示文字長');
define('TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMCATEGORY',   'カテゴリ表示件数');
define('TXT_CONFIGPOSTTYPE_LBL_DISPLAYNUMTAG',        'タグ表示件数');
define('TXT_CONFIGPOSTTYPE_LBL_CONTACTSCOLUMN04',     'カラム４初期表示');;
define('TXT_CONFIGPOSTTYPE_LBL_REVIEWMAXSCORE',       'レビュー最大スコア');
define('TXT_CONFIGPOSTTYPE_LBL_UNLIMITED',            '制限なし');
define('TXT_CONFIGPOSTTYPE_LBL_TITLEDATAIMPORT',      'データインポート');
define('TXT_CONFIGPOSTTYPE_LBL_DATATYPE',             'インポートするデータの種類');
define('TXT_CONFIGPOSTTYPE_LBL_FILETYPE',             'ファイルの種類');
define('TXT_CONFIGPOSTTYPE_LBL_DATAFILE',             'データファイル');
define('TXT_CONFIGPOSTTYPE_LBL_DELIMITER',            '区切り文字（CSVの場合）');
define('TXT_CONFIGPOSTTYPE_LBL_CUSTOMLISTS',          'カスタムリスト');
define('TXT_CONFIGPOSTTYPE_LBL_KEYCOLUMN',            'キーとして利用するフィールド');
define('TXT_CONFIGPOSTTYPE_BTN_SUBMIT',               '更新');
define('TXT_CONFIGPOSTTYPE_BTN_UPLOAD',               'アップロード');


/*
 * config_posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CONFIGCONTACT_LBL_ADMINAUTOREPLYSETTING',    '管理者 自動返信メール設定');
define('TXT_CONFIGCONTACT_LBL_USEAUTOREPLYADMIN',        '管理者自動返信メール');
define('TXT_CONFIGCONTACT_LBL_ADMINLANGUAGE',            'フォーム言語');
define('TXT_CONFIGCONTACT_LBL_ADMINTO',                  '送信先メールアドレス（to）');
define('TXT_CONFIGCONTACT_LBL_ADMINFROM',                '送信元メールアドレス（from）');
define('TXT_CONFIGCONTACT_LBL_ADMINFROMNAME',            '送信元名（form name）');
define('TXT_CONFIGCONTACT_LBL_ADMINSUBJECT',             'タイトル（subject）');
define('TXT_CONFIGCONTACT_LBL_ADMINBODYHEAD',            '本文ヘッダー');
define('TXT_CONFIGCONTACT_LBL_ADMINBODYMAIN',            '本文メイン');
define('TXT_CONFIGCONTACT_LBL_USEINPUTVALUESADMIN',      'フォーム入力値');
define('TXT_CONFIGCONTACT_LBL_ADMINBODYBOTTOM',          '本文フッター');
define('TXT_CONFIGCONTACT_LBL_ADMINSIGNATURE',           '署名');

define('TXT_CONFIGCONTACT_LBL_CUSTOMERAUTOREPLYSETTING',   'カスタマー 自動返信メール設定');
define('TXT_CONFIGCONTACT_LBL_USEAUTOREPLYCUSTOMER',       'カスタマー自動返信メール');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERLANGUAGE',           'フォーム言語');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERFROM',               '送信元メールアドレス（from）');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERFROMNAME',           '送信元名（from name）');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERSUBJECT',            'タイトル（subject）');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERBODYHEAD',           '本文ヘッダー');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERBODYMAIN',           '本文メイン');
define('TXT_CONFIGCONTACT_LBL_USEINPUTVALUESCUSTOMER',     'フォーム入力値');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERBODYBOTTOM',         '本文フッター');
define('TXT_CONFIGCONTACT_LBL_CUSTOMERSIGNATURE',          '署名');

define('TXT_CONFIGCONTACT_LBL_SMTP',                'SMTPサーバの設定');
define('TXT_CONFIGCONTACT_LBL_USE_SMTP',            'SMTPサーバを指定して利用');
define('TXT_CONFIGCONTACT_LBL_HOST',                'SMTPサーバ');
define('TXT_CONFIGCONTACT_LBL_USER_NAME',           'SMTPサーバのユーザ名');
define('TXT_CONFIGCONTACT_LBL_PASSWORD',            'SMTPサーバのパスワード');
define('TXT_CONFIGCONTACT_LBL_PORT',                '通信ポート');

define('TXT_CONFIGCONTACT_LBL_TITLEOPTION',          '追加機能');
define('TXT_CONFIGCONTACT_LBL_TITLELIST',            '一覧表示');
define('TXT_CONFIGCONTACT_LBL_USECUSTOMITEMFLG',     'カスタムアイテム');
define('TXT_CONFIGCONTACT_LBL_ADMINEMAIL',           '管理者メールアドレス');
define('TXT_CONFIGCONTACT_LBL_LISTNUM',              '一覧表示件数');
define('TXT_CONFIGCONTACT_LBL_SORTORDER',            'ソート順');
define('TXT_CONFIGCONTACT_LBL_POSTSCOLUMN01',        'カラム１初期表示');
define('TXT_CONFIGCONTACT_LBL_POSTSCOLUMN03',        'カラム３初期表示');
define('TXT_CONFIGCONTACT_LBL_COLUMN01LENGTH',       'カラム１表示文字長');
define('TXT_CONFIGCONTACT_LBL_DISPLAYNUMCATEGORY',   'カテゴリ表示件数');
define('TXT_CONFIGCONTACT_LBL_DISPLAYNUMTAG',        'タグ表示件数');
define('TXT_CONFIGCONTACT_BTN_SUBMIT',               '更新');


/*
 * _site
 * ------------------------------------------------------------------------------------------------ */
define('TXT_SITE_PAGETITLEMAIN',      'サイト');
define('TXT_SITE_PAGETITLESUB',       '編集');
define('TXT_SITE_MSG_CREATED',        '新規作成が完了しました。');
define('TXT_SITE_MSG_FOR_USER',       '新規追加したサイトには「システム管理者」「サイト管理者」権限のユーザのみがアクセスできます。「エディター」「ライター」権限のユーザにはメニュー [ユーザ] - [編集] から個別にアクセス許可設定を行なってください。');
define('TXT_SITE_MSG_FOR_POSTTYPE',   '新規追加したサイトにはポストタイプが関連付けられていません。[サイトオプション] - [マルチポストタイプ] の「対応サイト」で関連付けを行ってください。');
define('TXT_SITE_MSG_UPDATED',        '更新が完了しました。');
define('TXT_SITE_MSG_DELETED',        '削除が完了しました。');

/*
 * site
 * ------------------------------------------------------------------------------------------------ */
function TXT_SITE_LBL_NOWEDIT($target){ return $text = "{$target} を編集中";}
define('TXT_SITE_LBL_MULTISITE',      'マルチサイト');
define('TXT_SITE_LBL_DISALLOWDELETE', 'ID:1 は削除できません');
define('TXT_SITE_LBL_ALLOWDELETE',    '削除を許可');
define('TXT_SITE_LBL_CANCELEDIT',     '編集をキャンセル');
define('TXT_SITE_LBL_NEW',            '新規');
define('TXT_SITE_LBL_NAME',           '表示名');
define('TXT_SITE_PLH_NAME',           'サンプルサイト');
define('TXT_SITE_LBL_SLUG',           'スラッグ');
define('TXT_SITE_PLH_SLUG',           'sample_site');
define('TXT_SITE_LBL_STATUS',         '状態');
define('TXT_SITE_BTN_UPDATE',         '送信');
define('TXT_SITE_BTN_DELETE',         '削除');
define('TXT_SITE_LBL_LISTSITE',       'サイト一覧');
define('TXT_SITE_THD_ID',             'ID');
define('TXT_SITE_THD_NAME',           '表示名');
define('TXT_SITE_THD_SLUG',           'スラッグ');
define('TXT_SITE_THD_STATUS',         '状態');
define('TXT_SITE_LBL_DISPLAY',        '表示');
define('TXT_SITE_LBL_UNDISPLAY',      '非表示');
define('TXT_SITE_LBL_EDIT',           '編集');


/*
 * _group
 * ------------------------------------------------------------------------------------------------ */
define('TXT_GROUP_PAGETITLEMAIN',      'グループ');
define('TXT_GROUP_PAGETITLESUB',       '編集');
define('TXT_GROUP_MSG_CREATED',        '新規作成が完了しました。');
define('TXT_GROUP_MSG_UPDATED',        '更新が完了しました。');
define('TXT_GROUP_MSG_DELETED',        '削除が完了しました。');

/*
 * group
 * ------------------------------------------------------------------------------------------------ */
function TXT_GROUP_LBL_NOWEDIT($target){ return $text = "{$target} を編集中";}
define('TXT_GROUP_LBL_MULTIGROUP',     'グループ');
define('TXT_GROUP_LBL_DISALLOWDELETE', 'ID:1 は削除できません');
define('TXT_GROUP_LBL_ALLOWDELETE',    '削除を許可');
define('TXT_GROUP_LBL_CANCELEDIT',     '編集をキャンセル');
define('TXT_GROUP_LBL_NEW',            '新規');
define('TXT_GROUP_LBL_NAME',           '表示名');
define('TXT_GROUP_PLH_NAME',           '表示名を入力してください');
define('TXT_GROUP_LBL_SLUG',           'スラッグ');
define('TXT_GROUP_PLH_SLUG',           'スラッグを入力してください');
define('TXT_GROUP_LBL_STATUS',         '状態');
define('TXT_GROUP_BTN_UPDATE',         '送信');
define('TXT_GROUP_BTN_DELETE',         '削除');
define('TXT_GROUP_LBL_LIST',           '一覧');
define('TXT_GROUP_THD_ID',             'ID');
define('TXT_GROUP_THD_NAME',           '表示名');
define('TXT_GROUP_THD_SLUG',           'スラッグ');
define('TXT_GROUP_THD_STATUS',         '状態');
define('TXT_GROUP_LBL_DISPLAY',        '表示');
define('TXT_GROUP_LBL_UNDISPLAY',      '非表示');
define('TXT_GROUP_LBL_EDIT',           '編集');


/*
 * _posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTTYPE_PAGETITLEMAIN',    'マルチポストタイプ');
define('TXT_POSTTYPE_PAGETITLESUB',     '編集');
define('TXT_POSTTYPE_MSG_FOR_USER',     '新規追加したポストタイプには「システム管理者」「サイト管理者」権限のユーザのみがアクセスできます。「エディター」「ライター」権限のユーザにはメニュー [ユーザ] - [編集] から個別にアクセス許可設定を行なってください。');
define('TXT_POSTTYPE_MSG_CREATED',      '新規作成が完了しました。');
define('TXT_POSTTYPE_MSG_UPDATED',      '更新が完了しました。');
define('TXT_POSTTYPE_MSG_DELETED',      '削除が完了しました。');

/*
 * posttype
 * ------------------------------------------------------------------------------------------------ */
define('TXT_POSTTYPE_LBL_MULTIPOST',             'マルチポストタイプ');
define('TXT_POSTTYPE_LBL_DISALLOWDELETEPOST',    '既定の投稿は削除できません。');
define('TXT_POSTTYPE_LBL_DISALLOWDELETECONTACT', '既定のコンタクトは削除できません。');
define('TXT_POSTTYPE_LBL_ALLOWDELETE',           '削除を許可');
define('TXT_POSTTYPE_LBL_CANCELEDIT',            '編集をキャンセル');
define('TXT_POSTTYPE_LBL_NEW',                   '新規');
define('TXT_POSTTYPE_LBL_POST',                  'ポストタイプ');
define('TXT_POSTTYPE_LBL_CONTACT',               'コンタクト');
define('TXT_POSTTYPE_MSG_CREATION_LIMIT',        'すでに作成上限です。');
define('TXT_POSTTYPE_LBL_NAME',                  '表示名');
define('TXT_POSTTYPE_PLH_NAME',                  '新着情報');
define('TXT_POSTTYPE_LBL_TYPE',                  'タイプ');
define('TXT_POSTTYPE_LBL_SLUG',                  'スラッグ');
define('TXT_POSTTYPE_PLH_SLUG',                  'news');
define('TXT_POSTTYPE_LBL_WISIWYGFLG',            'WISIWYGエディタ');
define('TXT_POSTTYPE_LBL_COMMENTTYPE',           'コメントタイプ');
define('TXT_POSTTYPE_LBL_SITEID',                '対応サイト');
define('TXT_POSTTYPE_LBL_LANGUAGEID',            '使用言語');
define('TXT_POSTTYPE_LBL_LANGUAGEDEFAULT',       '(既定)');
define('TXT_POSTTYPE_LBL_STATUS',                '状態');
define('TXT_POSTTYPE_BTN_UPDATE',                '送信');
define('TXT_POSTTYPE_BTN_DELETE',                '削除');
define('TXT_POSTTYPE_LBL_LISTPOST',              'ポストタイプ一覧');
define('TXT_POSTTYPE_LBL_LISTCONTACT',           'コンタクト一覧');
define('TXT_POSTTYPE_THD_ID',                    'ID');
define('TXT_POSTTYPE_THD_NAME',                  '表示名');
define('TXT_POSTTYPE_THD_SLUG',                  'スラッグ');
define('TXT_POSTTYPE_THD_COMMENTTYPE',           'コメント');
define('TXT_POSTTYPE_THD_SITEID',                '対応サイト');
define('TXT_POSTTYPE_THD_LANGUAGEID',            '使用言語');
define('TXT_POSTTYPE_THD_STATUS',                '状態');
define('TXT_POSTTYPE_LBL_DISPLAY',               '表示');
define('TXT_POSTTYPE_LBL_UNDISPLAY',             '非表示');
define('TXT_POSTTYPE_LBL_EDIT',                  '編集');
function TXT_POSTTYPE_LBL_NOWEDIT($target)       { return $text = "{$target} を編集中";}
function TXT_POSTTYPE_MSG_CREATION_LEFT($left)   { return $text = "あと{$left}つ作成可能";}


/*
 * _language
 * ------------------------------------------------------------------------------------------------ */
define('TXT_LANGUAGE_PAGETITLEMAIN',      '言語');
define('TXT_LANGUAGE_PAGETITLESUB',       '編集');
define('TXT_LANGUAGE_MSG_CREATED',        '新規作成が完了しました。');
define('TXT_LANGUAGE_MSG_FOR_POSTTYPE',   '新規作成した言語を使用するには メニュー [サイトオプション] - [マルチポストタイプ] から設定を行ってください。');
define('TXT_LANGUAGE_MSG_UPDATED',        '更新が完了しました。');
define('TXT_LANGUAGE_MSG_DELETED',        '削除が完了しました。');

/*
 * language
 * ------------------------------------------------------------------------------------------------ */
function TXT_LANGUAGE_LBL_NOWEDIT($target){ return $text = "{$target} を編集中";}
define('TXT_LANGUAGE_LBL_MULTILANGUAGE',  '多言語');
define('TXT_LANGUAGE_LBL_DISALLOWDELETE', 'ID:1 は削除できません');
define('TXT_LANGUAGE_LBL_ALLOWDELETE',    '削除を許可');
define('TXT_LANGUAGE_LBL_CANCELEDIT',     '編集をキャンセル');
define('TXT_LANGUAGE_LBL_NEW',            '新規');
define('TXT_LANGUAGE_LBL_NAME',           '表示名');
define('TXT_LANGUAGE_PLH_NAME',           '英語');
define('TXT_LANGUAGE_LBL_SLUG',           'スラッグ');
define('TXT_LANGUAGE_PLH_SLUG',           'english');
define('TXT_LANGUAGE_LBL_STATUS',         '状態');
define('TXT_LANGUAGE_BTN_UPDATE',         '送信');
define('TXT_LANGUAGE_BTN_DELETE',         '削除');
define('TXT_LANGUAGE_LBL_LISTLANGUAGE',   '言語一覧');
define('TXT_LANGUAGE_THD_ID',             'ID');
define('TXT_LANGUAGE_THD_NAME',           '表示名');
define('TXT_LANGUAGE_THD_SLUG',           'スラッグ');
define('TXT_LANGUAGE_THD_STATUS',         '状態');
define('TXT_LANGUAGE_LBL_DISPLAY',        '表示');
define('TXT_LANGUAGE_LBL_UNDISPLAY',      '非表示');
define('TXT_LANGUAGE_LBL_EDIT',           '編集');


/*
 * cover
 * ------------------------------------------------------------------------------------------------ */
define('TXT_COVER_LBL_TOCOVER',     'カバーイメージ');
define('TXT_COVER_LBL_SETFRAME',    'フレーム設定');
define('TXT_COVER_LNK_BACKTOTEXT',  'テキスト');


/*
 * _custom_item
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMITEM_PAGETITLE_CONTACT',  'コンタクト');
define('TXT_CUSTOMITEM_PAGETITLESUB',       '編集');
define('TXT_CUSTOMITEM_MSG_CREATED',        '新規追加が完了しました。');
define('TXT_CUSTOMITEM_MSG_UPDATED',        '更新が完了しました。');
define('TXT_CUSTOMITEM_MSG_DELETED',        '削除が完了しました。');
function TXT_CUSTOMITEM_PAGETITLEMAIN($target){ return $text = "{$target} カスタムアイテム";}

/*
 * custom_item
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMITEM_LBL_EDITCUSTOMLIST',  'カスタムリストを編集する');
define('TXT_CUSTOMITEM_LBL_CUSTOMITEM',      'カスタムアイテム');
define('TXT_CUSTOMITEM_LBL_ALLOWDELETE',     '削除を許可');
define('TXT_CUSTOMITEM_LBL_CANCELEDIT',      '編集をキャンセル');
define('TXT_CUSTOMITEM_LBL_NEW',             '新規');
define('TXT_CUSTOMITEM_LBL_NAME',            '項目名');
define('TXT_CUSTOMITEM_PLH_NAME',            '表示名を入力してください');
define('TXT_CUSTOMITEM_LBL_SLUG',            'スラッグ');
define('TXT_CUSTOMITEM_PLH_SLUG',            'スラッグを入力してください');
define('TXT_CUSTOMITEM_LBL_TYPE',            'タイプ');
define('TXT_CUSTOMITEM_LBL_TARGETLIST',      'カスタムリスト選択');
define('TXT_CUSTOMITEM_MSG_NOTARGETLIST',    '選択できるカスタムリストがありません');
define('TXT_CUSTOMITEM_LBL_TARGETDELIMITER', 'カラム区切り文字選択');
define('TXT_CUSTOMITEM_LBL_TARGETIMAGE',     '画像選択');
define('TXT_CUSTOMITEM_LBL_TARGETPOSTTYPE',  'ポストタイプ選択');
define('TXT_CUSTOMITEM_LBL_TARGETSYNTAX',    'シンタックスタイプ選択');
define('TXT_CUSTOMITEM_LBL_STATUS',          '状態');
define('TXT_CUSTOMITEM_BTN_UPDATE',          '送信');
define('TXT_CUSTOMITEM_BTN_DELETE',          '削除');
define('TXT_CUSTOMITEM_LBL_LIST',            '一覧');
define('TXT_CUSTOMITEM_THD_ID',              'ID');
define('TXT_CUSTOMITEM_THD_NAME',            '項目名');
define('TXT_CUSTOMITEM_THD_SLUG',            'スラッグ');
define('TXT_CUSTOMITEM_THD_TYPE',            'タイプ');
define('TXT_CUSTOMITEM_THD_TARGET',          '選択肢');
define('TXT_CUSTOMITEM_THD_STATUS',          '状態');
define('TXT_CUSTOMITEM_LBL_DISPLAY',         '表示');
define('TXT_CUSTOMITEM_LBL_UNDISPLAY',       '非表示');
define('TXT_CUSTOMITEM_LBL_EDIT',            '編集');
function TXT_CUSTOMITEM_LBL_NOWEDIT($target){ return $text = "ID {$target} を編集中";}


/*
 * _custom_list
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMLIST_PAGETITLEMAIN',      'カスタムリスト');
define('TXT_CUSTOMLIST_PAGETITLESUB',       '編集');
define('TXT_CUSTOMLIST_MSG_CREATED',        '新規追加が完了しました。');
define('TXT_CUSTOMLIST_MSG_UPDATED',        '更新が完了しました。');
define('TXT_CUSTOMLIST_MSG_DELETED',        '削除が完了しました。');
define('TXT_CUSTOMLIST_LBL_MULTIUSE',       '共用'); // also use in custom_list

/*
 * custom_list
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMLIST_LNK_CUSTOMITEM',     'カスタムアイテム');
define('TXT_CUSTOMLIST_LBL_CUSTOMLIST',     'カスタムリスト');
define('TXT_CUSTOMLIST_LBL_ALLOWDELETE',    '削除を許可');
define('TXT_CUSTOMLIST_LBL_CANCELEDIT',     '編集をキャンセル');
define('TXT_CUSTOMLIST_LBL_NEW',            '新規');
define('TXT_CUSTOMLIST_LBL_NAME',           'リスト名');
define('TXT_CUSTOMLIST_PLH_NAME',           'リスト名を入力してください');
define('TXT_CUSTOMLIST_LBL_SLUG',           'スラッグ');
define('TXT_CUSTOMLIST_PLH_SLUG',           'スラッグを入力してください');
define('TXT_CUSTOMLIST_LBL_BELONGTO',       '所属');
define('TXT_CUSTOMLIST_LBL_STATUS',         '状態');
define('TXT_CUSTOMLIST_BTN_UPDATE',         '送信');
define('TXT_CUSTOMLIST_BTN_DELETE',         '削除');
define('TXT_CUSTOMLIST_LBL_LIST',           '一覧');
define('TXT_CUSTOMLIST_THD_ID',             'ID');
define('TXT_CUSTOMLIST_THD_NAME',           '表示名');
define('TXT_CUSTOMLIST_THD_SLUG',           'スラッグ');
define('TXT_CUSTOMLIST_THD_BELONGTO',       '所属');
define('TXT_CUSTOMLIST_THD_STATUS',         '状態');
define('TXT_CUSTOMLIST_LNK_CUSTOMVALUE',    'リストの値を編集する');
define('TXT_CUSTOMLIST_LBL_DISPLAY',        '表示');
define('TXT_CUSTOMLIST_LBL_UNDISPLAY',      '非表示');
define('TXT_CUSTOMLIST_LBL_EDIT',           '編集');
function TXT_CUSTOMLIST_LBL_NOWEDIT($target){ return $text = "ID {$target} を編集中";}


/*
 * _custom_value
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMVALUE_PAGETITLEMAIN',      'カスタムバリュー');
define('TXT_CUSTOMVALUE_PAGETITLESUB',       '編集');
define('TXT_CUSTOMVALUE_MSG_CREATED',        '新規追加が完了しました。');
define('TXT_CUSTOMVALUE_MSG_UPDATED',        '更新が完了しました。');
define('TXT_CUSTOMVALUE_MSG_DELETED',        '削除が完了しました。');

/*
 * custom_value
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CUSTOMVALUE_LNK_CUSTOMLIST',     'カスタムリスト');
define('TXT_CUSTOMVALUE_WAR_NOLABEL',        'ラベルが登録されていないカスタムバリューがあります。ラベルが登録されていないと入力時に選択できません。');
define('TXT_CUSTOMVALUE_LBL_CUSTOMVALUE',    'カスタムバリュー');
define('TXT_CUSTOMVALUE_LBL_ALLOWDELETE',    '削除を許可');
define('TXT_CUSTOMVALUE_LBL_CANCELEDIT',     '編集をキャンセル');
define('TXT_CUSTOMVALUE_LBL_NEW',            '新規');
define('TXT_CUSTOMVALUE_LBL_VALUE',          '値');
define('TXT_CUSTOMVALUE_PLH_VALUE',          '値を入力してください');
define('TXT_CUSTOMVALUE_LBL_STATUS',         '状態');
define('TXT_CUSTOMVALUE_BTN_UPDATE',         '送信');
define('TXT_CUSTOMVALUE_BTN_DELETE',         '削除');
define('TXT_CUSTOMVALUE_LBL_LIST',           '一覧');
define('TXT_CUSTOMVALUE_THD_ID',             'ID');
define('TXT_CUSTOMVALUE_THD_VALUE',          '値');
define('TXT_CUSTOMVALUE_THD_STATUS',         '状態');
define('TXT_CUSTOMVALUE_LBL_DISPLAY',        '表示');
define('TXT_CUSTOMVALUE_LBL_UNDISPLAY',      '非表示');
define('TXT_CUSTOMVALUE_LBL_EDIT',           '編集');
function TXT_CUSTOMVALUE_LBL_NOWEDIT($target) { return $text = "{$target} を編集中";}


/*
 * code
 * ------------------------------------------------------------------------------------------------ */
define('TXT_CODE_LNK_CHANGE_LANGUAGE',               '実装コード表示の設定を変更する');
define('TXT_CODE_COM_IMPLEMENT_REMOTEPHP01',         'エンドポイント（POSTEASE APIのURL）をセット');
define('TXT_CODE_COM_IMPLEMENT_GETPOSTKEY',          'post_key を取得');
define('TXT_CODE_COM_IMPLEMENT_REMOTEPHP02',         'POSTEASE API からデータを取得するためのSDK（クライアントツール）を読み込み');
define('TXT_CODE_COM_IMPLEMENT_JQUERY',              '共通コードは不要です。');
define('TXT_CODE_COM_IMPLEMENT_JQUERYATTENTION',     'リモートサーバから接続する場合は以下のディレクトリにCORS開放を記述した .htaccess を設置してください。');

define('TXT_CODE_COM_IMPLEMENT_POSTSCONFIG',         'ポスト一覧の取得条件を設定');
define('TXT_CODE_COM_IMPLEMENT_GETPOSTS',            'ポスト一覧を取得');
define('TXT_CODE_COM_IMPLEMENT_POSTCONFIG',          'ポストの取得条件を設定（スラッグ利用の場合）');
define('TXT_CODE_COM_IMPLEMENT_POSTCONFIGBYPOSTKEY', 'ポストを取得');
define('TXT_CODE_COM_IMPLEMENT_RENDERPOSTS',         'ポストデータをHTMLに書き出し');

define('TXT_CODE_COM_IMPLEMENT_CATEGORIESCONFIG',  'カテゴリーデータの取得条件を設定');
define('TXT_CODE_COM_IMPLEMENT_GETCATEGORIES',     'カテゴリーデータを取得');
define('TXT_CODE_COM_IMPLEMENT_TAGSCONFIG',        'タグデータの取得条件を設定');
define('TXT_CODE_COM_IMPLEMENT_GETTAGS',           'タグデータを取得');
define('TXT_CODE_COM_IMPLEMENT_CATEGORYTITLE',     'カテゴリ一覧');
define('TXT_CODE_COM_IMPLEMENT_TAGTITLE',          'タグ一覧');


/*
 * error
 * ------------------------------------------------------------------------------------------------ */
function TXT_ERROR_MSG_ERROROCCURED($page, $read_error) { return $text = "{$page} ページで [{$read_error}] の読込エラーが発生しました。";}
