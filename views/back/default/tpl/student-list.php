<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('student page')?>
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
              <a href="<?=$controls['view']?>" class="btn btn-app btn-success">
                <i class="fa fa-plus-circle"></i> <?=$this->t('add student', 'back')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->t('student list', 'back')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax']?>" data-order="[[ 1, &quot;asc&quot; ]]">
                <thead>
                    <tr>
                      <th class="wh"><?=$this->t('id', 'back')?></th>
                      <th><?=$this->t('lastname', 'back')?></th>
                      <th><?=$this->t('firstname', 'back')?></th>
                      <th><?=$this->t('group', 'back')?></th>
                      <th><?=$this->t('username', 'back')?></th>
                      <th><?=$this->t('phone', 'back')?></th>
                      <th><?=$this->t('email', 'back')?></th>
                      <th><?=$this->t('status', 'back')?></th>
                      <th><?=$this->t('control buttons', 'back')?></th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                      <th class="wh"><?=$this->t('id', 'back')?></th>
                      <th><?=$this->t('lastname', 'back')?></th>
                      <th><?=$this->t('firstname', 'back')?></th>
                      <th><?=$this->t('group', 'back')?></th>
                      <th><?=$this->t('username', 'back')?></th>
                      <th><?=$this->t('phone', 'back')?></th>
                      <th><?=$this->t('email', 'back')?></th>
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
  <!-- /.content-wrapper -->