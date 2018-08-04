<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('filter page')?>
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
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add filter')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('filter list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table table table-bordered table-hover">
                <thead>
                    <tr>
                      <th class="wh"><?=$this->getTranslation('id')?></th>
                      <th><?=$this->getTranslation('filter name')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($filters){ ?>
                    <?php foreach($filters as $value){ ?>
                    <tr>
                      <td class="td-shrink"><?=$value['id']?></td>
                      <td><?=$value['name'][LANG_ID]?></td>
                      <td class="td-shrink">
                          <a class="btn btn-warning" title="<?=$this->getTranslation('btn edit')?>" href="<?=$controls['view'] . $value['id']?>">
                              <i class="fa fa-eye"></i>
                          </a>
                          <a class="btn btn-info" title="<?=$this->getTranslation('btn edit')?>" href="<?=$controls['edit'] . $value['id']?>">
                              <i class="fa fa-edit"></i>
                          </a>
                          <a class="btn btn-danger" href="<?=$controls['delete'] . $value['id']?>" data-toggle="confirmation" data-btn-ok-label="<?=$this->getTranslation('confirm yes')?>" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label="<?=$this->getTranslation('confirm no')?>" data-btn-cancel-icon="fa fa-times"
                            data-btn-cancel-class="btn-danger btn-xs" data-title="<?=$this->getTranslation('are you sure')?>" >
                              <i title="<?=$this->getTranslation('btn delete')?>" class="fa fa-trash-o"></i>
                          </a>
                      </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                      <th class="wh"><?=$this->getTranslation('id')?></th>
                      <th><?=$this->getTranslation('filter name')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
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