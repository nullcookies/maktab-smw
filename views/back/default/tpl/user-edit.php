<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit user');?>
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
    
        <form id="user-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?=$user['id']?>" />
            
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
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="form-group <?php if($errors['username']) { ?>has-error<?php } ?>">
                                <label for="username">
                                    <?=$this->getTranslation('username')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="username" id="username" value="<?= $user['username']; ?>" />
                                <?php if($errors['username']) { ?><div class="help-block"><?=$this->getTranslation($errors['username'])?></div><?php } ?>
                            </div>
                            <!-- <input type="password" class="form-control" name="password" id="password" value="" /> -->
                            <div class="form-group <?php if($errors['new_password']) { ?>has-error<?php } ?>">
                                <label for="new_password">
                                    <?=$this->getTranslation('new password')?>
                                </label>
                                <input type="password" class="form-control" name="new_password" id="new_password" value="<?= $user['new_password']; ?>" />
                                <?php if($errors['new_password']) { ?><div class="help-block"><?=$this->getTranslation($errors['new_password'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['email']) { ?>has-error<?php } ?>">
                                <label for="email">
                                    <?=$this->getTranslation('email')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="email" id="email" value="<?= $user['email']; ?>" />
                                <?php if($errors['email']) { ?><div class="help-block"><?=$this->getTranslation($errors['email'])?></div><?php } ?>
                            </div>
                            
                            <div class="form-group <?php if($errors['usergroup']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('user type')?></label>
                                <select name="usergroup" class="form-control selectpicker">
                                    <?php if($usergroups){ ?>
                                    <?php foreach($usergroups as $value){ ?>
                                    <option value="<?=$value?>" <?php if($value == $user['usergroup']){ ?>selected<?php } ?> ><?=$this->getTranslation('usergroup ' . $value)?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['usergroup']) { ?><div class="help-block"><?=$this->getTranslation($errors['usergroup'])?></div><?php } ?>
                            </div>

                            
                            
                            <?php /*
                            <div class="form-group <?php if($errors['name']) { ?>has-error<?php } ?>">
                                <label for="name">
                                    <?=$this->getTranslation('user name')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="name" id="name" value="<?= $user['name']; ?>" />
                                <?php if($errors['name']) { ?><div class="help-block"><?=$this->getTranslation($errors['name'])?></div><?php } ?>
                            </div>
                            */ ?>
                            
                            <div class="form-group">
                                <div class="current-image">
                                    <img src="<?=$user['icon']?>?rand=<?=mt_rand(1, 999)?>" alt="<?=$user['name']?>">
                                    <input type="hidden" name="image" value="<?=$user['image']?>">
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['image']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('upload avatar')?></label>
                                <input class="image-fileinput" type="file" name="image" />
                                <?php if($errors['image']) { ?><div class="help-block"><?=$this->getTranslation($errors['image'])?></div><?php } ?>
                            </div>

                            



                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">

                            <div class="form-group <?php if($errors['lastname']) { ?>has-error<?php } ?>">
                                <label for="lastname">
                                    <?=$this->getTranslation('lastname')?>
                                </label>
                                <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $user['lastname']; ?>" />
                                <?php if($errors['lastname']) { ?><div class="help-block"><?=$this->getTranslation($errors['lastname'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['firstname']) { ?>has-error<?php } ?>">
                                <label for="firstname">
                                    <?=$this->getTranslation('firstname')?>
                                </label>
                                <input type="text" class="form-control" name="firstname" id="firstname" value="<?= $user['firstname']; ?>" />
                                <?php if($errors['firstname']) { ?><div class="help-block"><?=$this->getTranslation($errors['firstname'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['middlename']) { ?>has-error<?php } ?>">
                                <label for="middlename">
                                    <?=$this->getTranslation('middlename')?>
                                </label>
                                <input type="text" class="form-control" name="middlename" id="middlename" value="<?= $user['middlename']; ?>" />
                                <?php if($errors['middlename']) { ?><div class="help-block"><?=$this->getTranslation($errors['middlename'])?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['phone']) { ?>has-error<?php } ?>">
                                <label for="phone">
                                    <?=$this->getTranslation('phone')?>
                                </label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?= $user['phone']; ?>" />
                                <?php if($errors['phone']) { ?><div class="help-block"><?=$this->getTranslation($errors['phone'])?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['address']) { ?>has-error<?php } ?>">
                                <label for="address">
                                    <?=$this->getTranslation('address')?>
                                </label>
                                <input type="text" class="form-control" name="address" id="address" value="<?= $user['address']; ?>" />
                                <?php if($errors['address']) { ?><div class="help-block"><?=$this->getTranslation($errors['address'])?></div><?php } ?>
                            </div>

                            <?php /* OOO baza
                            <div class="form-group <?php if($errors['company_name']) { ?>has-error<?php } ?>">
                                <label for="company_name">
                                    <?=$this->getTranslation('company name')?>
                                </label>
                                <input type="text" class="form-control" name="company_name" id="company_name" value="<?= $user['company_name']; ?>" />
                                <?php if($errors['company_name']) { ?><div class="help-block"><?=$this->getTranslation($errors['company_name'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['balance']) { ?>has-error<?php } ?>">
                                <label for="balance">
                                    <?=$this->getTranslation('user balance')?>
                                </label>
                                <input type="text" class="form-control" name="balance" id="balance" value="<?= $user['balance']; ?>" />
                                <?php if($errors['balance']) { ?><div class="help-block"><?=$this->getTranslation($errors['balance'])?></div><?php } ?>
                            </div>

                            <!-- requisites -->
                            <div class="form-group <?php if($errors['bank_name']) { ?>has-error<?php } ?>">
                                <label for="bank_name">
                                    <?=$this->getTranslation('bank name')?>
                                </label>
                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?= $user['bank_name']; ?>" />
                                <?php if($errors['bank_name']) { ?><div class="help-block"><?=$this->getTranslation($errors['bank_name'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['checking_account']) { ?>has-error<?php } ?>">
                                <label for="checking_account">
                                    <?=$this->getTranslation('checking account')?>
                                </label>
                                <input type="text" class="form-control" name="checking_account" id="checking_account" value="<?= $user['checking_account']; ?>" />
                                <?php if($errors['checking_account']) { ?><div class="help-block"><?=$this->getTranslation($errors['checking_account'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['mfo']) { ?>has-error<?php } ?>">
                                <label for="mfo">
                                    <?=$this->getTranslation('mfo')?>
                                </label>
                                <input type="text" class="form-control" name="mfo" id="mfo" value="<?= $user['mfo']; ?>" />
                                <?php if($errors['mfo']) { ?><div class="help-block"><?=$this->getTranslation($errors['mfo'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['inn']) { ?>has-error<?php } ?>">
                                <label for="inn">
                                    <?=$this->getTranslation('inn')?>
                                </label>
                                <input type="text" class="form-control" name="inn" id="inn" value="<?= $user['inn']; ?>" />
                                <?php if($errors['inn']) { ?><div class="help-block"><?=$this->getTranslation($errors['inn'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['okonx']) { ?>has-error<?php } ?>">
                                <label for="okonx">
                                    <?=$this->getTranslation('okonx')?>
                                </label>
                                <input type="text" class="form-control" name="okonx" id="okonx" value="<?= $user['okonx']; ?>" />
                                <?php if($errors['okonx']) { ?><div class="help-block"><?=$this->getTranslation($errors['okonx'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['address_jur']) { ?>has-error<?php } ?>">
                                <label for="address_jur">
                                    <?=$this->getTranslation('address jur')?>
                                </label>
                                <input type="text" class="form-control" name="address_jur" id="address_jur" value="<?= $user['address_jur']; ?>" />
                                <?php if($errors['address_jur']) { ?><div class="help-block"><?=$this->getTranslation($errors['address_jur'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['address_phy']) { ?>has-error<?php } ?>">
                                <label for="address_phy">
                                    <?=$this->getTranslation('address phy')?>
                                </label>
                                <input type="text" class="form-control" name="address_phy" id="address_phy" value="<?= $user['address_phy']; ?>" />
                                <?php if($errors['address_phy']) { ?><div class="help-block"><?=$this->getTranslation($errors['address_phy'])?></div><?php } ?>
                            </div>
                            <!-- requisites -->

                            <div class="form-group <?php if($errors['contract_number']) { ?>has-error<?php } ?>">
                                <label for="contract_number">
                                    <?=$this->getTranslation('contract number')?>
                                </label>
                                <input type="text" class="form-control" name="contract_number" id="contract_number" value="<?= $user['contract_number']; ?>" />
                                <?php if($errors['contract_number']) { ?><div class="help-block"><?=$this->getTranslation($errors['contract_number'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['contract_date_start']) { ?>has-error<?php } ?>">
                                <label for="contract_date_start">
                                    <?=$this->getTranslation('contract date start')?>
                                </label>
                                <input type="text" class="form-control datepicker" name="contract_date_start" id="contract_date_start" value="<?= $user['contract_date_start']; ?>" />
                                <?php if($errors['contract_date_start']) { ?><div class="help-block"><?=$this->getTranslation($errors['contract_date_start'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['contract_date_end']) { ?>has-error<?php } ?>">
                                <label for="contract_date_end">
                                    <?=$this->getTranslation('contract date end')?>
                                </label>
                                <input type="text" class="form-control datepicker" name="contract_date_end" id="contract_date_end" value="<?= $user['contract_date_end']; ?>" />
                                <?php if($errors['contract_date_end']) { ?><div class="help-block"><?=$this->getTranslation($errors['contract_date_end'])?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if($errors['license_number']) { ?>has-error<?php } ?>">
                                <label for="license_number">
                                    <?=$this->getTranslation('license number')?>
                                </label>
                                <input type="text" class="form-control" name="license_number" id="license_number" value="<?= $user['license_number']; ?>" />
                                <?php if($errors['license_number']) { ?><div class="help-block"><?=$this->getTranslation($errors['license_number'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['license_date_end']) { ?>has-error<?php } ?>">
                                <label for="license_date_end">
                                    <?=$this->getTranslation('license date end')?>
                                </label>
                                <input type="text" class="form-control datepicker" name="license_date_end" id="license_date_end" value="<?= $user['license_date_end']; ?>" />
                                <?php if($errors['license_date_end']) { ?><div class="help-block"><?=$this->getTranslation($errors['license_date_end'])?></div><?php } ?>
                            </div>
                            */ ?>
                            
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

        