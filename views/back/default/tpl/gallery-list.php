Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('gallery page')?>
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
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add gallery file')?>
              </a>
          </p>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('gallery list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax']?>" data-order="[[0, &quot;desc&quot;]]">
                <thead>
                    <tr>
                      <th class="wh"><?=$this->getTranslation('id')?></th>
                      <th class="wh"><?=$this->getTranslation('image')?></th>
                      <th class="wh"><?=$this->getTranslation('path')?></th>
                      <th class="wh"><?=$this->getTranslation('sort.')?></th>
                      <th><?=$this->getTranslation('file name')?></th>
                      <!-- <th><?=$this->getTranslation('alt name')?></th> -->
                      <th ><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>
                <?php
                /*
                <tbody>
                    <?php if($products){ ?>
                    <?php foreach($products as $value){ ?>
                    <tr>
                      <td class="td-shrink"><?=$value['sort_number']?></td>
                      <td><?=$value['name'][LANG_ID]?></td>
                      <td><?=$categoryNames[$value['category_id']][LANG_ID]?></td>
                      <td><?=$value['price']?></td>
                      <td>
                        <i><?=$this->getTranslation('stock 1')?>:&nbsp;</i><?=$value['stock_1']?><br>
                        <?php 
                        <i><?php //=$this->getTranslation('stock 2')?>:&nbsp;</i><?=$value['stock_2']?><br>
                        <i><?php //=$this->getTranslation('stock 3')?>:&nbsp;</i><?=$value['stock_3']?><br>
                         ?>
                      </td>
                      <td>
                        <strong><?=date('d-m-Y', $value['date_modify'])?></strong>
                        <span><?=date('H:i', $value['date_modify'])?></span>
                      </td>
                      <td class="td-shrink">
                        <div class="status-change">
                          <input data-toggle="toggle" data-on="<?=$this->getTranslation('toggle on')?>" data-off="<?=$this->getTranslation('toggle off')?>" data-onstyle="warning" type="checkbox" name="status" data-controller="product" data-table="product" data-id="<?=$value['id']?>" class="status-toggle" <?php echo ($value['status']) ? 'checked' : ''; ?> >
                        </div>
                      </td>
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
                */
                ?>
                <tfoot>
                    <tr>
                      <th class="wh"><?=$this->getTranslation('id')?></th>
                      <th class="wh"><?=$this->getTranslation('image')?></th>
                      <th class="wh"><?=$this->getTranslation('path')?></th>
                      <th class="wh"><?=$this->getTranslation('sort.')?></th>
                      <th><?=$this->getTranslation('file name')?></th>
                      <!-- <th><?=$this->getTranslation('alt name')?></th> -->
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
  <!-- /.content-wrapper