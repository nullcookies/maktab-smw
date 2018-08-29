<article class="content item-editor-page">
    <div class="title-block">
    	<p>
    		<a href="<?=$controls['back']?>" class="btn btn-primary btn-sm">
            	<i class="fa fa-arrow-left"></i>
            	<?=$this->t('back', 'front')?>
            </a>
    	</p>
        <h3 class="title"> 
            <?=$this->t('choose group', 'front')?>
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>

    <?=$this->renderNotifications($successText, $errorText)?>

    <form class="choose-group-form" action="<?=$controls['view']?>" method="post">

        <div class="card card-block">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="group_id"><?=$this->t('group', 'front')?></label>
                    <select id="group_id" name="lesson[group_id]" class="custom-select <?php if(!empty($errors['group_id'])) { ?>is-invalid<?php } ?>">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($groups as $value) { ?>
                        <option value="<?=$value['id']?>" <?php if($lesson->group_id == $value['id']){ ?>selected<?php } ?>><?=$value['grade']?></option>
                        <?php } ?>
                    </select>
                    <?php if(!empty($errors['group_id'])) { ?><div class="invalid-feedback"><?=$this->t($errors['group_id'], 'front')?></div><?php } ?>
                </div>
                <div class="form-group col-md-3">
                    <label for="subject_id"><?=$this->t('subject', 'front')?></label>
                    <select id="subject_id" name="lesson[subject_id]" class="custom-select <?php if(!empty($errors['subject_id'])) { ?>is-invalid<?php } ?>">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($subjects as $value) { ?>
                        <option value="<?=$value['id']?>" <?php if($lesson->subject_id == $value['id']){ ?>selected<?php } ?>><?=$value['name']?></option>
                        <?php } ?>
                    </select>
                    <?php if(!empty($errors['subject_id'])) { ?><div class="invalid-feedback"><?=$this->t($errors['subject_id'], 'front')?></div><?php } ?>
                </div>
                <div class="form-group col-md-2">
                	<div>
                		<label for="">&nbsp;</label>
                	</div>
                	<button class="btn btn-primary" type="submit"><?=$this->t('choose', 'front')?></button>
                </div>

            </div>
        </div>
    </form>

	<br>
	<br>

	<div class="title-block">
        <h3 class="title"> 
            <?=$this->t('lesson', 'front')?>
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form class="add-lesson-form" action="<?=$controls['view']?>" method="post">
    	<input type="hidden" name="lesson[id]" value="<?=$lesson->id?>">
    	<input type="hidden" name="lesson[group_id]" value="<?=$lesson->group_id?>">
    	<input type="hidden" name="lesson[subject_id]" value="<?=$lesson->subject_id?>">

		<div class="card card-block">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><?=$this->t('lesson start time', 'front')?></label>
                    <!-- <div class="datetimepicker-start_time"></div>
                    <input type="hidden" name="start_time" id="start_time"> -->
                    <input type='text' name="lesson[start_time]" class="form-control datetimepicker" value="<?=$lesson->start_time?>">
                </div>
            </div>


            <div class="form-group">
                <label class="form-control-label"> <?=$this->t('students list', 'front')?> </label>
                <div class="table-responsive">
                	<table class="table table-bordered">
                		<tr>
                			<th>
                				<?=$this->t('fio', 'front')?>
                			</th>
                			<th>
                				<?=$this->t('student attendance', 'front')?>
                				<div class="custom-control custom-checkbox custom-control-inline">
								  	<input type="checkbox" class="custom-control-input" name="check_all" id="check_all_students_attendance">
								  	<label class="custom-control-label" for="check_all_students_attendance"><?=$this->t('all', 'front')?></label>
								</div>
                			</th>
                			<th>
                				<?=$this->t('student mark', 'front')?>
                			</th>
                		</tr>
                		<?php foreach ($students as $value) { ?>
            			<tr>
            				<td>
            					<?=$value['lastname']?> <?=$value['firstname']?>
            				</td>
            				<td>
            					<div class="custom-control custom-checkbox">
								  	<input type="checkbox" class="custom-control-input" name="lesson[students][<?=$value['id']?>][attendance]?>" id="lesson_students_<?=$value['id']?>_attendance" <?php if($lesson->students[$value['id']]['attendance']){ ?>checked<?php } ?>>
								  	<label class="custom-control-label" for="lesson_students_<?=$value['id']?>_attendance">&nbsp;</label>
								</div>
            				</td>
            				<td>
            					<input class="form-control" style="max-width: 70px" type="number" min="0" max="5" step="1" name="lesson[students][<?=$value['id']?>][mark]?>" value="<?=$lesson->students[$value['id']]['mark']?>">
            				</td>
            			</tr>
                		<?php } ?>
                	</table>
                </div>
            </div>

            <div class="form-group">
                <label><?=$this->t('lesson home task', 'front')?></label>
                <textarea name="lesson[hometask]" class="form-control"><?=$lesson->hometask?></textarea>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" name="btn_save" class="btn btn-primary">
                    	<i class="fa fa-save"></i>
                    	<?=$this->t('send', 'front')?>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <p>
        <a class="btn btn-primary btn-sm" href="<?=$controls['back']?>">
        	<i class="fa fa-arrow-left"></i>
        	<?=$this->t('back', 'front')?>
        </a>
    </p>
</article>