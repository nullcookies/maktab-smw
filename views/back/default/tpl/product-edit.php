<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit product');?>
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
    
        <form id="product-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$product['id']?>" />
            <input type="hidden" name="alias_id" id="alias_id" value="<?=$product['alias_id']?>" />
            
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
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('product name')?> (<?=$l_value?>) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control translit-from" data-path="<?=$this->config['alias']['product']?>" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?=$product['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            

                            <!-- tags -->
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="tags<?=$l_key?>"><?=$this->getTranslation('tags')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control tagsinput" name="tags[<?=$l_key?>]" id="tags<?=$l_key?>" value="<?=$product['tags'][$l_key]; ?>" />
                            </div>
                            <?php } ?>
                            <script>
                                var tagsData = [];
                                var tagsInput = $('.tagsinput');
                                function setTagsData(data){
                                    tagsData = data;
                                }
                                $(function(){
                                    $.ajax({
                                        url: '<?=$controls['getTags']?>',
                                        dataType: 'json'
                                    })
                                    .done(function(data){
                                        setTagsData(data);
                                    })
                                    .always(function(){
                                        tagsInput.tagsinput({
                                            typeahead: {
                                                source: tagsData
                                            },
                                            afterSelect: function(data){
                                                console.log(data);
                                                //self.$input.typeahead('val', '');
                                            }
                                        });
                                    });  
                                    $('body').on('change', tagsInput, function(){
                                        $(".bootstrap-tagsinput input").val('');
                                    });
                                });
                            </script>
                            <!-- tags -->


                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr<?=$l_key?>"><?=$this->getTranslation('descr short')?> (<?=$l_value?>)</label>
                                <textarea class="form-control" name="descr[<?=$l_key?>]" id="descr<?=$l_key?>"><?=$product['descr'][$l_key]?></textarea>
                            </div>
                            <?php } ?>
                            
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="descr_full<?=$l_key?>"><?=$this->getTranslation('descr full')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ck-editor"  name="descr_full[<?=$l_key?>]" id="descr_full<?=$l_key?>"><?=$product['descr_full'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>
                            
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="specifications<?=$l_key?>"><?=$this->getTranslation('specifications')?> (<?=$l_value?>)</label>
                                <textarea class="form-control ck-editor"  name="specifications[<?=$l_key?>]" id="specifications<?=$l_key?>"><?=$product['specifications'][$l_key]; ?></textarea>
                            </div>
                            <?php } ?>
                            
                            <!-- images loading -->
                            <div class="form-group">
                                <?php
                                    $uploadInputName = 'images';
                                    $uploadDirName = 'product';
                                ?>
                                <label for=""><?=$this->getTranslation('upload images')?></label><br>
                                <label for=""><?=$this->getTranslation('recommended size')?></label><br>
                                <label for=""><?=$recommendedSize1?></label>
                                <div id="loaded-<?=$uploadInputName?>">
                                    <?php foreach($loadedImages as $key => $value){ ?>
                                    <input id="<?=$uploadInputName?>-<?=$value?>" type="hidden" name="<?=$uploadInputName?>[<?=$key?>]" value="<?=$value?>" />
                                    <?php } ?>
                                </div>
                                <div id="loaded-<?=$uploadInputName?>-result"></div>
                                <input class="multiple-image-fileinput" multiple type="file" name="<?=$uploadInputName?>[]" />
                                <script type="text/javascript">
                                    var uploadInputName = '<?=$uploadInputName?>';
                                    function sortLoadedImages(){
                                        var sortItemsData = [];
                                        $('#loaded-<?=$uploadInputName?>').html('');
                                        $('#loaded-<?=$uploadInputName?>').closest('.form-group').find('.file-preview-thumbnails').children('.file-preview-frame').each(function(index){
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
                                            //console.log(data);
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
                                        }).on('filepreajax', function(event, data, previewId, index) {
                                            $('#loaded-<?=$uploadInputName?>-result').empty();
                                        }).on('fileuploaded', function(event, data, previewId, index) {
                                            if(data.response.errors.length){
                                                for(var i in data.response.errors){
                                                    $('#loaded-<?=$uploadInputName?>-result').append('<p class="text-danger">' + data.response.errors[i].file + ' - ' + data.response.errors[i].error + '</p>');
                                                }
                                            }
                                            if(data.response.success){
                                                var imgId = data.response.initialPreviewConfig[0].extra.id;
                                                var sortImg = $('#loaded-<?=$uploadInputName?>').find('input[type=hidden]').length;
                                                $('#loaded-<?=$uploadInputName?>').append('<input id="<?=$uploadInputName?>-' + imgId + '" type="hidden" name="<?=$uploadInputName?>[' + sortImg + ']" value="' + imgId + '" />');
                                            }
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
                            
                            <!-- gallery images -->
                            <div class="form-group">
                                <label><?=$this->getTranslation('added from gallery images')?></label>
                                <p>
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#gallery-modal-block"><i class="fa fa-plus"></i> <?=$this->getTranslation('add from gallery')?></button>
                                </p>
                                <div id="added-from-gallery-container">
                                    <?php if(is_array($product['images_gallery']) && count($product['images_gallery'])){ ?>
                                    <?php foreach($product['images_gallery'] as $value){ ?>
                                    <div class="added-from-gallery added-from-gallery-<?=$value?>" data-id="<?=$value?>">
                                        <i class="fa fa-times added-from-gallery-remove"></i>
                                        
                                        <input name="images_gallery[]" value="<?=$value?>" type="hidden">
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- gallery images -->



                            <div class="form-group">
                                <label for="video_code"><?=$this->getTranslation('video code')?></label>
                                <textarea class="form-control" name="video_code" id="video_code"><?=$product['video_code']?></textarea>
                            </div>
                            
                            <!-- videos loading -->
                            <div class="form-group" style="display: none;">
                                <?php
                                    $uploadInputName = 'videos';
                                    $uploadDirName = 'product-video';
                                ?>
                                <label for=""><?=$this->getTranslation('upload videos')?></label><br>
                                <label for=""><?=$this->getTranslation('recommended formats:')?> mp4 (h.264), webm</label>
                                <div id="loaded-<?=$uploadInputName?>">
                                    <?php foreach($loadedVideos as $key => $value){ ?>
                                    <input id="<?=$uploadInputName?>-<?=$value?>" type="hidden" name="<?=$uploadInputName?>[<?=$key?>]" value="<?=$value?>" />
                                    <?php } ?>
                                </div>
                                <input class="multiple-video-fileinput" multiple type="file" name="<?=$uploadInputName?>[]" />
                                <script type="text/javascript">
                                    var uploadInputName = '<?=$uploadInputName?>';
                                    function sortLoadedVideos(){
                                        var sortItemsData = [];
                                        $('#loaded-<?=$uploadInputName?>').html('');
                                        $('#loaded-<?=$uploadInputName?>').closest('.form-group').find('.file-preview-thumbnails').children('.file-preview-frame').each(function(index){
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
                                            //console.log(data);
                                        });
                                    }
                                    $(document).ready(function(){
                                        $('.multiple-video-fileinput').fileinput({
                                          theme: "explorer",
                                          language: "ru",
                                          uploadUrl: '/<?=$this->config['adminAccess']?>/file/upload/video/<?=$uploadDirName?>/',
                                          uploadAsync: true,
                                          maxFileCount: 10,
                                          showRemove: false,
                                          allowedFileTypes: ["video"],
                                          allowedFileExtensions: ["mp4, webm"],
                                          overwriteInitial: false,
                                          initialPreview: [
                                            <?php foreach($initialPreviewVideo as $value) { ?>
                                                '<?=$value?>',
                                            <?php } ?>
                                          ],
                                          initialPreviewAsData: true,
                                          initialPreviewFileType: 'video',
                                          initialPreviewConfig: [
                                            <?php 
                                                $initialPreviewConfigCountVideo = count($initialPreviewConfigVideo);
                                                for($i = 0; $i < $initialPreviewConfigCountVideo; $i++){ 
                                                    echo $this->arrayToJsObject($initialPreviewConfigVideo[$i]);
                                                    if($i < $initialPreviewConfigCountVideo){
                                                        echo ',';
                                                    }
                                                } 
                                            ?>
                                          ],
                                          fileActionSettings: {
                                            dragIcon: '<i class="fa fa-arrows"></i>',
                                            dragSettings: {
                                                onUpdate: function(event) { 
                                                    sortLoadedVideos();
                                                }
                                            },
                                            showUpload: false
                                          },
                                          otherActionButtons: '',
                                        }).on('fileuploaded', function(event, data, previewId, index) {
                                            var fileId = data.response.initialPreviewConfig[0].extra.id;
                                            var sortFile = $('#loaded-<?=$uploadInputName?>').find('input[type=hidden]').length;
                                            $('#loaded-<?=$uploadInputName?>').append('<input id="<?=$uploadInputName?>-' + fileId + '" type="hidden" name="<?=$uploadInputName?>[' + sortFile + ']" value="' + fileId + '" />');
                                        }).on('filedeleted', function(event, key) {
                                            $('#<?=$uploadInputName?>-' + key).remove();
                                            setTimeout(function(){
                                                sortLoadedVideos();
                                            }, 700);
                                        });
                                    });
                                </script>
                            </div>
                            <!-- videos loading -->
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status"><?=$this->getTranslation('status');?></label>
                                        <div class="form-control-static">
                                            <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($product['status']) echo " checked "; ?> />
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none;" class="col-sm-6">
                                    <div class="form-group">
                                        <label for="request_product"><?=$this->getTranslation('request product');?></label>
                                        <div class="form-control-static">
                                            <input class="flat-blue" type="checkbox" name="request_product" id="request_product" <?php if($product['request_product']) echo " checked "; ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="recommended"><?=$this->getTranslation('recommended product');?></label>
                                        <div class="form-control-static">
                                            <input class="flat-blue" type="checkbox" name="recommended" id="recommended" <?php if($product['recommended']) echo " checked "; ?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sku -->
                            <div class="form-group <?php if($errors['sku']) { ?>has-error<?php } ?>">
                                <label for="sku">
                                    <?=$this->getTranslation('sku')?> <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="sku" id="sku" value="<?=$product['sku']; ?>" />
                                <?php if($errors['sku']) { ?><div class="help-block"><?=$this->getTranslation($errors['sku'])?></div><?php } ?>
                            </div>
                            <!-- sku -->

                            <!-- alias -->
                            <div class="form-group <?php if($errors['alias']) { ?>has-error<?php } ?>">
                                <label for="alias">
                                    <?=$this->getTranslation('alias name')?> <span class="text-danger">*</span>
                                </label>
                                <input type="checkbox" id="alias-auto" data-toggle="toggle" data-size="mini" data-onstyle="success" data-on="auto" data-off="-" checked >
                                <input type="text" class="form-control translit-to" name="alias" id="alias" value="<?= $product['alias']; ?>" />
                                <?php if($errors['alias']) { ?><div class="help-block"><?=$this->getTranslation($errors['alias'])?></div><?php } ?>
                            </div>
                            <!-- alias -->
                            
                            <?php /*
                            <!-- excise -->
                            <div class="form-group <?php if($errors['excise']) { ?>has-error<?php } ?>">
                                <label for="excise">
                                    <?=$this->getTranslation('excise')?>
                                </label>
                                <input type="text" class="form-control" name="excise" id="excise" value="<?=$product['excise']; ?>" />
                                <?php if($errors['excise']) { ?><div class="help-block"><?=$this->getTranslation($errors['excise'])?></div><?php } ?>
                            </div>
                            <!-- excise -->
                            
                            <!-- nds -->
                            <div class="form-group <?php if($errors['nds']) { ?>has-error<?php } ?>">
                                <label for="nds">
                                    <?=$this->getTranslation('nds')?>
                                </label>
                                <input type="text" class="form-control" name="nds" id="nds" value="<?=$product['nds']; ?>" />
                                <?php if($errors['nds']) { ?><div class="help-block"><?=$this->getTranslation($errors['nds'])?></div><?php } ?>
                            </div>
                            <!-- nds -->
                            */ ?>

                            <!-- price -->
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group <?php if($errors['price']) { ?>has-error<?php } ?>">
                                        <label for="price">
                                            <?=$this->getTranslation('price base')?> <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="price" id="price" value="<?=$product['price']; ?>" />
                                        <?php if($errors['price']) { ?><div class="help-block"><?=$this->getTranslation($errors['price'])?></div><?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group <?php if($errors['discount']) { ?>has-error<?php } ?>">
                                        <label for="discount">
                                            <?=$this->getTranslation('discount')?>, %
                                        </label>
                                        <input type="text" class="form-control" name="discount" id="discount" value="<?=$product['discount']; ?>" />
                                        <?php if($errors['discount']) { ?><div class="help-block"><?=$this->getTranslation($errors['discount'])?></div><?php } ?>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="discount">
                                            <?=$this->getTranslation('price show')?>
                                        </label>
                                        <p class="form-control-static" id="priceshow"></p>
                                    </div>
                                </div>
                                <?php /*
                                <div class="col-xs-6">
                                    <div class="form-group <?php if($errors['price_orig']) { ?>has-error<?php } ?>">
                                        <label for="price_orig">
                                            <?=$this->getTranslation('price for item original')?> <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="price_orig" id="price_orig" value="<?=$product['price_orig']; ?>" />
                                        <?php if($errors['price_orig']) { ?><div class="help-block"><?=$this->getTranslation($errors['price_orig'])?></div><?php } ?>
                                    </div>
                                </div>
                                */ ?>
                            </div>
                            <!-- price -->

                            <?php /*
                            <!-- product-blocks -->
                            <div class="form-group <?php if($errors['unit_in_block']) { ?>has-error<?php } ?>">
                                <label for="unit_in_block">
                                    <?=$this->getTranslation('unit in block')?> <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="unit_in_block" id="unit_in_block" value="<?=$product['unit_in_block']; ?>" />
                                    <span class="input-group-addon">
                                        <?=$this->getTranslation('unit in block')?>
                                    </span>
                                </div>
                                <?php if($errors['unit_in_block']) { ?><div class="help-block"><?=$this->getTranslation($errors['unit_in_block'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['unit_in_dal']) { ?>has-error<?php } ?>">
                                <label for="unit_in_dal">
                                    <?=$this->getTranslation('unit in dal')?> <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="unit_in_dal" id="unit_in_dal" value="<?=$product['unit_in_dal']; ?>" />
                                    <span class="input-group-addon">
                                        <?=$this->getTranslation('unit in dal')?>
                                    </span>
                                </div>
                                <?php if($errors['unit_in_dal']) { ?><div class="help-block"><?=$this->getTranslation($errors['unit_in_dal'])?></div><?php } ?>
                            </div>
                            <!-- product-blocks -->

                            <!-- block price -->
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="price_for_block">
                                            <?=$this->getTranslation('price for block')?>
                                        </label>
                                        <input type="text" readonly class="form-control" name="price_for_block" id="price_for_block" value="<?=(($product['price_for_block']) ? $product['price_for_block'] : ($product['price'] * $product['unit_in_block']))?>" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="price_for_dal">
                                            <?=$this->getTranslation('price for dal')?>
                                        </label>
                                        <input type="text" readonly class="form-control" name="price_for_dal" id="price_for_dal" value="<?=(($product['price_for_dal']) ? $product['price_for_dal'] : ($product['price'] * $product['unit_in_dal']))?>" />
                                    </div>
                                </div>
                            </div>
                            <!-- block price -->
                            */ ?>
                            
                            <!-- stock start -->
                            <div class="form-group <?php if($errors['stock_1']) { ?>has-error<?php } ?>">
                                <label for="stock_1">
                                    <?=$this->getTranslation('stock 1')?>, <?=$this->getTranslation('unit')?>
                                </label>
                                <input type="text" class="form-control" name="stock_1" id="stock_1" value="<?=$product['stock_1']; ?>" />
                                <?php if($errors['stock_1']) { ?><div class="help-block"><?=$this->getTranslation($errors['stock_1'])?></div><?php } ?>
                            </div>
                            <?php /*
                            <div class="form-group <?php if($errors['stock_2']) { ?>has-error<?php } ?>">
                                <label for="stock_2">
                                    <?=$this->getTranslation('stock 2')?>, <?=$this->getTranslation('unit')?>
                                </label>
                                <input type="text" class="form-control" name="stock_2" id="stock_2" value="<?=$product['stock_2']; ?>" />
                                <?php if($errors['stock_2']) { ?><div class="help-block"><?=$this->getTranslation($errors['stock_2'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['stock_3']) { ?>has-error<?php } ?>">
                                <label for="stock_3">
                                    <?=$this->getTranslation('stock 3')?>, <?=$this->getTranslation('unit')?>
                                </label>
                                <input type="text" class="form-control" name="stock_3" id="stock_3" value="<?=$product['stock_3']; ?>" />
                                <?php if($errors['stock_3']) { ?><div class="help-block"><?=$this->getTranslation($errors['stock_3'])?></div><?php } ?>
                            </div>
                            */ ?>
                            <!-- stock end -->


                            <!-- unit start -->
                            <?php /*
                            <div class="form-group <?php if($errors['unit']) { ?>has-error<?php } ?>">
                                <label for="unit">
                                    <?=$this->getTranslation('product unit')?>
                                </label>
                                <input type="text" class="form-control" name="unit" id="unit" value="<?php if($product['unit']){ echo $product['unit']; } else { ?><?=$this->getTranslation('unit')?><?php } ?>" />
                                <?php if($errors['unit']) { ?><div class="help-block"><?=$this->getTranslation($errors['unit'])?></div><?php } ?>
                            </div>
                            */ ?>
                            <!-- unit end -->


                                    
                            

                            <!-- product category -->
                            <div class="form-group <?php if($errors['category_id']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('product category')?></label>
                                <select name="category_id" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($categories){ ?>
                                    <?php foreach($categories as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if($value['id'] == $product['category_id']){ ?>selected<?php } ?> ><?=$value['name']?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['category_id']) { ?><div class="help-block"><?=$this->getTranslation($errors['category_id'])?></div><?php } ?>
                            </div>
                            <!-- product category -->
                            
                            <!-- product brand -->
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('product brand')?></label>
                                <select name="brand_id" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($brands){ ?>
                                    <?php foreach($brands as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if($value['id'] == $product['brand_id']){ ?>selected<?php } ?> ><?=$value['name'][LANG_ID]?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- product brand -->
                            
                            <!-- product up sells -->
                            <div class="form-group <?php if($errors['up_sells']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('product up sells')?></label>
                                <select name="up_sells[]" multiple class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($products){ ?>
                                    <?php foreach($products as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if(is_array($product['up_sells']) && in_array($value['id'], $product['up_sells'])){ ?>selected<?php } ?> ><?=$value['name']?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['up_sells']) { ?><div class="help-block"><?=$this->getTranslation($errors['up_sells'])?></div><?php } ?>
                            </div>
                            <!-- product up sells -->
                            
                            <!-- product cross sells -->
                            <div class="form-group <?php if($errors['cross_sells']) { ?>has-error<?php } ?>">
                                <label for=""><?=$this->getTranslation('product cross sells')?></label>
                                <select name="cross_sells[]" multiple class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($products){ ?>
                                    <?php foreach($products as $value){ ?>
                                    <option value="<?=$value['id']?>" <?php if(is_array($product['cross_sells']) && in_array($value['id'], $product['cross_sells'])){ ?>selected<?php } ?> ><?=$value['name']?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['cross_sells']) { ?><div class="help-block"><?=$this->getTranslation($errors['cross_sells'])?></div><?php } ?>
                            </div>
                            <!-- product cross sells -->

                            <div class="form-group">
                                <label for="sort_number"><?=$this->getTranslation('sorting')?></label>
                                <input type="text" class="form-control" name="sort_number" id="sort_number" value="<?= $product['sort_number']; ?>" />
                            </div>

                            
                                
                        </div>
                    </div>
                    
                    <!-- filters -->
                    <div class="box box-info">
                        <div class="box-body">
                            
                            <!-- filters -->
                            <div class="form-group">
                                <label for="filters">
                                    <?=$this->getTranslation('choose filter')?>
                                </label>
                                <select name="filters[]" id="filters" class="form-control selectpicker filters-select" multiple>
                                    <?php if($filters){ ?>
                                    <?php foreach($filters as $key => $value){ ?>
                                    <option value="<?=$key?>" <?php if(in_array($key, $filterIds)){ ?>selected<?php } ?>><?=$value?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <script>
                                function filterAdjust(filterValueIds = []){
                                    var selector = $('#filters');
                                    var sendData = {};
                                    var selectedFilterIds = selector.val();
                                    var notSelectedFilterIds = [];
                                    var filterIds = []; //фильтры которые будут запрошены
                                    var filterDeleteIds = []; //фильтры которые будут убраны из списка
                                    
                                    //выбираем из массива ид фильтров которых ещё нет в списке
                                    for(var i in selectedFilterIds){
                                        if(!$('#filter_values' + selectedFilterIds[i]).length){
                                            filterIds.push(selectedFilterIds[i]);
                                        }
                                    }
                                    //выбираем из массива ид фильтров которые будут удалены
                                    notSelectedFilterIds = selector.find('option').not(':selected').map(function(){
                                        filterDeleteIds.push($(this).val());
                                    });

                                    //если есть что добавить
                                    if(filterIds.length){
                                        sendData.filterIds = filterIds;
                                        $.ajax({
                                            method: 'POST',
                                            dataType: 'json',
                                            //dataType: 'html',
                                            url: "<?=$controls['getFilter']?>",
                                            data: sendData

                                        })
                                        .done(function(data){
                                            if(data.success){
                                                for(var i in data.filters){
                                                    if($('#filter_values' + data.filters[i].id).length){
                                                        continue;
                                                    }
                                                    var filterValue = '' +
                                                    '<div id="filter_values_container' + data.filters[i].id + '" class="form-group"><div class="row"><div class="col-sm-3">' + 
                                                        '<span class="filter-name">' + data.filters[i].name + ':</span>' + 
                                                    '</div><div class="col-sm-9">' + 
                                                        '<select name="filter_values[' + data.filters[i].id + '][]" id="filter_values' + data.filters[i].id + '" class="form-control selectpicker" multiple>';
                                                    for(var j in data.filters[i].values){
                                                        filterValue += '<option value="' + data.filters[i].values[j].id + '" ' + ( (inArray(data.filters[i].values[j].id, filterValueIds)) ? 'selected' : '' ) + '>' + data.filters[i].values[j].name + '</option>';
                                                    }
                                                            
                                                    filterValue += '' +
                                                        '</select>' + 
                                                    '</div></div></div>';

                                                    $('.filter-values-list').append(filterValue);
                                                    $('.filter-values-list .selectpicker').selectpicker();
                                                }
                                            }
                                        })
                                        .fail(function(data){
                                            //console.log(data);
                                        });
                                    }

                                    //если есть что удалить
                                    if(filterDeleteIds.length){
                                        for(var i in filterDeleteIds){
                                            if($('#filter_values' + filterDeleteIds[i]).length){
                                                $('#filter_values_container' + filterDeleteIds[i]).remove();
                                            }
                                        }
                                    }
                                }
                                var filterValueIdsJson = '<?=$filterValueIds?>';
                                var filterValueIds = JSON && JSON.parse(filterValueIdsJson) || $.parseJSON(filterValueIdsJson);;
                                filterAdjust(filterValueIds);
                                $('.filters-select').on('change', function(){
                                    filterAdjust();
                                });
                            </script>
                            <!-- filters -->

                            <!-- filter values -->
                            <div class="filter-values-list">

                            </div>
                            <!-- filter values -->
                                
                        </div>
                    </div>
                    <!-- filters -->

                    
                    <!-- options -->
                    <div class="box box-info" style="display:none;">
                        <div class="box-body">
                            
                            <!-- options header-->
                            <div class="form-group">
                                <label for="product-options">
                                    <?=$this->getTranslation('product options')?>
                                </label>
                                <div class="">
                                    <button class="product-option-add btn btn-default" data-type="radio">
                                        <i class="fa fa-dot-circle-o"></i>
                                        <?=$this->getTranslation('new radio option')?>
                                    </button>
                                    <button class="product-option-add btn btn-default" data-type="color">
                                        <i class="fa fa-th-large"></i>
                                        <?=$this->getTranslation('new color option')?>
                                    </button>
                                    <!-- <button class="product-option-add btn btn-default" data-type="checkbox">
                                        <i class="fa fa-check-square"></i>
                                        <?=$this->getTranslation('new checkbox option')?>
                                    </button> -->
                                    <button class="product-option-add btn btn-default" data-type="select">
                                        <i class="fa fa-angle-down"></i>
                                        <?=$this->getTranslation('new select option')?>
                                    </button>
                                </div>
                            </div>
                            <!-- options header -->
                            
                            <!-- options container -->
                            <div class="options-container">
                                <?php if($product['options']){ ?>
                                <?php foreach($product['options'] as $key => $value){ ?>

                                <!-- option <?=$value['type']?> template in -->
                                <div class="options-template options-<?=$value['type']?>-template" data-type="<?=$value['type']?>">
                                    <i class="fa fa-times options-template-remove"></i>
                                    <input type="hidden" name="option[<?=$key?>][type]" value="<?=$value['type']?>">
                                    <div class="form-group">
                                        <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                        <label><?=$this->getTranslation('option group name')?> (<?=$l_value?>)</label>
                                        <input class="form-control" type="text" name="option[<?=$key?>][name][<?=$l_key?>]" value="<?=$value['name'][$l_key]?>">
                                        <?php } ?>
                                    </div>
                                    <div class="option-values-container">
                                        <div class="option-values-template-container">
                                            <?php foreach($value['values'] as $key1 => $value1){ ?>
                                            <div class="form-group option-values-template">
                                                <i class="fa fa-times option-value-remove"></i>
                                                <?php if($value['type'] == 'radio'){ ?>
                                                <i class="fa fa-dot-circle-o option-value-type"></i>
                                                <div class="row">
                                                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option value name')?> (<?=$l_value?>)</label>
                                                        <input class="form-control" type="text" name="option[<?=$key?>][values][<?=$key1?>][name][<?=$l_key?>]" value="<?=$value1['name'][$l_key]?>">
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option price')?> </label>
                                                        <input class="form-control" type="text" name="option[<?=$key?>][values][<?=$key1?>][price]" value="<?=$value1['price']?>">
                                                    </div>
                                                </div>
                                                <?php } elseif($value['type'] == 'color'){ ?>
                                                <i class="fa fa-dot-circle-o option-value-type"></i>
                                                <div class="row">
                                                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option value name')?> (<?=$l_value?>)</label>
                                                        <input class="form-control" type="text" name="option[<?=$key?>][values][<?=$key1?>][name][<?=$l_key?>]" value="<?=$value1['name'][$l_key]?>">
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option price')?> </label>
                                                        <input class="form-control" type="text" name="option[<?=$key?>][values][<?=$key1?>][price]" value="<?=$value1['price']?>">
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option color')?> </label>
                                                        <input class="form-control" type="color" name="option[<?=$key?>][values][<?=$key1?>][color]" value="<?=$value1['color']?>">
                                                    </div>
                                                </div>
                                                <?php } elseif($value['type'] == 'select'){ ?>
                                                <i class="fa fa-dot-circle-o option-value-type"></i>
                                                <div class="row">
                                                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option value name')?> (<?=$l_value?>)</label>
                                                        <input class="form-control" type="text" name="option[<?=$key?>][values][<?=$key1?>][name][<?=$l_key?>]" value="<?=$value1['name'][$l_key]?>">
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option price')?> </label>
                                                        <input class="form-control" type="text" name="option[<?=$key?>][values][<?=$key1?>][price]" value="<?=$value1['price']?>">
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label><?=$this->getTranslation('option color')?> </label>
                                                        <input class="form-control" type="color" name="option[<?=$key?>][values][<?=$key1?>][color]" value="<?=$value1['color']?>">
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success option-value-add">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- option <?=$value['type']?> template in -->
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <!-- options container -->
                            
                            <!-- option radio template -->
                            <div style="display: none;" class="options-template options-template-raw options-radio-template options-radio-template-raw" data-type="radio">
                                <i class="fa fa-times options-template-remove"></i>
                                <input type="hidden" name="option[???][type]" value="radio">
                                <div class="form-group">
                                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                    <label><?=$this->getTranslation('option group name')?> (<?=$l_value?>)</label>
                                    <input class="form-control" type="text" name="option[???][name][<?=$l_key?>]" value="">
                                    <?php } ?>
                                </div>
                                <div class="option-values-container">
                                    <div class="option-values-template-container">
                                        <div class="form-group option-values-template">
                                            <i class="fa fa-times option-value-remove"></i>
                                            <i class="fa fa-dot-circle-o option-value-type"></i>
                                            <div class="row">
                                                <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option value name')?> (<?=$l_value?>)</label>
                                                    <input class="form-control" type="text" name="option[???][values][0][name][<?=$l_key?>]" value="">
                                                </div>
                                                <?php } ?>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option price')?> </label>
                                                    <input class="form-control" type="text" name="option[???][values][0][price]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success option-value-add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- option radio template -->

                            <!-- option color template -->
                            <div style="display: none;" class="options-template options-template-raw options-color-template options-color-template-raw" data-type="color">
                                <i class="fa fa-times options-template-remove"></i>
                                <input type="hidden" name="option[???][type]" value="color">
                                <div class="form-group">
                                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                    <label><?=$this->getTranslation('option group name')?> (<?=$l_value?>)</label>
                                    <input class="form-control" type="text" name="option[???][name][<?=$l_key?>]" value="">
                                    <?php } ?>
                                </div>
                                <div class="option-values-container">
                                    <div class="option-values-template-container">
                                        <div class="form-group option-values-template">
                                            <i class="fa fa-times option-value-remove"></i>
                                            <i class="fa fa-dot-circle-o option-value-type"></i>
                                            <div class="row">
                                                <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option value name')?> (<?=$l_value?>)</label>
                                                    <input class="form-control" type="text" name="option[???][values][0][name][<?=$l_key?>]" value="">
                                                </div>
                                                <?php } ?>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option price')?> </label>
                                                    <input class="form-control" type="text" name="option[???][values][0][price]" value="">
                                                </div>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option color')?> </label>
                                                    <input class="form-control" type="color" name="option[???][values][0][color]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success option-value-add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- option color template -->
                            
                            <!-- option select template -->
                            <div style="display: none;" class="options-template options-template-raw options-select-template options-select-template-raw" data-type="select">
                                <i class="fa fa-times options-template-remove"></i>
                                <input type="hidden" name="option[???][type]" value="select">
                                <div class="form-group">
                                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                    <label><?=$this->getTranslation('option group name')?> (<?=$l_value?>)</label>
                                    <input class="form-control" type="text" name="option[???][name][<?=$l_key?>]" value="">
                                    <?php } ?>
                                </div>
                                <div class="option-values-container">
                                    <div class="option-values-template-container">
                                        <div class="form-group option-values-template">
                                            <i class="fa fa-times option-value-remove"></i>
                                            <i class="fa fa-dot-circle-o option-value-type"></i>
                                            <div class="row">
                                                <?php foreach($this->lang() as $l_key => $l_value){ ?>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option value name')?> (<?=$l_value?>)</label>
                                                    <input class="form-control" type="text" name="option[???][values][0][name][<?=$l_key?>]" value="">
                                                </div>
                                                <?php } ?>
                                                <div class="col-xs-4">
                                                    <label><?=$this->getTranslation('option price')?> </label>
                                                    <input class="form-control" type="text" name="option[???][values][0][price]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success option-value-add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- option select template -->
                                
                        </div>
                    </div>
                    <!-- options -->
                    
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
                        <input type="text" class="form-control"  name="meta_t[<?=$l_key?>]" id="meta_t<?=$l_key?>" value="<?=$product['meta_t'][$l_key]; ?>" />
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_d<?=$l_key?>">Meta description (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_d[<?=$l_key?>]" id="meta_d<?=$l_key?>"><?=$product['meta_d'][$l_key]; ?></textarea>
                    </div>
                    <?php } ?>

                    <?php foreach($this->lang() as $l_key => $l_value){ ?>
                    <div class="form-group">
                        <label for="meta_k<?=$l_key?>">Meta keywords (<?=$l_value?>)</label>
                        <textarea class="form-control"  name="meta_k[<?=$l_key?>]" id="meta_k<?=$l_key?>"><?=$product['meta_k'][$l_key]; ?></textarea>
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

        