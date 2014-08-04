<?php

/**
 * Define class to manage language
 *
 * @author Jiazhen Wang
 */
class WLanguage {

	private $_langFileDir = '/languages';
	private $_lang = 'fr';
	private $_langData = null;

	const DEF_LANG = 'fr';

	public function __construct() {
		$this->_langFileDir = dirname(__FILE__) . $this->_langFileDir;
		$this->_langData = array();
		if (isset($_GET['lang'])) {
			
		} elseif (isset($_COOKIE['w_lang'])) {
			$this->setLang($_COOKIE['w_lang']);
		} else {
			$this->setLang(self::DEF_LANG);
		}
	}

	public function setLang($lang) {
		$this->_lang = $lang;
		setcookie('w_lang', $this->_lang, time() + 60 * 60 * 24 * 30, '/');
		$this->loadLangData($this->_lang);
	}

	public function getLang() {
		return $this->_lang;
	}

	public function loadLangData($lang) {
		$langFile = $this->_langFileDir . '/' . $lang . '.json';
		$strings = array();
		if (file_exists($langFile)) {
			$fileContent = file_get_contents($langFile);
			$strings = json_decode($fileContent, true);
		}
		$this->_langData = $strings;
		return $this->_langData;
	}

	public function getLangData() {
		return $this->_langData;
	}

	public function addSentense($from, $to = null) {
		$langFile = $this->_langFileDir . '/' . $this->_lang . '.json';
		if (file_exists($langFile)) {
			if (is_null($to)) {
				$to = $from;
			}
			$fileContent = file_get_contents($langFile);
			$langData = json_decode($fileContent, true);
			if (isset($langData[$from])) {
				return;
			}
			$fileContent = trim($fileContent);
			if ($fileContent == '')
				$fileContent = "{}";
			$fileContent = substr($fileContent, 0, strlen($fileContent) - 1);
			$fileContent = trim($fileContent);
			if (strlen($fileContent) > 1) {
				$fileContent .= ",";
			}
			$fileContent = $fileContent . "\n    " . json_encode($from) . ": " . json_encode($to) . "\n}";
			file_put_contents($langFile, $fileContent);
		}
	}

	public static function translate($key) {
		$langData = self::getInstance()->getLangData();
		if (isset($langData[$key])) {
			return $langData[$key];
		}
		self::getInstance()->addSentense($key);
		return $key;
	}

	public static function getInstance() {
		static $instance;
		if (!isset($instance)) {
			$instance = new WLanguage();
		}
		return $instance;
	}

	public function __destruct() {
		;
	}

}

function _t($key) {
	return WLanguage::translate($key);
}

function _e($key) {
	echo _t($key);
}
