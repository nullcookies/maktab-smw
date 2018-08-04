<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit coupon');?>
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
    
        <form id="coupon-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$coupon['id']?>" />
            
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
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('coupon name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?= $coupon['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr<?=$l_key?>"><?=$this->getTranslation('descr short')?> (<?=$l_value?>)</label>
                                <textarea class="form-control" name="descr[<?=$l_key?>]" id="descr<?=$l_key?>"><?= $coupon['descr'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>

                            <div class="form-group<?php if($errors['coupon_code']) { ?> has-error<?php } ?>">
                                <label for="coupon_code"><?=$this->getTranslation('coupon code')?></label>
                                <input type="text" class="form-control " name="coupon_code" id="coupon_code" value="<?= $coupon['coupon_code']; ?>" />
                                <?php if($errors['coupon_code']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['coupon_code'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group<?php if($errors['coupon_type']) { ?> has-error<?php } ?>">
                                <label for="coupon_type"><?=$this->getTranslation('coupon type')?></label>
                                <select name="coupon_type" id="coupon_type" class="form-control">
                                    <?php foreach($couponTypes as $couponType){ ?>
                                    <option value="<?=$couponType?>" <?php if($couponType == $coupon['coupon_type']){ ?>selected<?php } ?>><?=$this->getTranslation('coupon type ' . $couponType)?></option>
                                    <?php } ?>
                                </select>
                                <?php if($errors['coupon_type']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['coupon_type'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group<?php if($errors['coupon_value']) { ?> has-error<?php } ?>">
                                <label for="coupon_value"><?=$this->getTranslation('coupon value')?></label>
                                <input type="text" class="form-control" name="coupon_value" id="coupon_value" value="<?= $coupon['coupon_value']; ?>" />
                                <?php if($errors['coupon_value']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['coupon_value'])?></div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status"><?=$this->getTranslation('status');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($coupon['status']) echo " checked "; ?> />
                                </div>
                            </div>

                            <div class="form-group<?php if($errors['min_price']) { ?> has-error<?php } ?>">
                                <label for="min_price"><?=$this->getTranslation('min order price')?></label>
                                <input type="text" class="form-control" name="min_price" id="min_price" value="<?= $coupon['min_price']; ?>" />
                                <?php if($errors['min_price']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['min_price'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group<?php if($errors['date_start']) { ?> has-error<?php } ?>">
                                <label for="date_start"><?=$this->getTranslation('coupon date start')?></label>
                                <input type="text" class="form-control datepicker" name="date_start" id="date_start" value="<?=$coupon['date_start']?>" />
                                <?php if($errors['date_start']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['date_start'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group<?php if($errors['date_end']) { ?> has-error<?php } ?>">
                                <label for="date_end"><?=$this->getTranslation('coupon date end')?></label>
                                <input type="text" class="form-control datepicker" name="date_end" id="date_end" value="<?=$coupon['date_end']?>" />
                                <?php if($errors['date_end']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['date_end'])?></div>
                                <?php } ?>
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

        