<article class="content">
    <div class="title-block">
        <h3 class="title"> 
            <?=$this->t('lessons', 'front')?>
        </h3>
        <p class="title-description"> <?=$this->t('view lessons', 'front')?> </p>
    </div>

    <?=$this->renderNotifications($successText, $errorText)?>

    <div class="subtitle-block lesson-add-form-container">
        <form action="<?=$controls['view']?>" method="post" >
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="group_id"><?=$this->t('group', 'front')?></label>
                    <select id="group_id" name="lesson[group_id]" class="custom-select">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($groups as $value) { ?>
                        <option value="<?=$value['id']?>"><?=$value['grade']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="subject_id"><?=$this->t('subject', 'front')?></label>
                    <select id="subject_id" name="lesson[subject_id]" class="custom-select">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($subjects as $value) { ?>
                        <option value="<?=$value['id']?>"><?=$value['name']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <div>
                        <label>&nbsp;</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?=$this->t('add new lesson', 'front')?>
                    </button>
                </div>
            </div> 
        </form>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-block">
                <div class="card-title-block">
                    <h3 class="title">
                        Список проведенных уроков
                    </h3>
                </div>
                <section class="section">
                	<table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax']?>" data-order="[[ 3, &quot;desc&quot; ]]">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><?=$this->t('student group', 'front')?></th>
                                <th><?=$this->t('subject', 'front')?></th>
                                <th><?=$this->t('lesson start time', 'front')?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th><?=$this->t('student group', 'front')?></th>
                                <th><?=$this->t('subject', 'front')?></th>
                                <th><?=$this->t('student group', 'front')?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </section>
            </div>
        </div>
                    
    </section>
</article>