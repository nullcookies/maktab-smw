<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('teacher page')?>
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
                <i class="fa fa-plus-circle"></i> <?=$this->t('add teacher', 'back')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->t('teacher list', 'back')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table table table-bordered table-hover">
                <thead>
                    <tr>
                      <th class="wh"><?=$this->t('id', 'back')?></th>
                      <th><?=$this->t('fio', 'back')?></th>
                      <th><?=$this->t('username', 'back')?></th>
                      <th><?=$this->t('phone', 'back')?></th>
                      <th><?=$this->t('control buttons', 'back')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($users){ ?>
                    <?php foreach($users as $value){ ?>
                    <tr>
                      <td class="td-shrink"><?=$value['id']?></td>
                      <td><?=$value['lastname']?> <?=$value['firstname']?> <?=$value['middlename']?></td>
                      <td><?=$value['username']?></td>
                      <td><?=$value['phone']?></td>
                      <td class="td-shrink">
                          <a class="btn btn-info" title="<?=$this->t('btn edit', 'back')?>" href="<?=$controls['view'] . '?id=' . $value['id']?>">
                              <i class="fa fa-edit"></i>
                          </a>
                          <a class="btn btn-danger" href="<?=$controls['delete'] . '?id=' . $value['id']?>" data-toggle="confirmation" data-btn-ok-label="<?=$this->t('confirm yes', 'back')?>" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label="<?=$this->t('confirm no', 'back')?>" data-btn-cancel-icon="fa fa-times"
                            data-btn-cancel-class="btn-danger btn-xs" data-title="<?=$this->t('are you sure', 'back')?>" >
                              <i title="<?=$this->t('btn delete', 'back')?>" class="fa fa-trash-o"></i>
                          </a>
                      </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                      <th class="wh"><?=$this->t('id', 'back')?></th>
                      <th><?=$this->t('fio', 'back')?></th>
                      <th><?=$this->t('username', 'back')?></th>
                      <th><?=$this->t('phone', 'back')?></th>
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