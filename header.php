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

    <script src="./assets/js/vendor/jquery-1.11.0.js"></script>
    <script src="./assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="./assets/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/validator/dist/js/bootstrapValidator.min.js"></script>
    <script src="./assets/js/main.js"></script>
  </head>
  <body class="<?php echo $language; ?>">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
          return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <header class="navbar navbar-inverse" role="navigation">
      <div class="header container-fluid">
        <div class="navbar-header col-lg-3 col-md-12">
          <a class="navbar-brand" href="./index.php">
            <img src="./assets/img/logo.png" />
          </a>
        </div>
        <div class="site-info col-lg-6 col-md-6">
          <p><?php
            _e('Send large files for free up');
            echo '<span class="blue">&nbsp;&nbsp;';
            _e('5 GB');
            echo '&nbsp;&nbsp;</span>';
            _e('transfer!');
            ?></p>
        </div>
        <div class="navbar-collapse col-lg-3 col-md-6">
          <div class="navbar">
            <div class="navbar-inner">
              <ul class="nav">
                <li><a class="france <?php echo $language == 'fr' ? 'actived' : ''; ?>" href="<?php echo add_query_arg('lang', 'fr'); ?>">France</a></li>
                <li><a class="england <?php echo $language == 'en' ? 'actived' : ''; ?>" href="<?php echo add_query_arg('lang', 'en'); ?>">England</a></li>
                <li><a class="espana <?php echo $language == 'es' ? 'actived' : ''; ?>" href="<?php echo add_query_arg('lang', 'es'); ?>">Espana</a></li>
              </ul>
            </div>
          </div>
        </div><!--/.navbar-collapse -->
      </div>
    </header>