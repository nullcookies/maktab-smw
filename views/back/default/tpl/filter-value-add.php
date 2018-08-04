<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('add filter value');?>
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
        
        <form id="filter-add-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_add" value="<?=$this->getTranslation('btn save')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group<?php if($errors['name'][$l_key]) { ?> has-error<?php } ?>">
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('filter value name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?=$filterValue['name'][$l_key]?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <label for="sort_number"><?=$this->getTranslation('sorting')?> </label>
                                <input type="text" class="form-control" name="sort_number" id="sort_number" value="<?=$filterValue['sort_number']?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="form-group<?php if($errors['filter_id']) { ?> has-error<?php } ?>">
                                <label for="filter_id"><?=$this->getTranslation('filter value parent')?></label>
                                <select name="filter_id" id="filter_id" class="form-control selectpicker">
                                    <option value="">-</option>
                                    <?php if($filters) { ?>
                                    <?php foreach($filters as $value) { ?>
                                    <option value="<?=$value['id']?>" <?php if($filterValue['filter_id'] == $value['id'] || $filter_id == $value['id']){ ?>selected<?php } ?>><?=$value['name'][LANG_ID]?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['filter_id']) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['filter_id'])?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="color"><?=$this->getTranslation('filter color')?> </label>
                                <input type="color" class="form-control" name="color" id="color" value="<?=$filterValue['color']?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_add" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        