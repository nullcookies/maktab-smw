<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit category');?>
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
            <input type="hidden" name="alias_id" id="alias_id" value="<?=$category['alias_id']?>" />
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group<?php if($errors['name'][$l_key]) { ?> has-error<?php } ?>">
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('category name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control translit-from" data-path="<?=$this->config['alias']['category']?>" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?=$category['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr<?=$l_key?>"><?=$this->getTranslation('descr short')?> (<?=$l_value?>)</label>
                                <textarea class="form-control" name="descr[<?=$l_key?>]" id="descr<?=$l_key?>"><?=$category['descr'][$l_key]?></textarea>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr_full<?=$l_key?>"><?=$this->getTranslation('descr full')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ck-editor"  name="descr_full[<?=$l_key?>]" id="descr_full<?=$l_key?>"><?=$category['descr_full'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status"><?=$this->getTranslation('status');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($category['status']) echo " checked "; ?> />
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['alias']) { ?>has-error<?php } ?>">
                                <label for="alias">
                                    <?=$this->getTranslation('alias name')?>
                                </label>
                                <input type="checkbox" id="alias-auto" data-toggle="toggle" data-size="mini" data-onstyle="success" data-on="auto" data-off="-" >
                                <input type="text" class="form-control translit-to" name="alias" id="alias" value="<?=$category['alias']; ?>" />
                                <?php if($errors['alias']) { ?><div class="help-block"><?=$this->getTranslation($errors['alias'])?></div><?php } ?>
                            </div>
                            
                            <!-- parent categories -->
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('category parent')?></label>
                                <select name="parent_category_id" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($categories){ ?>
                                    <?php foreach($categories as $value){ ?>
                                    <?php if(in_array($value['id'], $child_ids)){ continue; } ?>
                                    <option value="<?=$value['id']?>" <?php if($value['id'] == $category['parent_category_id']){ ?>selected<?php } ?> ><?=$value['name']?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- parent categories -->
                            
                            <!-- category show -->
                            <div class="form-group" <?php if(in_array('category_show_in', $hide_blocks)){ ?>style="display:none;"<?php } ?>>
                                <label for=""><?=$this->getTranslation('category show in')?></label>
                                <select name="category_show_in" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($category_show_in){ ?>
                                    <?php foreach($category_show_in as $value){ ?>
                                    <option value="<?=$value?>" <?php if($value == $category['category_show_in']){ ?>selected<?php } ?> ><?=$this->getTranslation('category show in ' . $value)?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- category show in -->

                            <div class="form-group">
                                <label for="sort_number"><?=$this->getTranslation('sorting')?></label>
                                <input type="text" class="form-control" name="sort_number" id="sort_number" value="<?=$category['sort_number']; ?>" />
                            </div>

                            <!-- images loading -->
                            <div class="form-group">
                                <?php
                                    $uploadInputName = 'images';
                                    $uploadDirName = 'category';
                                ?>
                                <label for=""><?=$this->getTranslation('upload images')?></label>
                                <div id="loaded-<?=$uploadInputName?>">
                                    <?php foreach($loadedImages as $key => $value){ ?>
                                    <input id="<?=$uploadInputName?>-<?=$value?>" type="hidden" name="<?=$uploadInputName?>[<?=$key?>]" value="<?=$value?>" />
                                    <?php } ?>
                                </div>
                                <input class="multiple-image-fileinput" multiple type="file" name="<?=$uploadInputName?>[]" />
                                <script type="text/javascript">
                                    function sortLoadedImages(){
                                        var sortItemsData = [];
                                        $('#loaded-<?=$uploadInputName?>').html('');
                                        $('.file-preview-thumbnails').children('.file-preview-frame').each(function(index){
                                            sortItemsData[index] = $(this).find('.kv-file-remove').data('key');
                                            $('#loaded-<?=$uploadInputName?>').append('<input id="<?=$uploadInputName?>-' + sortItemsData[index] + '" type="hidden" name="<?=$uploadInputName?>[' + index + ']" value="' + sortItemsData[index] + '" />');
                                        });
                                        $.ajax({
                                            url: '/<?=$this->config['adminAccess']?>/file/sort/',
                                            method: 'POST',
                                            data: {sort: sortItemsData},
                                            dataType: 'html'
                                        })
                                        .done(function(data){
                                            console.log(data);
                                        });
                                    }
                                    $(document).ready(function(){
                                        $('.multiple-image-fileinput').fileinput({
                                          theme: "explorer",
                                          language: "ru",
                                          uploadUrl: '/<?=$this->config['adminAccess']?>/file/upload/image/<?=$uploadDirName?>/',
                                          uploadAsync: true,
                                          maxFileCount: 10,
                                          showRemove: false,
                                          allowedFileTypes: ["image"],
                                          allowedFileExtensions: ["jpg", "gif", "png"],
                                          overwriteInitial: false,
                                          initialPreview: [
                                            <?php foreach($initialPreview as $value) { ?>
                                                '<?=$value?>',
                                            <?php } ?>
                                          ],
                                          initialPreviewAsData: true,
                                          initialPreviewConfig: [
                                            <?php 
                                                $initialPreviewConfigCount = count($initialPreviewConfig);
                                                for($i = 0; $i < $initialPreviewConfigCount; $i++){ 
                                                    echo $this->arrayToJsObject($initialPreviewConfig[$i]);
                                                    if($i < $initialPreviewConfigCount){
                                                        echo ',';
                                                    }
                                                } 
                                            ?>
                                          ],
                                          fileActionSettings: {
                                            dragIcon: '<i class="fa fa-arrows"></i>',
                                            dragSettings: {
                                                onUpdate: function(event) { 
                                                    sortLoadedImages();
                                                }
                                            },
                                            showUpload: false
                                          },
                                          otherActionButtons: '<button type="button" class="kv-cust-btn btn btn-xs btn-default" title="Crop" {dataKey}><i class="fa fa-crop"></i> </button>',
                                        }).on('fileuploaded', function(event, data, previewId, index) {
                                            var imgId = data.response.initialPreviewConfig[0].extra.id;
                                            var sortImg = $('#loaded-<?=$uploadInputName?>').find('input[type=hidden]').length;
                                            $('#loaded-<?=$uploadInputName?>').append('<input id="<?=$uploadInputName?>-' + imgId + '" type="hidden" name="<?=$uploadInputName?>[' + sortImg + ']" value="' + imgId + '" />');
                                        }).on('filedeleted', function(event, key) {
                                            $('#<?=$uploadInputName?>-' + key).remove();
                                            setTimeout(function(){
                                                sortLoadedImages();
                                            }, 700);
                                        });
                                    });
                                </script>
                            </div>
                            <!-- images loading -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info collapse-box collapsed-box">
                <div class="box-header">
                  <h3 class="box-title">
                    <?=$this->getTranslation('meta data')?>
                  </h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-plus"></i>
                    </button>
                    
                  </div>
                  <!-- /. tools -->
                </div>
                <div class="box-body">
                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_t<?=$l_key?>">Meta title (<?=$l_value?>)</label>
                        <input type="text" class="form-control"  name="meta_t[<?=$l_key?>]" id="meta_t<?=$l_key?>" value="<?=$category['meta_t'][$l_key]; ?>" />
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_d<?=$l_key?>">Meta description (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_d[<?=$l_key?>]" id="meta_d<?=$l_key?>"><?=$category['meta_d'][$l_key]; ?></textarea>
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_k<?=$l_key?>">Meta keywords (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_k[<?=$l_key?>]" id="meta_k<?=$l_key?>"><?=$category['meta_k'][$l_key]; ?></textarea>
                    </div>
                    <?php } ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->

            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        