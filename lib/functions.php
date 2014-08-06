<?php

//error_reporting(~E_ALL);

session_start();
//function my_session_start() {
//  $sn = session_name();
//  if (isset($_COOKIE[$sn])) {
//    $sessid = $_COOKIE[$sn];
//  } else if (isset($_GET[$sn])) {
//    $sessid = $_GET[$sn];
//  } else {
//    return session_start();
//  }
//
//  if (!preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $sessid)) {
//    return false;
//  }
//  return session_start();
//}
//if (!my_session_start()) {
//  session_id(uniqid());
//  session_start();
//  session_regenerate_id();
//}

require_once dirname(__FILE__) . '/language.php';
require_once dirname(__FILE__) . '/class.db.php';

/** set language if lang param is passed */
if (isset($_GET['lang']) && $_GET['lang'] != '') {
  WLanguage::getInstance()->setLang($_GET['lang']);
}

$language = WLanguage::getInstance()->getLang();
//$my_db = new db("mysql:host=localhost;dbname=creationdesitenet9", 'dev8', '9fmhd9hjr3ls');
//$site_url = 'http://www.creationdesite.net/~dev8/fichier';
$site_url = 'http://127.0.0.7/07_fichier/public_html';
$my_db = new db("mysql:host=localhost;dbname=2014_07_fichier", 'root', '');

$error_message = '';
$success_message = '';

if (isset($_GET['method'])) {
  if ($_GET['method'] == 'mail') {
    if (empty($_SESSION['captcha']) || strtolower(trim($_REQUEST['captcha'])) != $_SESSION['captcha']) {
      $error_message = "Invalid captcha";
    } else {
      require_once(dirname(__FILE__) . '/mail.php');

      define('TO_EMAIL', 'vincent@enoxone.ch');
      $emailContent = $_REQUEST['message'];

      $mail = new Mail();
      $mail->ContentType = 'text/html';

      $mail->setMailFrom($_REQUEST['email'], $_REQUEST['username']);
      $mail->setMailTo(TO_EMAIL);
      $mail->setMailTitle('Fichier Web Site');
      $mail->setMailContent($emailContent);
      $mail->sendToMail();

      $success_message = _t('Email has been sent successfully!');
    }
  } else if ($_GET['method'] == 'attach') {
    if (empty($_SESSION['captcha']) || strtolower(trim($_REQUEST['captcha'])) != $_SESSION['captcha']) {
      $error_message = _t("Invalid captcha");
    } else {
      require_once(dirname(__FILE__) . '/mail.php');
      $emailContent = '<h3>' . _t('Hello there') . ', </h3>'
        . '<h4>' . _t('You received an email') . ': "' . $_REQUEST['from_email'] . '"</h4>'
        . '<h4>' . _t('Here is the message') . ' : ' . $_REQUEST['message'] . '</h4>';
      if (isset($_REQUEST['uploaded_files']) && !empty($_REQUEST['uploaded_files'])) {
        $emailContent .= '<h4>' . _t('Here is(are) the file(s) available for download') . ':</h4>'
          . '<table>';
        foreach ($_REQUEST['uploaded_files'] as $file_item) {
          $file_info = $my_db->select('fichier_files')
            ->fields(array('title', 'file_name'))
            ->where('id', $file_item)
            ->run()
            ->fetchAssoc();
          $emailContent .= '<tr><td style = "border-top:1px solid #eee;"><a href = "' . $site_url . '/lib/download.php?file=' . $file_item . '">' . $file_info['file_name'] . '</a></td>'
            . '<td>' . $_REQUEST['uploaded_file_size'][$file_item] . '</td></tr>';
          $update_fiels = array('active' => 'A');
          if (isset($_REQUEST['filepassword']) && $_REQUEST['filepassword'] != '') {
            $update_fiels['password'] = md5($_REQUEST['filepassword']);
          }
          $my_db->update('fichier_files', $update_fiels)->where('id', $file_item)->run();
        }
        $emailContent .='</table>';
      }

      if (isset($_REQUEST['filepassword']) && $_REQUEST['filepassword'] != '') {
        $emailContent .= '<h3><strong>' . _t('Password') . ' : </strong> ' . $_REQUEST['filepassword'] . '</h3>';
      }

      $emailContent .= _t('<h3>"By clicking on the file you download the corresponding file"</h3>'
        . '<h3>Best regards, '
        . 'Fichier.ch <br/>
          Team <br/><br/>
          Service for sending free file!<br/>
          <a href = "http://www.creationdesite.net/~dev8/fichier/">www.fichier.ch</a>'
        . '</h3>');

      $mail = new Mail();
      $mail->ContentType = 'text/html';

      $mail->setMailFrom($_REQUEST['from_email'], $_REQUEST['from_email']);
      $mail->setMailTo($_REQUEST['to_email']);
      $mail->setMailTitle('Fichier Web Site');
      $mail->setMailContent('<html><head></head><body>' . $emailContent . '</body></html>');
      $mail->sendToMail();

      $success_message = _t('Your email was sent');
    }
  }
}

