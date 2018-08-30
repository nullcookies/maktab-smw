<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('view user', 'back');?>
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
    
        <form action="<?=$controls['view']?>" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="user[id]" value="<?=$user->id?>" />
            
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

                            <div class="form-group <?php if(!empty($errors['username'])) { ?>has-error<?php } ?>">
                                <label for="username">
                                    <?=$this->t('username', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="user[username]" id="username" value="<?= $user->username; ?>" />
                                <?php if(!empty($errors['username'])) { ?><div class="help-block"><?=$this->t($errors['username'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['password'])) { ?>has-error<?php } ?>">
                                <label for="password">
                                    <?=$this->t('password', 'back')?>
                                    <?php if(!$user->id): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?>
                                </label>
                                <input type="password" class="form-control" name="user[password]" id="password" value="" />
                                <?php if(!empty($errors['password'])) { ?><div class="help-block"><?=$this->t($errors['password'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['email'])) { ?>has-error<?php } ?>">
                                <label for="email">
                                    <?=$this->t('email', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="user[email]" id="email" value="<?= $user->email; ?>" />
                                <?php if(!empty($errors['email'])) { ?><div class="help-block"><?=$this->t($errors['email'], 'back')?></div><?php } ?>
                            </div>
                            
                            <div class="form-group <?php if(!empty($errors['usergroup'])) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('user type')?></label>
                                <select name="user[usergroup]" class="form-control selectpicker">
                                    <?php if($usergroups){ ?>
                                    <?php foreach($usergroups as $value){ ?>
                                    <option value="<?=$value?>" <?php if($value == $user->usergroup){ ?>selected<?php } ?> ><?=$this->t('usergroup ' . $value, 'back')?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if(!empty($errors['usergroup'])) { ?><div class="help-block"><?=$this->t($errors['usergroup'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['phone'])) { ?>has-error<?php } ?>">
                                <label for="phone">
                                    <?=$this->t('phone', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="user[phone]" id="phone" value="<?= $user->phone; ?>" />
                                <?php if(!empty($errors['phone'])) { ?><div class="help-block"><?=$this->t($errors['phone'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['address'])) { ?>has-error<?php } ?>">
                                <label for="address">
                                    <?=$this->t('address', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="user[address]" id="address" value="<?= $user->address; ?>" />
                                <?php if(!empty($errors['address'])) { ?><div class="help-block"><?=$this->t($errors['address'], 'back')?></div><?php } ?>
                            </div>

                            



                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">

                            <div class="form-group <?php if(!empty($errors['lastname'])) { ?>has-error<?php } ?>">
                                <label for="lastname">
                                    <?=$this->t('lastname', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="user[lastname]" id="lastname" value="<?= $user->lastname; ?>" />
                                <?php if(!empty($errors['lastname'])) { ?><div class="help-block"><?=$this->t($errors['lastname'], 'back')?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if(!empty($errors['firstname'])) { ?>has-error<?php } ?>">
                                <label for="firstname">
                                    <?=$this->t('firstname', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="user[firstname]" id="firstname" value="<?= $user->firstname; ?>" />
                                <?php if(!empty($errors['firstname'])) { ?><div class="help-block"><?=$this->t($errors['firstname'], 'back')?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if(!empty($errors['middlename'])) { ?>has-error<?php } ?>">
                                <label for="middlename">
                                    <?=$this->t('middlename', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="user[middlename]" id="middlename" value="<?= $user->middlename; ?>" />
                                <?php if(!empty($errors['middlename'])) { ?><div class="help-block"><?=$this->t($errors['middlename'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['date_birth'])) { ?>has-error<?php } ?>">
                                <label for="date_birth">
                                    <?=$this->t('birthday', 'back')?>
                                </label>
                                <input type="text" class="form-control datepicker" name="user[date_birth]" id="date_birth" value="<?=$user->date_birth?>" />
                                <?php if(!empty($errors['date_birth'])) { ?><div class="help-block"><?=$this->t($errors['date_birth'], 'back')?></div><?php } ?>
                            </div>
                            
                            <div class="form-group">
                                <div class="current-image">
                                    <img src="<?=$user->icon?>?rand=<?=mt_rand(1, 999)?>" alt="<?=$user->firstname?>">
                                    <input type="hidden" name="user[image]" value="<?=$user->image?>">
                                </div>
                            </div>
                            <div class="form-group <?php if(!empty($errors['image'])) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->t('upload avatar', 'back')?></label>
                                <input class="image-fileinput" type="file" name="image" multiple/>
                                <?php if(!empty($errors['image'])) { ?><div class="help-block"><?=$this->t($errors['image'], 'back')?></div><?php } ?>
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

        