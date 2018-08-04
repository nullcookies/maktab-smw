<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('translation page')?>
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
                <i class="fa fa-plus-circle"></i> <?=$this->getTranslation('add word')?>
              </a>
          </p>
      </div>

      <?php if($languages){ ?>
      <div class="box box-success">
        <div class="box-body">
          <?php foreach($languages as $value){ ?>
          <a class="btn btn-default <?php if($langId == $value['id']){ ?>active<?php } ?>" href="<?=$controls['main'] . $value['id']?>/">
            <?=$value['name']?>
          </a>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('words list')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="data-table table table-bordered table-hover">
                <thead>
                    <tr>
                      <th><?=$this->getTranslation('word')?></th>
                      <th><?=$this->getTranslation('content')?></th>
                      <th><?=$this->getTranslation('context')?></th>
                      <th><?=$this->getTranslation('control buttons')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($words){ ?>
                    <?php foreach($words as $value){ ?>
                    <tr>
                      <td class="td-shrink" style="min-width: 200px;max-width: 400px;white-space: normal;">
                        <?=$value['name']?>
                      </td>
                      <td data-order="<?=$value['content']?>" style="max-width: 400px;">
                        <input class="form-control translation-input" type="text" data-id="<?=$value['id']?>" id="word<?=$value['id']?>" name="word<?=$value['id']?>" value="<?=htmlspecialchars($value['content'], ENT_QUOTES)?>">
                      </td>
                      <td class="td-shrink">
                        <p class="form-control-static"><?=$value['context']?></p>
                      </td>

                      <td class="td-shrink">
                          <a class="btn btn-success translation-save"  data-lang-id="<?=$langId?>" data-id="<?=$value['id']?>" href="<?=$controls['save'] . $value['id']?>/" title="<?=$this->getTranslation('btn save')?>">
                              <i class="fa fa-save"></i>
                          </a>
                          <a class="btn btn-danger" href="<?=$controls['delete'] . $langId . '/' . $value['id']?>" data-toggle="confirmation" data-btn-ok-label="<?=$this->getTranslation('confirm yes')?>" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label="<?=$this->getTranslation('confirm no')?>" data-btn-cancel-icon="fa fa-times"
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
                      <th><?=$this->getTranslation('word')?></th>
                      <th><?=$this->getTranslation('content')?></th>
                      <th><?=$this->getTranslation('context')?></th>
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