<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title"> 
            <?=$this->t('lesson', 'front')?>
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" action="<?=$controls['view']?>" method="post">
        <div class="card card-block">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="group_id"><?=$this->t('group', 'front')?></label>
                    <select id="group_id" name="group_id" class="custom-select <?php if(!empty($errors['group_id'])) { ?>is-invalid<?php } ?>">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($groups as $value) { ?>
                        <option value="<?=$value['id']?>" <?php if($group_id == $value['id']){ ?>selected<?php } ?>><?=$value['grade']?></option>
                        <?php } ?>
                    </select>
                    <?php if(!empty($errors['group_id'])) { ?><div class="invalid-feedback"><?=$this->t($errors['group_id'], 'front')?></div><?php } ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="subject_id"><?=$this->t('subject', 'front')?></label>
                    <select id="subject_id" name="subject_id" class="custom-select <?php if(!empty($errors['subject_id'])) { ?>is-invalid<?php } ?>">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($subjects as $value) { ?>
                        <option value="<?=$value['id']?>" <?php if($subject_id == $value['id']){ ?>selected<?php } ?>><?=$value['name']?></option>
                        <?php } ?>
                    </select>
                    <?php if(!empty($errors['subject_id'])) { ?><div class="invalid-feedback"><?=$this->t($errors['subject_id'], 'front')?></div><?php } ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><?=$this->t('lesson start time', 'front')?></label>
                    <!-- <div class="datetimepicker-start_time"></div>
                    <input type="hidden" name="start_time" id="start_time"> -->
                    <input type='text' name="start_time" class="form-control datetimepicker" value="<?=$start_time?>">
                </div>
            </div>


            <div class="form-group">
                <label class="form-control-label"> <?=$this->t('students list', 'front')?> </label>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" name="btn_save" class="btn btn-primary"> <?=$this->t('send', 'front')?> </button>
                </div>
            </div>
        </div>
    </form>
</article>