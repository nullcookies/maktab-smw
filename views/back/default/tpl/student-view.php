<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('view student', 'back');?>
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
            
            <input type="hidden" name="student[id]" value="<?=$student->id?>" />
            
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
                                <input type="text" class="form-control" name="student[username]" id="username" value="<?= $student->username; ?>" />
                                <?php if(!empty($errors['username'])) { ?><div class="help-block"><?=$this->t($errors['username'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['password'])) { ?>has-error<?php } ?>">
                                <label for="password">
                                    <?=$this->t('password', 'back')?>
                                    <?php if(!$student->id): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?>
                                </label>
                                <input type="password" class="form-control" name="student[password]" id="password" value="" />
                                <?php if(!empty($errors['password'])) { ?><div class="help-block"><?=$this->t($errors['password'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['group_id'])) { ?>has-error<?php } ?>">
                                <label for="group_id">
                                    <?=$this->t('student group', 'back')?>
                                </label>
                                <select name="group_id" id="group_id" class="form-control selectpicker">
                                    <option value="">-</option>
                                    <?php foreach($groups as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if(!empty($student->group_id) && $student->group_id == $value['id']){ ?>selected<?php } ?>><?=$value['grade'] . ' - ' . $value['name']?> (<?=$value['start_year']?> - <?=$value['end_year']?>)</option>
                                    <?php } ?>
                                </select>
                                <?php if(!empty($errors['group_id'])) { ?><div class="help-block"><?=$this->t($errors['group_id'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['email'])) { ?>has-error<?php } ?>">
                                <label for="email">
                                    <?=$this->t('email', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="student[email]" id="email" value="<?= $student->email; ?>" />
                                <?php if(!empty($errors['email'])) { ?><div class="help-block"><?=$this->t($errors['email'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['phone'])) { ?>has-error<?php } ?>">
                                <label for="phone">
                                    <?=$this->t('phone', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="student[phone]" id="phone" value="<?= $student->phone; ?>" />
                                <?php if(!empty($errors['phone'])) { ?><div class="help-block"><?=$this->t($errors['phone'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['address'])) { ?>has-error<?php } ?>">
                                <label for="address">
                                    <?=$this->t('address', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="student[address]" id="address" value="<?= $student->address; ?>" />
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
                                <input type="text" class="form-control" name="student[lastname]" id="lastname" value="<?= $student->lastname; ?>" />
                                <?php if(!empty($errors['lastname'])) { ?><div class="help-block"><?=$this->t($errors['lastname'], 'back')?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if(!empty($errors['firstname'])) { ?>has-error<?php } ?>">
                                <label for="firstname">
                                    <?=$this->t('firstname', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="student[firstname]" id="firstname" value="<?= $student->firstname; ?>" />
                                <?php if(!empty($errors['firstname'])) { ?><div class="help-block"><?=$this->t($errors['firstname'], 'back')?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if(!empty($errors['middlename'])) { ?>has-error<?php } ?>">
                                <label for="middlename">
                                    <?=$this->t('middlename', 'back')?>
                                </label>
                                <input type="text" class="form-control" name="student[middlename]" id="middlename" value="<?= $student->middlename; ?>" />
                                <?php if(!empty($errors['middlename'])) { ?><div class="help-block"><?=$this->t($errors['middlename'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['date_birth'])) { ?>has-error<?php } ?>">
                                <label for="date_birth">
                                    <?=$this->t('birthday', 'back')?>
                                </label>
                                <input type="text" class="form-control datepicker" name="student[date_birth]" id="date_birth" value="<?=$student->date_birth?>" />
                                <?php if(!empty($errors['date_birth'])) { ?><div class="help-block"><?=$this->t($errors['date_birth'], 'back')?></div><?php } ?>
                            </div>
                            
                            <div class="form-group">
                                <div class="current-image">
                                    <img src="<?=$student->icon?>?rand=<?=mt_rand(1, 999)?>" alt="<?=$student->firstname?>">
                                    <input type="hidden" name="student[image]" value="<?=$student->image?>">
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

        