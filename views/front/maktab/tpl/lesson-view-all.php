<article class="content item-editor-page">

	<div class="title-block">
        <h3 class="title"> 
            <?=$this->t('lesson', 'front')?>
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>

	<div class="card card-block">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><?=$this->t('lesson start time', 'front')?></label>
                <p class="form-control-static">
                	<?=$lesson->start_time?>
                </p>
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
							  	<input type="checkbox" class="custom-control-input" name="lesson[students][<?=$value['id']?>][attendance]?>" id="lesson_students_<?=$value['id']?>_attendance" <?php if($lesson->students[$value['id']]['attendance']){ ?>checked<?php } ?> disabled>
							  	<label class="custom-control-label" for="lesson_students_<?=$value['id']?>_attendance">&nbsp;</label>
							</div>
        				</td>
        				<td>
        					<p class="form-control-static">
        						<?=$lesson->students[$value['id']]['mark']?>
        					</p>
        				</td>
        			</tr>
            		<?php } ?>
            	</table>
            </div>
        </div>

        <div class="form-group">
            <label><?=$this->t('lesson home task', 'front')?></label>
            <p class="form-control-static">
            	<?=$lesson->hometask?>
            </p>
        </div>
    </div>
    <p>
        <a class="btn btn-primary btn-sm" href="<?=$controls['return_url']?>">
        	<i class="fa fa-arrow-left"></i>
        	<?=$this->t('back', 'front')?>
        </a>
    </p>
</article>