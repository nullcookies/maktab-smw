Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('category page')?>
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
        <!-- category list -->
        <div class="col-xs-12">
          <div>
              <p>
                  <a href="<?=$controls['add']?>" class="btn btn-app btn-success">
                    <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add category')?>
                  </a>
              </p>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('category list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table table table-bordered table-hover" data-order="[[1, &quot;asc&quot;]]">
                <thead>
                    <tr>
                      <th class="wh"><?=$this->getTranslation('id')?></th>
                      <th><?=$this->getTranslation('category name')?></th>
                      <th><?=$this->getTranslation('status')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($categories){ ?>
                    <?php foreach($categories as $value){ ?>
                    <tr>
                      <td class="td-shrink"><?=$value['id']?></td>
                      <td><?=$categoryNames[$value['id']]['name']?></td>
                      <td class="td-shrink">
                        <div class="status-change">
                          <input data-toggle="toggle" data-on="<?=$this->getTranslation('toggle on')?>" data-off="<?=$this->getTranslation('toggle off')?>" data-onstyle="warning" type="checkbox" name="status" data-controller="category" data-table="category" data-id="<?=$value['id']?>" class="status-toggle" <?php echo ($value['status']) ? 'checked' : ''; ?> >
                        </div>
                      </td>
                      <td class="td-shrink">
                          <a class="btn btn-info" title="<?=$this->getTranslation('btn edit')?>" href="<?=$controls['edit'] . $value['id']?>">
                              <i class="fa fa-edit"></i>
                          </a>
                          <a class="btn btn-danger" href="<?=$controls['deleteConfirm'] . $value['id']?>" data-toggle="confirmation" data-btn-ok-label="<?=$this->getTranslation('confirm yes')?>" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label="<?=$this->getTranslation('confirm no')?>" data-btn-cancel-icon="fa fa-times"
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
                      <th><?=$this->getTranslation('category name')?></th>
                      <th><?=$this->getTranslation('status')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- category list -->

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper