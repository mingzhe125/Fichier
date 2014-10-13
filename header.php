<?php
require_once './lib/functions.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head lang="<?php echo $language; ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Fichier</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/bootstrap-theme.css">
    <link rel="stylesheet" href="lib/validator/dist/css/bootstrapValidator.min.css"/>
    <link rel="stylesheet" href="./assets/css/main.css">

    <script type="text/javascript">
      var site_url = '<?php echo $site_url; ?>';
      var lang_data = <?php echo json_encode(WLanguage::getInstance()->getLangData()); ?>;
      function _t(key) {
        if (!lang_data[key]) {
          $.ajax({
            type: "POST",
            url: "lib/ajax_fileupload.php",
            data: {action: 'translate', key: key},
            success: function () {
            }
          });
          return key;
        } else {
          return lang_data[key];
        }
      }
    </script>
    <script src="./assets/js/vendor/jquery-1.11.0.js"></script>
    <script src="./assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="./assets/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/validator/dist/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </head>
  <body class="<?php echo $language; ?>">
    <div class="wrapper container-fluid">
      <img class="main_back bg_1 opaque" src="assets/img/main_back_1.jpg" alt="" />
      <img class="main_back bg_2" src="assets/img/main_back_2.jpg" alt="" />
      <img class="main_back bg_3" src="assets/img/main_back_3.jpg" alt="" />
      <img class="bg_4" src="assets/img/maquette.png" alt="" />
      <div class="header container text-center">
        <div class="logo-wrapper col-lg-12">
          <a class="logo" href="./index.php">
            <img src="./assets/img/logo.png" />
          </a>
        </div>
        <div class="site-info col-lg-12">
          <p class="first-meta"><?php _e('Send large files for free'); ?></p>
          <p class="second-meta"><?php _e('up to 5 GB per transfer!'); ?></p>
        </div>
        <ul class="setting-section col-lg-12">
          <li class="first-meta"><?php _e('Security'); ?></li>
          <li class="second-meta"><?php _e('Custom'); ?></li>
          <li class="third-meta"><?php _e('Share'); ?></li>
          <li class="fourth-meta"><?php _e('Large Files'); ?></li>
          <li class="fifth-meta"><?php _e('Store'); ?></li>
        </ul>
        <div class="col-lg-12">
          <div class="navbar">
            <ul class="flag-nav">
              <li>
                <a class="france <?php echo $language == 'fr' ? 'actived' : ''; ?>" href="<?php echo add_query_arg('lang', 'fr'); ?>">
                  <img alt="" src="assets/img/flag_es.png" />
                </a>
              </li>
              <li>
                <a class="england <?php echo $language == 'en' ? 'actived' : ''; ?>" href="<?php echo add_query_arg('lang', 'en'); ?>">
                  <img alt="" src="assets/img/flag_en.png" />
                </a>
              </li>
              <li>
                <a class="espana <?php echo $language == 'es' ? 'actived' : ''; ?>" href="<?php echo add_query_arg('lang', 'es'); ?>">
                  <img alt="" src="assets/img/flag_fr.png" />
                </a>
              </li>
            </ul>
          </div>
        </div><!--/.navbar-collapse -->
      </div>