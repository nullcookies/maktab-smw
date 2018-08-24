<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('view study period', 'back');?>
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
            
            <input type="hidden" name="studyPeriod[id]" value="<?=$studyPeriod->id?>" />
            
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
							
							<?php
                                $firstCountYear = 2018;
                            ?>

                            <div class="form-group <?php if(!empty($errors['start_year'])) { ?>has-error<?php } ?>">
                                <label for="start_year">
                                    <?=$this->t('study period start year', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <select name="studyPeriod[start_year]" id="start_year" class="form-control study-period-start-year-1">
                                    <option value="">-</option>
                                    <?php for($i = date('Y'); $i >= $firstCountYear; $i--){ ?>
                                    <option value="<?=$i?>" <?php if($studyPeriod->start_year == $i){ ?>selected<?php } ?>><?=$i?></option>
                                    <?php } ?>
                                </select>
                                <?php if(!empty($errors['start_year'])) { ?><div class="help-block"><?=$this->t($errors['start_year'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['end_year'])) { ?>has-error<?php } ?>">
                                <label for="end_year">
                                    <?=$this->t('study period end year', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <select name="studyPeriod[end_year]" id="end_year" class="form-control study-period-end-year-1">
                                    <option value="">-</option>
                                    <?php for($i = date('Y') + 1; $i >= $firstCountYear + 1; $i--){ ?>
                                    <option value="<?=$i?>" <?php if($studyPeriod->end_year == $i){ ?>selected<?php } ?>><?=$i?></option>
                                    <?php } ?>
                                </select>
                                <?php if(!empty($errors['end_year'])) { ?><div class="help-block"><?=$this->t($errors['end_year'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['period'])) { ?>has-error<?php } ?>">
                                <label for="period">
                                    <?=$this->t('study period name', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="studyPeriod[period]" id="period" value="<?= $studyPeriod->period; ?>" />
                                <?php if(!empty($errors['period'])) { ?><div class="help-block"><?=$this->t($errors['period'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['start_time'])) { ?>has-error<?php } ?>">
                                <label for="start_time">
                                    <?=$this->t('study period start time', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control datepicker" name="studyPeriod[start_time]" id="start_time" value="<?=date('Y/m/d', $studyPeriod->start_time)?>" />
                                <?php if(!empty($errors['start_time'])) { ?><div class="help-block"><?=$this->t($errors['start_time'], 'back')?></div><?php } ?>
                            </div>

                            <div class="form-group <?php if(!empty($errors['end_time'])) { ?>has-error<?php } ?>">
                                <label for="end_time">
                                    <?=$this->t('study period end time', 'back')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control datepicker" name="studyPeriod[end_time]" id="end_time" value="<?=date('Y/m/d', $studyPeriod->end_time)?>" />
                                <?php if(!empty($errors['end_time'])) { ?><div class="help-block"><?=$this->t($errors['end_time'], 'back')?></div><?php } ?>
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

        