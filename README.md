# POSTEASE install type

:earth_americas: [POSTEASE install type](https://postease.in)

## 概要 / Outline
:jp: POSTEASE install type はAPI接続式の超軽量ヘッドレスCMSです。  

:us: 'POSTEASE install type' is an ultra-lightweight headless CMS with API connection.


## 特徴 / Features

### 1. レガシー環境で動作 / Works in a legacy environment
:jp: POSTEASE install type はレガシーなサーバ環境でも動作します。PHPバージョン5.1以上（最新版まで）で動作します。

:us: 'POSTEASE install type' also works in a legacy server environment. It works with PHP version 5.1 or higher (up to the latest version).

### 2. データベースサーバ不要 / No database server required
:jp: POSTEASE install type は、MySQL または SQLite で実行されます。

:us: 'POSTEASE install type' run with MySQL or SQLite.

### 3. API実装 / API implementation
:jp: APIによる実装のため、ローカル・リモート問わず、あらゆる環境、あらゆる言語で実装可能です。データはJSON形式で取得可能です。

:us: Implemented by API, can be implemented in any environment, any language, regardless of local or remote. Data can be retrieved in JSON format.


## サーバ要件 / Server requirements

- \>=PHP5.2
- SQLite3.x or MySQL5.x
- PHP FTP-extension (ftp.so)


## ダウンロード / Download

```sh
git clone git@github.com:postease-cms/postease.git
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
require_once dirname(__FILE__) . '/postease/api/v3/endpoint.php';

$endpoint = 'https://sample.com/postease/api/v3/endpoint.php';

$pe = new Pec($endpoint);

$posts = $pe -> get_posts();
```




## 最新バージョン / Latest version

**3.3.3 ( 02.Aug.2019 )**

---

#### Update History
- 3.3.3 ( 02.Aug.2019 )
- 3.3.2 ( 30.Jul.2019 )
- 3.3.1 ( 29.Jul.2019 )
- 3.3.0 ( 27.Jul.2019 )
- 3.2.10 ( 25.Jul.2019 )
- 3.2.9 ( 21.May.2019 )
- 3.2.8 ( 18.Apr.2019 )
- 3.2.7 ( 18.Apr.2019 )
- 3.2.6 ( 17.Apr.2019 )
- 3.2.5 ( 16.Apr.2019 )
- 3.2.4 ( 04.Apr.2019 )
- 3.2.3 ( 01.Apr.2019 )
- 3.2.2 ( 04.Mar.2019 )
- 3.2.1 ( 25.Jan.2019 )
- 3.2.0 ( 22.Jan.2019 )
- 3.1.3 ( 04.Jan.2019 )
- 3.1.2 ( 26.Dec.2018 )
- 3.1.1 ( 25.Dec.2018 )
- 3.1.0 ( 25.Dec.2018 )
- 3.0.3 ( 16.Dec.2018 )
- 3.0.2 ( 15.Dec.2018 )
- 3.0.1 ( 12.Dec.2018 )
- 3.0.0 ( 12.Dec.2018 )
- 2.9.2 ( 12.Dec.2018 )
- 2.9.1 ( 16.Nov.2018 )
- 2.9.0 ( 15.Nov.2018 )
- 2.8.16 ( 07.Nov.2018 )
- 2.8.15 ( 06.Nov.2018 )
- 2.8.14 ( 05.Nov.2018 )
- 2.8.13 ( 01.Nov.2018 )
- 2.8.12 ( 27.Oct.2018 )
- 2.8.11 ( 27.Oct.2018 )
- 2.8.10 ( 21.Oct.2018 )
- 2.8.9 ( 21.Oct.2018 )
- 2.8.8 ( 12.Aug.2018 )
- 2.8.7 ( 10.Aug.2018 )
- 2.8.6 ( 31.Jul.2018 )
- 2.8.5 ( 30.Jul.2018 )
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
