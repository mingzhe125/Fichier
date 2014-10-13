<?php

// Force download of image file specified in URL query string and which
// is in the same directory as the download.php script.

if (empty($_REQUEST['file'])) {
  header("HTTP/1.0 404 Not Found");
  return;
}

$file_id = $_REQUEST['file'];

require_once dirname(__FILE__) . '/class.db.php';
//$my_db = new db("mysql:host=localhost;dbname=hoxone_fichier", 'fichier', 'Ke7s4dDT&*');
$my_db = new db("mysql:host=localhost;dbname=2014_07_fichier", 'root', '');

$file_item = $my_db->select('fichier_files')
  ->fields(array('title', 'file_name', 'password'))
  ->where('id', $file_id)
  ->run()
  ->fetchAssoc();

if (empty($file_item)) {
  header("HTTP/1.0 404 Not Found");
  return;
}

if ($file_item['password'] != '') {
  if (!isset($_REQUEST['filepassword'])) {
    header('Location:../download.php?file=' . $_REQUEST['file']);
    exit;
  } else {
    if ((md5($_REQUEST['filepassword']) != $file_item['password'])) {
      header('Location:../download.php?file=' . $_REQUEST['file'] . '&error=p');
      exit;
    }
  }
}

$upload_dir = './uploads';
$basename = basename($file_item['file_name']);
$item_ext = strtolower(pathinfo($file_item['file_name'], PATHINFO_EXTENSION));
$filename = dirname(__FILE__) . '/../uploads/' . $file_item['file_name'];

$mime = ($mime = getimagesize($filename)) ? $mime['mime'] : $mime;
$size = filesize($filename);

if ($item_ext == 'pdf') {
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=" . urlencode($filename));
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-Description: File Transfer");
  header("Content-Length: " . $size);
  flush(); // this doesn't really matter.
  $fp = fopen($filename, "r");
  while (!feof($fp)) {
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
  }
  fclose($fp);
} else {
  $fp = fopen($filename, "rb");
  if (!($mime && $size && $fp)) {
    return;
  }

  header("Content-type: " . $mime);
  header("Content-Length: " . $size);
// NOTE: Possible header injection via $basename
  header("Content-Disposition: attachment; filename=" . $file_item['title']);
  header('Content-Transfer-Encoding: binary');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  fpassthru($fp);
}