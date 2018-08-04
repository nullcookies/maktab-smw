<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('stats page')?>
        <small><?=$this->getTranslation('control panel')?></small>
      </h1>
      <?php 
          if(isset($breadcrumbs)){ 
            $this->renderBreadcrumbs($breadcrumbs);
          }
      ?>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <?=$this->renderNotifications($successText, $errorText)?>

      <div>
          <?php if($stats){ ?>
          <?php foreach($stats as $key => $value){ ?>
          <a href="<?=$value['url']?>" class="btn btn-app btn-default">
            <i class="fa fa-pie-chart"></i>
            <?=$value['name']?>
          </a>
          <?php } ?>
          <?php } ?>
          
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->