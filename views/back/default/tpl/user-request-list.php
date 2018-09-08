Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('user-request page')?>
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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->t('user-request list', 'back')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax']?>" data-order="[[ 0, &quot;desc&quot; ]]">
                <thead>
                    <tr>
                        <th class="wh"><?=$this->t('id', 'back')?></th>
                        <th><?=$this->t('user', 'back')?></th>
                        <th><?=$this->t('type', 'back')?></th>
                        <th><?=$this->t('target', 'back')?></th>
                        <th><?=$this->t('date', 'back')?></th>
                        <th><?=$this->t('status', 'back')?></th>
                        <th><?=$this->t('control buttons', 'back')?></th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                        <th class="wh"><?=$this->t('id', 'back')?></th>
                        <th><?=$this->t('user', 'back')?></th>
                        <th><?=$this->t('type', 'back')?></th>
                        <th><?=$this->t('target', 'back')?></th>
                        <th><?=$this->t('date', 'back')?></th>
                        <th><?=$this->t('status', 'back')?></th>
                        <th><?=$this->t('control buttons', 'back')?></th>
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