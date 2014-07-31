<?php
require_once 'header.php';
$upload_dir = './uploads';

$stuffs = $my_db->select('fichier_files')
  ->fields(array('id', 'file_name', 'title'))
  ->where('active', 'A')
  ->run()
  ->fetchAllAssoc();
?>
<!-- Main jumbotron for a primary marketing message or call to action -->

<script type="text/javascript" src="./assets/js/vendor/jquery.mousewheel-3.0.6.pack.js"></script>

<script type="text/javascript" src="./assets/js/vendor/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/jquery.fancybox.css?v=2.1.5" media="screen" />

<link rel="stylesheet" type="text/css" href="./assets/css/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="./assets/js/vendor/jquery.fancybox-buttons.js?v=1.0.5"></script>

<link rel="stylesheet" type="text/css" href="./assets/css/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="./assets/js/vendor/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<script type="text/javascript" src="./assets/js/vendor/jquery.fancybox-media.js?v=1.0.6"></script>

<div class="main" id='stuffpage'>
  <div class="main_top"></div>
  <section class="container-fluid">
    <div class="container">
      <div class="main-content col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
        <div class="inner-content">
          <div class="content-header"><?php _e('Legal stuff'); ?></div>
          <div class="content-body col-lg-12 col-md-12 col-sm-12">
            <div class="col-lg-6 col-md-12 col-sm-12 file-description">
              <p><?php _e('Here\'s all the legal mumbo jumbo. It’s the stuff that lawyers dream of, but that the average user seldom reads, let alone understands. Feel free to read them but they basically state that we promise to never screw you over, sell your info or do anything else to compromise our integrity. In turn, we expect you to play fair and stick to our terms.'); ?></p>	
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-lg-6 file-items">
              <?php
              if (!empty($stuffs)) {
                foreach ($stuffs as $item) {
                  $item_ext = strtolower(pathinfo($item['file_name'], PATHINFO_EXTENSION));

                  if ($item_ext == 'pdf') {
                    $file_path = './assets/img/icon_pdf.png';
                    $stuff_class = 'fancy_pdf';
                  } else {
                    $file_path = './lib/download.php?file=' . $item['id'];
                    $stuff_class = 'fancy_image';
                  }
                  $read_file_path = './lib/download.php?file=' . $item['id'];
                  ?>
                  <div class="file-item">
                      <!--<a class="<?php echo $stuff_class; ?>" href="<?php echo $read_file_path; ?>" onclick="javascript:void(0);">-->
                    <img src="<?php echo $file_path; ?>" alt="<?php echo $item['title']; ?>" />
                    <!--</a>-->
                    <!--<a href="<?php echo $read_file_path; ?>">-->
                    <p class="file-title"><?php echo $item['title']; ?></p>
                    <!--</a>-->
                  </div>
                  <?php
                }
              }
              ?>
            </div>
          </div>
          <div class='clear'></div>
        </div>
      </div>
    </div>
  </section>
  <?php
  require_once 'footer.php';
  