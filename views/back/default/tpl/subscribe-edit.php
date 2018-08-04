<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit subscribe');?>
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
    
        <form id="subscribe-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$subscribe['id']?>" />
            
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
                            <div class="form-group<?php if($errors['name']) { ?> has-error<?php } ?>">
                                <label for="name"><?=$this->getTranslation('subscribe name')?></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?=$subscribe['name']?>" />
                                <?php if($errors['name']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'])?></div>
                                <?php } ?>
                            </div>
                            <div class="form-group<?php if($errors['email']) { ?> has-error<?php } ?>">
                                <label for="email"><?=$this->getTranslation('email')?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" id="email" value="<?=$subscribe['email']?>" />
                                <?php if($errors['email']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['email'])?></div>
                                <?php } ?>
                            </div>
                            <div class="form-group<?php if($errors['phone']) { ?> has-error<?php } ?>">
                                <label for="phone"><?=$this->getTranslation('phone')?></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?=$subscribe['phone']?>" />
                                <?php if($errors['phone']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['phone'])?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status"><?=$this->getTranslation('status');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($subscribe['status']) echo " checked "; ?> />
                                </div>
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

        