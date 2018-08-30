<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('additional settings')?>
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
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add option')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('additional settings')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table table table-bordered table-hover" data-b-sort="false">
                <thead>
                    <tr>
                      <th><?=$this->getTranslation('settings')?></th>
                      <th><?=$this->getTranslation('control')?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <?=$this->getTranslation('maintenance mode')?>
                      </td>
                      <td class="td-shrink">
                        <div class="status-change">
                          <input data-toggle="toggle" data-on="<?=$this->getTranslation('toggle on')?>" data-off="<?=$this->getTranslation('toggle off')?>" data-onstyle="warning" type="checkbox" name="visible" data-controller="option" data-table="option" data-id="11" class="status-toggle" <?php if($maintainance){ ?>checked<?php } ?>>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <?=$this->getTranslation('cache size')?>: <i id="cache-size"><?=$cacheSize?></i>,
                        <?=$this->getTranslation('cache synchro size')?>: <i id="cache-synchro-size"><?=$cacheSynchroSize?></i>
                      </td>
                      <td class="td-shrink">
                        <a id="clean-cache" class="btn btn-danger" href="<?=$cleanCacheUrl?>">
                            <i title="<?=$this->getTranslation('btn delete')?>" class="fa fa-trash-o"></i>
                            <?=$this->getTranslation('clean')?>
                        </a>
                      </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                      <th><?=$this->getTranslation('settings')?></th>
                      <th><?=$this->getTranslation('control')?></th>
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