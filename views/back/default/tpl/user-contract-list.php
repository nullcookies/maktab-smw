<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('usercontract page')?>
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
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add usercontract')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('usercontract list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="data-table table table-bordered table-hover" data-order="[[ 1, &quot;desc&quot; ]]">
                <thead>
                    <tr>
                      <th><?=$this->getTranslation('company name')?></th>
                      <th><?=$this->getTranslation('contract year')?></th>
                      <th><?=$this->getTranslation('contract number')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($usercontracts){ ?>
                    <?php foreach($usercontracts as $value){ ?>
                    <tr>
                      <td><?=$value['company_name']?></td>
                      <td><?=$value['contract_year']?></td>
                      <td><?=$value['contract_number']?></td>
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
                      <th><?=$this->getTranslation('company name')?></th>
                      <th><?=$this->getTranslation('contract year')?></th>
                      <th><?=$this->getTranslation('contract number')?></th>
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