<?php
####################################################################
#
# ◇◇◇◇◇◇◇◇◇◇◇ JPHPMailer - PHPMailer Japanese Edition
# ◇■■■■◇■■■■◇ (PHPMailer:http://phpmailer.sourceforge.net/)
# ◇■◇◇◇◇■◇◇◇◇ 
# ◇■■■■◇■◇◇◇◇ 
# ◇■◇◇◇◇■◇◇◇◇ 株式会社 EC studio  Masaki Yamamoto
# ◇■■■■◇■■■■◇ http://www.ecstudio.jp
# ◇◇◇◇◇◇◇◇◇◇◇ copyright (c): 2007,all rights reserved
#
####################################################################

//PHPMailerを読み込む
require("./phpmailer/class.phpmailer.php");

/**
 * JPHPMailer - PHPMailer Japanese Edition
 *
 * @author    Masaki Yamamoto
 * @version   0.11
 * @copyright 2007 EC studio
 * @license   LGPL
 * @link http://techblog.ecstudio.jp/tech-tips/mail-japanese-advance.html
 */
class JPHPMailer extends PHPMailer {
	var $CharSet = "iso-2022-jp";
	var $Encoding = "7bit";
	var $in_enc = "EUC-JP"; //内部エンコード
	
	/**
	 * 宛先を追加
	 * 
	 * $name <$address> という書式になる。
	 * 
	 * @param string $address メールアドレス
	 * @param string $name 名前
	 */
	function addAddress($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addAddress($address,$name);
	}

	/**
	 * 宛先を追加 (addAddressのエイリアス)
	 * 
	 * $name <$address> という書式になる。
	 * 
	 * @param string $address メールアドレス
	 * @param string $name 名前
	 */
	function addTo($address,$name="") {
		$this->addAddress($address,$name);
	}

	/**
	 * CCを追加
	 * 
	 * $name <$address> という書式になる。
	 * 
	 * @param string $address メールアドレス
	 * @param string $name 名前
	 */
	function addCc($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addCc($address,$name);
	}

	/**
	 * BCCを追加
	 * 
	 * $name <$address> という書式になる。
	 * 
	 * @param string $address メールアドレス
	 * @param string $name 名前
	 */
	function addBcc($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addBcc($address,$name);
	}

	/**
	 * Reply-Toを追加
	 * 
	 * $name <$address> という書式になる。
	 * 
	 * @param string $address メールアドレス
	 * @param string $name 名前
	 */
	function addReplyTo($address,$name="") {
		if ($name){
			$name = $this->encodeMimeHeader(mb_convert_encoding($name,"JIS",$this->in_enc));
		}
		parent::addReplyTo($address,$name);
	}
	
	/**
	 * 題名をセットする
	 * 
	 * @param string $subject 題名
	 */
	function setSubject($subject){
		$this->Subject = $this->encodeMimeHeader(mb_convert_encoding($subject,"JIS",$this->in_enc));
	}
	
	/**
	 * 差出人アドレスをセットする
	 * 
	 * @param string $from 差出人のメールアドレス
	 * @param string $fromname 差し出し人名
	*/
	function setFrom($from,$fromname=""){
		$this->From = $from;
		if ($fromname){
			$this->setFromName($fromname);
		}
	}
	
	/**
	 * 差し出し人名をセットする
	 * @param string $fromname 差し出し人名
	 */
	function setFromName($fromname){
		$this->FromName = $this->encodeMimeHeader(mb_convert_encoding($fromname,"JIS",$this->in_enc));
	}

	/**
	 * 本文をセットする。(text/plain)
	 * 
	 * @param string $body 本文
	 */
	function setBody($body){
		$this->Body = mb_convert_encoding($body,"JIS",$this->in_enc);
		$this->AltBody = "";
		$this->IsHtml(false);
	}

	/**
	 * 本文をセットする。(text/html)
	 * 
	 * @param string $htmlbody 本文 (HTML)
	 */
	function setHtmlBody($htmlbody){
		$this->Body = mb_convert_encoding($htmlbody,"JIS",$this->in_enc);
		$this->IsHtml(true);
	}
	
	/**
	 * 代替え本文をセットする。(text/plain)
	 * setHtmlBody()を使った時、HTMLを読めないメールクライアント用の平文をセットできる。
	 * 
	 * @param string $altbody 本文
	 */
	function setAltBody($altbody){
		$this->AltBody = mb_convert_encoding($altbody,"JIS",$this->in_enc);
	}
	
	/**
	 * カスタムヘッダーを追加
	 * 
	 * @param string $key ヘッダーキー
	 * @param string $value ヘッダー値
	 */
	function addHeader($key,$value){
		if (!$value){
			return;
		}
		$this->addCustomHeader($key.":".$this->encodeMimeHeader(mb_convert_encoding($value,"JIS",$this->in_enc)));
	}
	
	/**
	 * エラーメッセージを取得する
	 * 
	 * @return string エラーメッセージ
	 */
	function getErrorMessage(){
		return $this->ErrorInfo;
	}
	
	/**
	 * PHPMailerのencodeHeaderをオーバーライドして無効化
	 */
	function encodeHeader($str, $position='text'){
		return $str;
	}
	
	/**
	 * Mimeエンコード処理
	 * 
	 * phpのmb_encode_mimeheaderでは、長い文字列で改行されずメールヘッダの規則にあわない。
	 */
	function encodeMimeHeader($string,$charset=null,$linefeed="\r\n"){
		if (!strlen($string)){
			return "";
		}
		
		if (!$charset)
			$charset = $this->CharSet;
	
		$start = "=?$charset?B?";
		$end = "?=";
		$encoded = '';
	
		/* Each line must have length <= 75, including $start and $end */
		$length = 75 - strlen($start) - strlen($end);
		/* Average multi-byte ratio */
		$ratio = mb_strlen($string, $charset) / strlen($string);
		/* Base64 has a 4:3 ratio */
		$magic = $avglength = floor(3 * $length * $ratio / 4);
	
		for ($i=0; $i <= mb_strlen($string, $charset); $i+=$magic) {
			$magic = $avglength;
			$offset = 0;
			/* Recalculate magic for each line to be 100% sure */
			do {
				$magic -= $offset;
				$chunk = mb_substr($string, $i, $magic, $charset);
				$chunk = base64_encode($chunk);
				$offset++;
			} while (strlen($chunk) > $length);
			
			if ($chunk)
				$encoded .= ' '.$start.$chunk.$end.$linefeed;
		}
		/* Chomp the first space and the last linefeed */
		$encoded = substr($encoded, 1, -strlen($linefeed));
	
		return $encoded;
	}
}