<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('view teacher', 'back');?>
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
    
        <form action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="teacher[id]" value="<?=$teacher->id?>" />
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->t('btn back', 'back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->t('btn save', 'back')?>
                </button>
                <input type="hidden" name="btn_save" value="<?=$this->t('btn save', 'back')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">

                            <div class="form-group <?php if($errors['username']) { ?>has-error<?php } ?>">
                                <label for="username">
                                    <?=$this->t('username', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="teacher[username]" id="username" value="<?= $teacher->username; ?>" />
                                <?php if($errors['username']) { ?><div class="help-block"><?=$this->t($errors['username'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['email']) { ?>has-error<?php } ?>">
                                <label for="email">
                                    <?=$this->t('email', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="teacher[email]" id="email" value="<?= $teacher->email; ?>" />
                                <?php if($errors['email']) { ?><div class="help-block"><?=$this->t($errors['email'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['password']) { ?>has-error<?php } ?>">
                                <label for="password">
                                    <?=$this->t('password', 'back')?>
                                    <?php if(!$teacher->id): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?>
                                </label>
                                <input type="password" class="form-control" name="teacher[password]" id="password" value="" />
                                <?php if($errors['password']) { ?><div class="help-block"><?=$this->t($errors['password'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['phone']) { ?>has-error<?php } ?>">
                                <label for="phone">
                                    <?=$this->t('phone', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="teacher[phone]" id="phone" value="<?= $teacher->phone; ?>" />
                                <?php if($errors['phone']) { ?><div class="help-block"><?=$this->t($errors['phone'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['address']) { ?>has-error<?php } ?>">
                                <label for="address">
                                    <?=$this->t('address', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="teacher[address]" id="address" value="<?= $teacher->address; ?>" />
                                <?php if($errors['address']) { ?><div class="help-block"><?=$this->t($errors['address'], 'back')?></div><?php } ?>
                            </div>

                            



                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">

                            <div class="form-group <?php if($errors['lastname']) { ?>has-error<?php } ?>">
                                <label for="lastname">
                                    <?=$this->t('lastname', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="teacher[lastname]" id="lastname" value="<?= $teacher->lastname; ?>" />
                                <?php if($errors['lastname']) { ?><div class="help-block"><?=$this->t($errors['lastname'], 'back')?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['firstname']) { ?>has-error<?php } ?>">
                                <label for="firstname">
                                    <?=$this->t('firstname', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="teacher[firstname]" id="firstname" value="<?= $teacher->firstname; ?>" />
                                <?php if($errors['firstname']) { ?><div class="help-block"><?=$this->t($errors['firstname'], 'back')?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['middlename']) { ?>has-error<?php } ?>">
                                <label for="middlename">
                                    <?=$this->t('middlename', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="teacher[middlename]" id="middlename" value="<?= $teacher->middlename; ?>" />
                                <?php if($errors['middlename']) { ?><div class="help-block"><?=$this->t($errors['middlename'], 'back')?></div><?php } ?>
                            </div>
                            
                            <div class="form-group">
                                <div class="current-image">
                                    <img src="<?=$teacher->icon?>?rand=<?=mt_rand(1, 999)?>" alt="<?=$teacher->firstname?>">
                                    <input type="hidden" name="teacher[image]" value="<?=$teacher->image?>">
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['image']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->t('upload avatar', 'back')?></label>
                                <input class="image-fileinput" type="file" name="image" multiple/>
                                <?php if($errors['image']) { ?><div class="help-block"><?=$this->t($errors['image'], 'back')?></div><?php } ?>
                            </div>

                            

                        </div>
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
                <input type="hidden" name="btn_save" value="<?=$this->t('btn save', 'back')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        