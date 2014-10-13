<?php

require_once dirname(__FILE__) . '/class.db.php';
//$my_db = new db("mysql:host=localhost;dbname=hoxone_fichier", 'fichier', 'Ke7s4dDT&*');
$my_db = new db("mysql:host=localhost;dbname=2014_07_fichier", 'root', '');

if (isset($_REQUEST['method']) && $_REQUEST['method'] == 'delete') {
  $del_id = $_REQUEST['id'];
  $sql = "DELETE FROM `fichier_files` WHERE `id` = :id_to_delete";
  $query = $my_db->prepare($sql);
  $query->execute(array(":id_to_delete" => $del_id));
} else if (isset($_REQUEST['filename']) && $_REQUEST['filename'] != '') {
  $str = file_get_contents('php://input');
  $file_name = $_GET['filename'];
  $title = strtolower(pathinfo($file_name, PATHINFO_FILENAME));
  $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

  $purpose_file = md5($file_name) . uniqid() . '.' . $ext;

  $my_db->insert('fichier_files')->fields(array(
      'author' => 'admin',
      'title' => $title,
      'file_name' => $purpose_file,
      'created_at' => date('Y-m-d H:i:s')
  ))->run();

  echo $my_db->lastInsertId();
  file_put_contents("../uploads/" . $purpose_file, $str);
}


if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'translate') {
  require_once dirname(__FILE__) . '/functions.php';
  $key = $_REQUEST['key'];
  WLanguage::getInstance()->addSentense($key);
  echo 'success';
}