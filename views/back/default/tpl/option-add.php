<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('add option', 'back')?>
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
        
        <form id="option-add-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->t('btn back', 'back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->t('btn save', 'back')?>
                </button>
                <input type="hidden" name="btn_add" value="<?=$this->t('btn save', 'back')?>" />
            </div>

            <div class="box box-success">
                <div class="box-body">
                    <div class="form-group<?php if(!empty($errors['name'])) { ?> has-error<?php } ?>">
                        <label for="name"><?=$this->t('option name', 'back')?></label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($option['name'])){ echo $option['name']; } ?>" />
                        <?php if(!empty($errors['name'])) { ?>
                            <div class="help-block"><?=$this->t($errors['name'], 'back')?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group<?php if(!empty($errors['content'])) { ?> has-error<?php } ?>">
                        <label for="option-content"><?=$this->t('option content', 'back')?></label>
                        <input type="text" class="form-control" name="content" id="option-content" value="<?php if(!empty($option['content'])){ echo $option['content']; } ?>" />
                        <?php if(!empty($errors['content'])) { ?>
                            <div class="help-block"><?=$this->t($errors['content'], 'back')?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group<?php if(!empty($errors['comment'])) { ?> has-error<?php } ?>">
                        <label for="option-comment"><?=$this->t('option comment', 'back')?></label>
                        <input type="text" class="form-control" name="comment" id="comment" value="<?php if(!empty($option['comment'])){ echo $option['comment']; } ?>" />
                        <?php if(!empty($errors['comment'])) { ?>
                            <div class="help-block"><?=$this->t($errors['comment'], 'back')?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->t('btn back', 'back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->t('btn save', 'back')?>
                </button>
                <input type="hidden" name="btn_add" value="<?=$this->t('btn save', 'back')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        