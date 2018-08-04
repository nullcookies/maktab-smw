<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit banner');?>
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
    
        <form id="banner-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$banner['id']?>" />
            
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
                                <label for="name<?=$l_key?>"><?=$this->getTranslation('banner name')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="name[<?=$l_key?>]" id="name<?=$l_key?>" value="<?=$banner['name'][$l_key]; ?>" />
                                <?php if($errors['name'][$l_key]) { ?>
                                    <div class="help-block"><?=$this->getTranslation($errors['name'][$l_key])?></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php foreach($this->lang() as $l_key => $l_value){ ?>
                            <div class="form-group">
                                <label for="url<?=$l_key?>"><?=$this->getTranslation('url')?> (<?=$l_value?>)</label>
                                <input type="text" class="form-control" name="url[<?=$l_key?>]" id="url<?=$l_key?>" value="<?=$banner['url'][$l_key]?>">
                            </div>
                            <?php } ?>

                            <!-- images loading -->
                            <div class="form-group">
                                <?php
                                    $uploadInputName = 'images';
                                    $uploadDirName = 'promotions';
                                ?>
                                <label for=""><?=$this->getTranslation('upload images')?></label><br>
                                <label for=""><?=$this->getTranslation('recommended size')?></label><br>
                                <label for=""></label>
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
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status"><?=$this->getTranslation('status');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="status" id="status" <?php if($banner['status']) echo " checked "; ?> />
                                </div>
                            </div>
                            <div class="form-group <?php if($errors['position']) { ?>has-error<?php } ?>">
                                <label for="position">
                                    <?=$this->getTranslation('position name')?>
                                </label>
                                <select name="position" id="position" class="selectpicker form-control">
                                    <?php if($positions) { ?>
                                    <?php foreach($positions as $value){ ?>
                                    <option value="<?=$value?>" <?php if($value == $banner['position']){ ?>selected<?php } ?>><?=$this->t('banner position ' . $value, 'back')?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if($errors['position']) { ?><div class="help-block"><?=$this->getTranslation($errors['position'])?></div><?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="sort_number"><?=$this->getTranslation('sorting')?></label>
                                <input type="text" class="form-control" name="sort_number" id="sort_number" value="<?=$banner['sort_number']; ?>" />
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
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        