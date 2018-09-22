<article class="content">
    <div class="title-block">
        <h3 class="title"> 
            <?=$this->t('lessons', 'front')?>
        </h3>
        <p class="title-description"> <?=$this->t('view lessons', 'front')?> </p>
    </div>

    <?=$this->renderNotifications($successText, $errorText)?>


    <section class="section">
        <div class="card">
            <div class="card-block">
                <div class="card-title-block">
                    <h3 class="title">
                        <?=$this->t('lessons', 'front')?>
                    </h3>
                </div>
                <section class="section">
                    <div class="subtitle-block lesson-add-form-container">
                        <form action="<?=$controls['self']?>" method="get" >
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="group_id"><?=$this->t('group', 'front')?></label>
                                    <select id="group_id" name="lesson[group_id]" class="custom-select">
                                        <option value=""><?=$this->t('choose...', 'front')?></option>
                                        <?php foreach ($groups as $value) { ?>
                                        <option value="<?=$value['id']?>" <?php if(isset($filterLessons['group_id']) && $filterLessons['group_id'] == $value['id']){ ?>selected<?php } ?>><?=$value['grade']?> - <?=$value['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="subject_id"><?=$this->t('subject', 'front')?></label>
                                    <select id="subject_id" name="lesson[subject_id]" class="custom-select">
                                        <option value=""><?=$this->t('choose...', 'front')?></option>
                                        <?php foreach ($subjects as $value) { ?>
                                        <option value="<?=$value['id']?>" <?php if(isset($filterLessons['subject_id']) && $filterLessons['subject_id'] == $value['id']){ ?>selected<?php } ?>><?=$value['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="teacher_id"><?=$this->t('teacher', 'front')?></label>
                                    <select id="teacher_id" name="lesson[teacher_id]" class="custom-select">
                                        <option value=""><?=$this->t('choose...', 'front')?></option>
                                        <?php foreach ($teachers as $value) { ?>
                                        <option value="<?=$value['id']?>" <?php if(isset($filterLessons['teacher_id']) && $filterLessons['teacher_id'] == $value['id']){ ?>selected<?php } ?>><?=$value['lastname']?> <?=$value['firstname']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <div>
                                        <label>&nbsp;</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <?=$this->t('view lessons', 'front')?>
                                    </button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
                    

    <section class="section">
        <div class="card">
            <div class="card-block">
                <div class="card-title-block">
                    <h3 class="title">
                        Список проведенных уроков
                    </h3>
                </div>
                <section class="section">
                	<table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax_full']?>" data-order="[[ 4, &quot;desc&quot; ]]">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><?=$this->t('teacher', 'front')?></th>
                                <th><?=$this->t('student group', 'front')?></th>
                                <th><?=$this->t('subject', 'front')?></th>
                                <th><?=$this->t('lesson start time', 'front')?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th><?=$this->t('teacher', 'front')?></th>
                                <th><?=$this->t('student group', 'front')?></th>
                                <th><?=$this->t('subject', 'front')?></th>
                                <th><?=$this->t('lesson start time', 'front')?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </section>
            </div>
        </div>
                    
    </section>
</article>