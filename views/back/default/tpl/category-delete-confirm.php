<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('delete category');?>
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
    
        <form id="category-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?=$category['id']?>" />
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-danger btn-app" type="submit">
                    <i class="fa fa-trash"></i>
                    <?=$this->getTranslation('btn confirm')?>
                </button>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn confirm')?>" />
            </div>

            <div class="box box-info">
                <div class="box-header">
                    <?=$this->getTranslation('products in category')?>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="products_delete"><?=$this->getTranslation('delete products in category')?></label>
                                <div class="form-control-static">
                                    <input id="products_delete" class="flat-blue" type="radio" name="product_action" value="delete" checked  />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('move products in category to')?></label>
                                <div class="form-control-static">
                                    <input id="products_move" class="flat-blue" type="radio" name="product_action" value="move"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="move_to_category" class="form-control selectpicker">
                                    <?php if($categories){ ?>
                                    <?php foreach($categories as $value){ ?>
                                    <option value="<?=$value['id']?>"><?=$value['name'][LANG_ID]?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
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
                <button class="btn btn-danger btn-app" type="submit">
                    <i class="fa fa-trash"></i>
                    <?=$this->getTranslation('btn confirm')?>
                </button>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn confirm')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        