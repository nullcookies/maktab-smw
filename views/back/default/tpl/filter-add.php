<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('add filter');?>
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
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('filter name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?= $filter['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            <!-- filter category -->
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('filter category')?></label>
                                <select name="category_id[]" class="form-control selectpicker" multiple>
                                    <option value="0">-</option>
                                    <?php if($categories){ ?>
                                    <?php foreach($categories as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if(is_array($filter['category_id']) && in_array($value['id'], $filter['category_id'])){ ?>selected<?php } ?> ><?=$value['name']?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- filter category -->
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

        