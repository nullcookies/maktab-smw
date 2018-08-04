<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('add order');?>
        <!-- <small>Optional description</small> -->
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
        
        <form id="order-add-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_add" value="<?=$this->getTranslation('btn save')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group<?php if($errors['name'][$l_key]) { ?> has-error<?php } ?>">
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('order name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control translit-from" data-path="<?=$this->config['alias']['order']?>" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?= $order['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr<?=$l_key?>"><?=$this->getTranslation('descr short')?> (<?=$l_value?>)</label>
                                <textarea class="form-control" name="descr[<?=$l_key?>]" id="descr<?=$l_key?>"><?= $order['descr'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr_full<?=$l_key?>"><?=$this->getTranslation('descr full')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ckeditor"  name="descr_full[<?=$l_key?>]" id="descr_full<?=$l_key?>"><?= $order['descr_full'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status"><?=$this->getTranslation('status');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($order['status']) echo " checked "; ?> />
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['alias']) { ?>has-error<?php } ?>">
                                <label for="alias">
                                    <?=$this->getTranslation('alias name')?>
                                </label>
                                <input type="checkbox" id="alias-auto" data-toggle="toggle" data-size="mini" data-onstyle="success" data-on="auto" data-off="-" checked >
                                <input type="text" class="form-control translit-to" name="alias" id="alias" value="<?= $order['alias']; ?>" />
                                <?php if($errors['alias']) { ?><div class="help-block"><?=$this->getTranslation($errors['alias'])?></div><?php } ?>
                            </div>
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('order parent')?></label>
                                <select name="parent_order_id" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($categories){ ?>
                                    <?php foreach($categories as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if($value['id'] == $order['parent_order_id']){ ?>selected<?php } ?> ><?=$value['name'][LANG_ID]?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sort_number"><?=$this->getTranslation('sorting')?></label>
                                <input type="text" class="form-control" name="sort_number" id="sort_number" value="<?= $order['sort_number']; ?>" />
                            </div>
                            <div class="form-group <?php if($errors['image']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('upload avatar')?></label>
                                <input class="image-fileinput" type="file" name="image" />
                                <?php if($errors['image']) { ?><div class="help-block"><?=$this->getTranslation($errors['image'])?></div><?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-success collapse-box collapsed-box">
                <div class="box-header">
                  <h3 class="box-title">
                    <?=$this->getTranslation('meta data')?>
                  </h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-plus"></i>
                    </button>
                    
                  </div>
                  <!-- /. tools -->
                </div>
                <div class="box-body">
                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_t<?=$l_key?>">Meta title (<?=$l_value?>)</label>
                        <input type="text" class="form-control"  name="meta_t[<?=$l_key?>]" id="meta_t<?=$l_key?>" value="<?= $order['meta_t'][$l_key]; ?>" />
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_d<?=$l_key?>">Meta description (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_d[<?=$l_key?>]" id="meta_d<?=$l_key?>"><?= $order['meta_d'][$l_key]; ?></textarea>
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_k<?=$l_key?>">Meta keywords (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_k[<?=$l_key?>]" id="meta_k<?=$l_key?>"><?= $order['meta_k'][$l_key]; ?></textarea>
                    </div>
                    <?php } ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->

            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_add" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        