<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit review');?>
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
    
        <form id="review-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$review['id']?>" />
            <input type="hidden" name="product_id" id="product_id" value="<?=$review['product_id']?>" />
            
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
                                <label for="name"><?=$this->getTranslation('reviewer name')?></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?=$review['name']; ?>" />
                                <?php if($errors['name']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group<?php if($errors['email']) { ?> has-error<?php } ?>">
                                <label for="email"><?=$this->getTranslation('email')?></label>
                                <input type="text" class="form-control" name="email" id="email" value="<?=$review['email']; ?>" />
                                <?php if($errors['email']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['email'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group<?php if($errors['message']) { ?> has-error<?php } ?>">
                                <label for="message"><?=$this->getTranslation('message')?></label>
                                <textarea class="form-control"  name="message" id="message"><?=$review['message']; ?></textarea>
                                <?php if($errors['message']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['message'])?></div>
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
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($review['status']) echo " checked "; ?> />
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

        