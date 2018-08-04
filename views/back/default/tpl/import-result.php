<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('import products result page')?>
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

      <div class="row">
        <div class="col-xs-12">
          
          <div class="form-group">
            <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                <i class="fa fa-arrow-left"></i>
                <?=$this->getTranslation('btn back')?>
            </a>
        </div>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('products import results')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <tr>
                  <td>
                    <strong><?=$this->getTranslation('updated')?></strong>
                  </td>
                  <td>
                    <?=$updated?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong><?=$this->getTranslation('inserted')?></strong>
                  </td>
                  <td>
                    <?=$inserted?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong><?=$this->getTranslation('errors')?></strong>
                  </td>
                  <td>
                    <?=count($fileErrors)?>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
          <?php if(count($fileErrors) > 0){ ?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('products import errors')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <?php foreach($fileErrors as $key => $value){ ?>
                <tr>
                  <td>
                    <strong><?=$key?></strong>
                  </td>
                  <td>
                    <ul>
                    <?php foreach ($value as $value1) { ?>
                      <li><?=$value1?></li>
                    <?php } ?>
                    </ul>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <?php } ?>


          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->