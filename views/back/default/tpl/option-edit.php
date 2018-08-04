<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit option');?>
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
    
        <form id="option-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$option['id']?>" />
            
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

            <div class="box box-info">
                <div class="box-body">
                    <div class="form-group<?php if($errors['name']) { ?> has-error<?php } ?>">
                        <label for="name"><?=$this->getTranslation('option name')?></label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= $option['name']; ?>" />
                        <?php if($errors['name']) { ?>
                            <div class="help-block"><?=$this->getTranslation($errors['name'])?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group<?php if($errors['content']) { ?> has-error<?php } ?>">
                        <label for="option-content"><?=$this->getTranslation('option content')?></label>
                        <input type="text" class="form-control" name="content" id="option-content" value="<?= $option['content']; ?>" />
                        <?php if($errors['content']) { ?>
                            <div class="help-block"><?=$this->getTranslation($errors['content'])?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group<?php if($errors['comment']) { ?> has-error<?php } ?>">
                        <label for="option-comment"><?=$this->getTranslation('option comment')?></label>
                        <input type="text" class="form-control" name="comment" id="comment" value="<?= $option['comment']; ?>" />
                        <?php if($errors['comment']) { ?>
                            <div class="help-block"><?=$this->getTranslation($errors['comment'])?></div>
                        <?php } ?>
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

        