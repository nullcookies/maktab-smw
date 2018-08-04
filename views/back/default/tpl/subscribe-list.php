Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('subscribe page')?>
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
          <p>
              <a href="<?=$controls['add']?>" class="btn btn-app btn-success">
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add subscribe')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('subscribe list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax']?>" data-order="[[0, &quot;desc&quot;]]">
                <thead>
                    <tr>
                      <th class="td-shrink"><?=$this->getTranslation('id')?></th>
                      <th><?=$this->getTranslation('name')?></th>
                      <th><?=$this->getTranslation('email')?></th>
                      <th><?=$this->getTranslation('phone')?></th>
                      <th class="td-shrink"><?=$this->getTranslation('status')?></th>
                      <th class="td-shrink"><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                      <th class="td-shrink"><?=$this->getTranslation('id')?></th>
                      <th><?=$this->getTranslation('name')?></th>
                      <th><?=$this->getTranslation('email')?></th>
                      <th><?=$this->getTranslation('phone')?></th>
                      <th class="td-shrink"><?=$this->getTranslation('status')?></th>
                      <th class="td-shrink"><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper