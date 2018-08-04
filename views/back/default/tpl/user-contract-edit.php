<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit usercontract');?>
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
    
        <form id="usercontract-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$usercontract['id']?>" />
            
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
                            <div class="form-group <?php if($errors['user_id']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('user')?></label>
                                <select name="user_id" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($users){ ?>
                                    <?php foreach($users as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if($value['id'] == $usercontract['user_id']){ ?>selected<?php } ?> ><?=$value['company_name']?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['user_id']) { ?><div class="help-block"><?=$this->getTranslation($errors['user_id'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['contract_year']) { ?>has-error<?php } ?>">
                                <label for="contract_year"><?=$this->getTranslation('contract year')?></label>
                                <input type="text" class="form-control" name="contract_year" id="contract_year" value="<?= $usercontract['contract_year']; ?>" />
                                <?php if($errors['contract_year']) { ?><div class="help-block"><?=$this->getTranslation($errors['contract_year'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['contract_number']) { ?>has-error<?php } ?>">
                                <label for="contract_number"><?=$this->getTranslation('contract number')?></label>
                                <input type="text" class="form-control" name="contract_number" id="contract_number" value="<?= $usercontract['contract_number']; ?>" />
                                <?php if($errors['contract_number']) { ?><div class="help-block"><?=$this->getTranslation($errors['contract_number'])?></div><?php } ?>
                            </div>

                            <?php if($categories){ ?>
                            <?php foreach($categories as $value){ ?>
                            <div class="form-group">
                                <div class="form-group <?php if($errors['contract_number']) { ?>has-error<?php } ?>">
                                    <label for="contract_number"><?=$value['name'][LANG_ID]?></label>
                                    <div class="input-group">
                                        <input type="text" name="price[<?=$value['id']?>]" id="price<?=$value['id']?>" class="form-control" value="<?=$usercontract['price'][$value['id']]?>">
                                        <span class="input-group-addon">
                                            <?=$this->translation($this->getOption('currency'))?>/<?=$this->getTranslation('unit_dal')?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <?php if($categories){ ?>
                            <?php foreach($categories as $value){ ?>
                            <div class="form-group">
                                <label class="control-label" for=""><?=$value['name'][LANG_ID]?></label>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="quarter_1_<?=$value['id']?>">
                                            <i style="font-weight: normal"><?=$this->getTranslation('quarter')?> 1</i>
                                        </label>
                                        <div class="input-group" style="margin-bottom: 10px;">
                                            <input type="text" name="quarter_1[<?=$value['id']?>]" id="quarter_1_<?=$value['id']?>" class="form-control" value="<?=$usercontract['quarter_1'][$value['id']]?>">
                                            <span class="input-group-addon">
                                                <?=$this->getTranslation('unit_dal')?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="quarter_2_<?=$value['id']?>">
                                            <i style="font-weight: normal"><?=$this->getTranslation('quarter')?> 2</i>
                                        </label>
                                        <div class="input-group" style="margin-bottom: 10px;">
                                            <input type="text" name="quarter_2[<?=$value['id']?>]" id="quarter_2_<?=$value['id']?>" class="form-control" value="<?=$usercontract['quarter_2'][$value['id']]?>">
                                            <span class="input-group-addon">
                                                <?=$this->getTranslation('unit_dal')?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="quarter_3_<?=$value['id']?>">
                                            <i style="font-weight: normal"><?=$this->getTranslation('quarter')?> 3</i>
                                        </label>
                                        <div class="input-group" style="margin-bottom: 10px;">
                                            <input type="text" name="quarter_3[<?=$value['id']?>]" id="quarter_3_<?=$value['id']?>" class="form-control" value="<?=$usercontract['quarter_3'][$value['id']]?>">
                                            <span class="input-group-addon">
                                                <?=$this->getTranslation('unit_dal')?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="quarter_4_<?=$value['id']?>">
                                            <i style="font-weight: normal"><?=$this->getTranslation('quarter')?> 4</i>
                                        </label>
                                        <div class="input-group" style="margin-bottom: 10px;">
                                            <input type="text" name="quarter_4[<?=$value['id']?>]" id="quarter_4_<?=$value['id']?>" class="form-control" value="<?=$usercontract['quarter_4'][$value['id']]?>">
                                            <span class="input-group-addon">
                                                <?=$this->getTranslation('unit_dal')?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>

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

        