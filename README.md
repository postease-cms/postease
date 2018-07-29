# postease-classic

:earth_americas: [POSTEASE Classic](https://classic.postease.org)

## 概要 / Outline
:jp: POSTEASE Classic はAPI接続式の超軽量ヘッドレスCMSです。  

:us: 'POSTEASE Classic' is an ultra-lightweight headless CMS with API connection.


## 特徴 / Features

### 1. レガシー環境で動作 / Works in a legacy environment
:jp: POSTEASE Classic はレガシーなサーバ環境でも動作します。PHPバージョン5.1以上（最新版まで）で動作します。

:us: 'POSTEASE Classic' also works in a legacy server environment. It works with PHP version 5.1 or higher (up to the latest version).

### 2. データベースサーバ不要 / No database server required
:jp: POSTEASE Classic は、MySQL または SQLite で実行されます。

:us: 'POSTEASE Classic' run with MySQL or SQLite.

### 3. XML-RPCとJSONをサポート / Support for XML-RPC and JSON
:jp: POSTEASE Classic は XML-RPC もしくは json 形式でのデータ取得をサポートしています。PHP もしくは javascript ( jQuery ) で実装できます。

:us: 'POSTEASE Classic' supports data retrieval in XML-RPC or JSON format. Can be implemented in PHP or JavaScript (jQuery).


## サーバ要件 / Server requirements

- \>=PHP5.1
- SQLite3.x or MySQL5.x
- PHP FTP-extension (ftp.so)


## ダウンロード / Download

```sh
git clone git@github.com:postease-classic/postease.git
```


## 実装 / Implements

Constitute Example
```
/*
 * root
 *  |
 *  |-- postease
 *  |
 *  |-- index.php
 *
 */
```


index.php
```php
require_once dirname(__FILE__) . '/postease/api/local.php';

$posts = get_posts();
```



## お知らせ / Notice
:jp: POSTEASE は完全なREST-APIによるクラウドサービスに生まれ変わります。このインストール型のディストリビューションは POSTEASE Classic としてメンテナンスが続けられます。  

:us: 'POSTEASE' will be reborn as a cloud service by a complete REST-API. This installation type of distribution continues to be maintained as a 'POSTEASE Classic'.
  


## 最新バージョン / Latest version

**2.8.4 ( 29.Jul.2018 )**

---

#### Update History

- 2.8.4 ( 29.Jul.2018 )
- 2.8.3 ( 29.Jul.2018 )
- 2.8.2 ( 29.Jul.2018 )
- 2.8.1 ( 29.Jul.2018 )
- 2.8.0 ( 28.Jul.2018 )
- 2.7.4 ( 13.Jun.2018 )
- 2.7.3 ( 11.Jun.2018 )
- 2.7.2 ( 01.Jun.2018 ) 
- 2.7.1 ( 27.May.2018 )
- 2.7.0 ( 27.May.2018 )
- 2.6.1 ( 23.May.2018 )
- 2.6.0 ( 22.May.2018 )
- 2.5.1 ( 21.May.2018 )
- 2.5.0 ( 20.May.2018 )
- 2.4.7 ( 11.May.2018 )
- 2.4.6 ( 13.Apr.2018 )
- 2.4.5 ( 09.Feb.2018 )
- 2.4.4 ( 02.Aug.2017 )
- 2.4.3 ( 21.Jul.2017 )
- 2.4.2 ( 01.Jul.2017 )
- 2.4.1 ( 21.Jun.2017 )
- 2.4.0 ( 21.Jun.2017 )
- 2.3.2 ( 23.May.2017 )
- 2.3.1 ( 20.May.2017 )
- 2.3.0 ( 20.May.2017 )
- 2.2.0 ( 04.May.2017, as production )
- 2.1.x ( 03.Nov.2015 )
- 2.0.x ( 02.Nov.2015, as beta )
