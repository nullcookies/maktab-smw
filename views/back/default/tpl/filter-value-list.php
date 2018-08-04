<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('filter value page')?>
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
              <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                <i class="fa fa-arrow-left"></i>
                <?=$this->getTranslation('btn back')?>
              </a>
              <a href="<?=$controls['add']?>" class="btn btn-app btn-success">
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add filter value')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('filter value list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table table table-bordered table-hover">
                <thead>
                    <tr>
                      <th class="wh"><?=$this->getTranslation('sort.')?></th>
                      <th><?=$this->getTranslation('filter value parent')?></th>
                      <th><?=$this->getTranslation('filter value name')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($filterValues){ ?>
                    <?php foreach($filterValues as $value){ ?>
                    <tr>
                      <td class="td-shrink"><?=$value['sort_number']?></td>
                      <td><?=$filterNames[$value['filter_id']][LANG_ID]?></td>
                      <td><?=$value['name'][LANG_ID]?></td>
                      <td class="td-shrink">
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
                      <th class="wh"><?=$this->getTranslation('sort.')?></th>
                      <th><?=$this->getTranslation('filter value parent')?></th>
                      <th><?=$this->getTranslation('filter value name')?></th>
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