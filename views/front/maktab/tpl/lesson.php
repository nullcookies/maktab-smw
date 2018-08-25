<article class="content">
    <div class="title-block">
        <h3 class="title"> 
            Уроки
        </h3>
        <p class="title-description"> Просмотр уроков </p>
    </div>
    <div class="subtitle-block lesson-add-form-container">
        <form action="<?=$controls['view']?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="group_id"><?=$this->t('group', 'front')?></label>
                    <select id="group_id" name="group_id" class="custom-select">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($groups as $value) { ?>
                        <option value="<?=$value['id']?>"><?=$value['grade']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="subject_id"><?=$this->t('subject', 'front')?></label>
                    <select id="subject_id" name="subject_id" class="custom-select">
                        <option value=""><?=$this->t('choose...', 'front')?></option>
                        <?php foreach ($subjects as $value) { ?>
                        <option value="<?=$value['id']?>"><?=$value['name']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label сlass="d-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <?=$this->t('add new', 'front')?>
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
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot>
                    </table>
                </section>
            </div>
        </div>
                    
    </section>
</article>