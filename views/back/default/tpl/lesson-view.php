<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      	<h1>
	        <?=$this->t('view lesson', 'back');?>
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

    	<form class="add-lesson-form" action="<?=$controls['view']?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
	    	
	    	<input type="hidden" name="lesson[id]" value="<?=$lesson->id?>">
	    	<input type="hidden" name="lesson[group_id]" value="<?=$lesson->group_id?>">
	    	<input type="hidden" name="lesson[subject_id]" value="<?=$lesson->subject_id?>">
			
			<div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->t('btn back', 'back')?>
                </a>
                <!-- <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->t('btn save', 'back')?>
                </button>
                <input type="hidden" name="btn_save" value="<?=$this->t('btn save', 'back')?>" /> -->
            </div>

			<div class="row">
				<div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                        	<div class="form-group">
			                    <label><?=$this->t('lesson start time', 'front')?></label>
			                    <!-- <div class="datetimepicker-start_time"></div>
			                    <input type="hidden" name="start_time" id="start_time"> -->
			                    <input type='text' name="lesson[start_time]" class="form-control datetimepicker" readonly value="<?=$lesson->start_time?>">
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
				            					<input class="form-control" readonly style="max-width: 70px" type="number" min="0" max="5" step="1" name="lesson[students][<?=$value['id']?>][mark]?>" value="<?=$lesson->students[$value['id']]['mark']?>">
				            				</td>
				            			</tr>
				                		<?php } ?>
				                	</table>
				                </div>
				            </div>

				            <div class="form-group">
				                <label><?=$this->t('lesson home task', 'front')?></label>
				                <textarea name="lesson[hometask]" class="form-control" readonly><?=$lesson->hometask?></textarea>
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
                <!-- <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->t('btn save', 'back')?>
                </button>
                <input type="hidden" name="btn_save" value="<?=$this->t('btn save', 'back')?>" /> -->
            </div>
	    </form>
    </section>
    <!-- /.content -->
</div>