<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('view group', 'back');?>
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
            
            <input type="hidden" name="group[id]" value="<?=$group->id?>" />
            
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

                            <div class="form-group <?php if(!empty($errors['name'])) { ?>has-error<?php } ?>">
                                <label for="name">
                                    <?=$this->t('group name', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="group[name]" id="name" value="<?= $group->name; ?>" />
                                <?php if(!empty($errors['name'])) { ?><div class="help-block"><?=$this->t($errors['name'], 'back')?></div><?php } ?>
                            </div>

                            <?php
                                $firstCountYear = 2007;
                            ?>

                            <div class="form-group <?php if(!empty($errors['start_year'])) { ?>has-error<?php } ?>">
                                <label for="start_year">
                                    <?=$this->t('group start year', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <select name="group[start_year]" id="start_year" class="form-control school-group-start-11">
                                    <option value="">-</option>
                                    <?php for($i = date('Y'); $i >= $firstCountYear; $i--){ ?>
                                    <option value="<?=$i?>" <?php if($group->start_year == $i){ ?>selected<?php } ?>><?=$i?></option>
                                    <?php } ?>
                                </select>
                                <?php if(!empty($errors['start_year'])) { ?><div class="help-block"><?=$this->t($errors['start_year'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['end_year'])) { ?>has-error<?php } ?>">
                                <label for="end_year">
                                    <?=$this->t('group end year', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <select name="group[end_year]" id="end_year" class="form-control school-group-end-11">
                                    <option value="">-</option>
                                    <?php for($i = date('Y') + 11; $i >= $firstCountYear + 11; $i--){ ?>
                                    <option value="<?=$i?>" <?php if($group->end_year == $i){ ?>selected<?php } ?>><?=$i?></option>
                                    <?php } ?>
                                </select>
                                <?php if(!empty($errors['end_year'])) { ?><div class="help-block"><?=$this->t($errors['end_year'], 'back')?></div><?php } ?>
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

        