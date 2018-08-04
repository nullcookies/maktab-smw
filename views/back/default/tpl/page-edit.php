<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit page');?>
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
    
        <form id="page-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$page['id']?>" />
            <input type="hidden" name="alias_id" id="alias_id" value="<?=$page['alias_id']?>" />
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group<?php if($errors['name'][$l_key]) { ?> has-error<?php } ?>">
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('page name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?=$page['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group<?php if($errors['text_name'][$l_key]) { ?> has-error<?php } ?>">
                                <label for="text_name<?=$l_key?>"><?=$this->getTranslation('page text name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="text_name[<?=$l_key?>]" id="text_name<?=$l_key?>" value="<?= $page['text_name'][$l_key]; ?>" />
                                <?php if($errors['text_name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['text_name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group<?php if($errors['nav_name'][$l_key]) { ?> has-error<?php } ?>">
                                <label for="nav_name<?=$l_key?>"><?=$this->getTranslation('page nav name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="nav_name[<?=$l_key?>]" id="nav_name<?=$l_key?>" value="<?= $page['nav_name'][$l_key]; ?>" />
                                <?php if($errors['nav_name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['nav_name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div style="display:none;" class="form-group">
                                <label for="descr<?=$l_key?>"><?=$this->getTranslation('descr short')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ck-editor" name="descr[<?=$l_key?>]" id="descr<?=$l_key?>"><?=$page['descr'][$l_key]?></textarea>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr_full<?=$l_key?>"><?=$this->getTranslation('descr full')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ck-editor"  name="descr_full[<?=$l_key?>]" id="descr_full<?=$l_key?>"><?=$page['descr_full'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status"><?=$this->getTranslation('status');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($page['status']) echo " checked "; ?> />
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['alias']) { ?>has-error<?php } ?>">
                                <label for="alias">
                                    <?=$this->getTranslation('alias name')?>
                                </label>
                                <input type="text" class="form-control" name="alias" id="alias" value="<?=$page['alias']; ?>" />
                                <?php if($errors['alias']) { ?><div class="help-block"><?=$this->getTranslation($errors['alias'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['controller']) { ?>has-error<?php } ?>">
                                <label for="controller">
                                    <?=$this->getTranslation('controller')?>
                                </label>
                                <input readonly type="text" class="form-control" name="controller" id="controller" value="<?= ($page['controller']) ? $page['controller'] : 'information' ?>" />
                                <?php if($errors['controller']) { ?><div class="help-block"><?=$this->getTranslation($errors['controller'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['method']) { ?>has-error<?php } ?>">
                                <label for="method">
                                    <?=$this->getTranslation('method')?>
                                </label>
                                <input readonly type="text" class="form-control" name="method" id="method" value="<?= ($page['method']) ? $page['method'] : 'view' ?>" />
                                <?php if($errors['method']) { ?><div class="help-block"><?=$this->getTranslation($errors['method'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['side']) { ?>has-error<?php } ?>">
                                <label for="side">
                                    <?=$this->getTranslation('side')?>
                                </label>
                                <input readonly type="text" class="form-control" name="side" id="side" value="<?= $page['side']; ?>" />
                                <?php if($errors['side']) { ?><div class="help-block"><?=$this->getTranslation($errors['side'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['layout']) { ?>has-error<?php } ?>">
                                <label for="layout">
                                    <?=$this->getTranslation('layout')?>
                                </label>
                                <input readonly type="text" class="form-control" name="layout" id="layout" value="<?= $page['layout']; ?>" />
                                <?php if($errors['layout']) { ?><div class="help-block"><?=$this->getTranslation($errors['layout'])?></div><?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info collapse-box collapsed-box">
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
                        <input type="text" class="form-control"  name="meta_t[<?=$l_key?>]" id="meta_t<?=$l_key?>" value="<?=$page['meta_t'][$l_key]; ?>" />
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_d<?=$l_key?>">Meta description (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_d[<?=$l_key?>]" id="meta_d<?=$l_key?>"><?=$page['meta_d'][$l_key]; ?></textarea>
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_k<?=$l_key?>">Meta keywords (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_k[<?=$l_key?>]" id="meta_k<?=$l_key?>"><?=$page['meta_k'][$l_key]; ?></textarea>
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
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        