<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit slide');?>
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
    
        <form id="slide-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$slide['id']?>" />
            
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
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('slide name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?=$slide['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="url<?=$l_key?>"><?=$this->getTranslation('url')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="url[<?=$l_key?>]" id="url<?=$l_key?>" value="<?=$slide['url'][$l_key]; ?>" />
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr_full<?=$l_key?>"><?=$this->getTranslation('descr full')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ck-editor"  name="descr_full[<?=$l_key?>]" id="descr_full<?=$l_key?>"><?=$slide['descr_full'][$l_key]; ?></textarea>
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
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($slide['status']) echo " checked "; ?> />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="sort_number"><?=$this->getTranslation('sorting')?></label>
                                <input type="text" class="form-control" name="sort_number" id="sort_number" value="<?=$slide['sort_number']; ?>" />
                            </div>
                            <div class="form-group">
                                <div class="current-image">
                                    <img src="<?=$slide['icon']?>?rand=<?=mt_rand(1, 999)?>" alt="<?=$slide['name'][LANG_ID]?>">
                                    <input type="hidden" name="image" value="<?=$slide['image']?>">
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['image']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('upload image')?></label>
                                <input class="image-fileinput" type="file" name="image" />
                                <?php if($errors['image']) { ?><div class="help-block"><?=$this->getTranslation($errors['image'])?></div><?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

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

        