<article class="content">
    <div class="title-block">
        <h3 class="title"> 
            <?=$this->t('profile', 'front')?>
        </h3>
        <p class="title-description"> <?=$this->t('view profile', 'front')?> </p>
    </div>


    <div class="row">
        <div class="col-md-4">
            <section class="section">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <h3 class="title">
                                <?=$this->t('teachers', 'front')?>
                            </h3>
                        </div>
                        <div>
                            <ul class="list-group">
                                <?php foreach ($teachers as $value) { ?>
                                    <li class="list-group-item">
                                        <?=$value['lastname']?> <?=$value['firstname']?> (<?=$value['id']?>) 
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="section">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <h3 class="title">
                                <?=$this->t('groups', 'front')?>
                            </h3>
                        </div>
                        <div>
                            <ul class="list-group">
                                <?php foreach ($groups as $value) { ?>
                                    <li class="list-group-item">
                                        <?=$value['grade']?> - <?=$value['name']?> (<?=$value['start_year']?> - <?=$value['end_year']?>) 
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="section">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <h3 class="title">
                                <?=$this->t('subjects', 'front')?>
                            </h3>
                        </div>
                        <div>
                            <ul class="list-group">
                                <?php foreach ($subjects as $value) { ?>
                                    <li class="list-group-item">
                                        <?=$value['name']?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

            

            
</article>