function add_query_arg() {
  $ret = '';
  $args = func_get_args();
  if (is_array($args[0])) {
    if (count($args) < 2 || false === $args[1]) {
      $uri = $_SERVER['REQUEST_URI'];
    } else {
      $uri = $args[1];
    }
  } else {
    if (count($args) < 3 || false === $args[2]) {
      $uri = $_SERVER['REQUEST_URI'];
    } else {
      $uri = $args[2];
    }
  }

  if ($frag = strstr($uri, '#')) {
    $uri = substr($uri, 0, -strlen($frag));
  } else {
    $frag = '';
  }

  if (0 === stripos($uri, 'http://')) {
    $protocol = 'http://';
    $uri = substr($uri, 7);
  } elseif (0 === stripos($uri, 'https://')) {
    $protocol = 'https://';
    $uri = substr($uri, 8);
  } else {
    $protocol = '';
  }

  if (strpos($uri, '?') !== false) {
    list( $base, $query ) = explode('?', $uri, 2);
    $base .= '?';
  } elseif ($protocol || strpos($uri, '=') === false) {
    $base = $uri . '?';
    $query = '';
  } else {
    $base = '';
    $query = $uri;
  }

  wp_parse_str($query, $qs);
  $qs = urlencode_deep($qs); // this re-URL-encodes things that were already in the query string
  if (is_array($args[0])) {
    $kayvees = $args[0];
    $qs = array_merge($qs, $kayvees);
  } else {
    $qs[$args[0]] = $args[1];
  }

  foreach ($qs as $k => $v) {
    if ($v === false) {
      unset($qs[$k]);
    }
  }

  $ret = build_query($qs);
  $ret = trim($ret, '?');
  $ret = preg_replace('#=(&|$)#', '$1', $ret);
  $ret = $protocol . $base . $ret . $frag;
  $ret = rtrim($ret, '?');
  return $ret;
}

function wp_parse_str($string, &$array) {
  parse_str($string, $array);
  if (get_magic_quotes_gpc())
    $array = stripslashes_deep($array);
}

function stripslashes_deep($value) {
  if (is_array($value)) {
    $value = array_map('stripslashes_deep', $value);
  } elseif (is_object($value)) {
    $vars = get_object_vars($value);
    foreach ($vars as $key => $data) {
      $value->{$key} = stripslashes_deep($data);
    }
  } elseif (is_string($value)) {
    $value = stripslashes($value);
  }

  return $value;
}

function urlencode_deep($value) {
  $value = is_array($value) ? array_map('urlencode_deep', $value) : urlencode($value);
  return $value;
}

function build_query($data) {
  return _http_build_query($data, null, '&', '', false);
}

function _http_build_query($data, $prefix = null, $sep = null, $key = '', $urlencode = true) {
  $ret = array();

  foreach ((array) $data as $k => $v) {
    if ($urlencode) {
      $k = urlencode($k);
    }
    if (is_int($k) && $prefix != null) {
      $k = $prefix . $k;
    }
    if (!empty($key)) {
      $k = $key . '%5B' . $k . '%5D';
    }
    if ($v === null) {
      continue;
    } elseif ($v === FALSE) {
      $v = '0';
    }

    if (is_array($v) || is_object($v)) {
      array_push($ret, _http_build_query($v, '', $sep, $k, $urlencode));
    } elseif ($urlencode) {
      array_push($ret, $k . '=' . urlencode($v));
    } else {
      array_push($ret, $k . '=' . $v);
    }
  }

  if (null === $sep) {
    $sep = ini_get('arg_separator.output');
  }

  return implode($sep, $ret);
}
