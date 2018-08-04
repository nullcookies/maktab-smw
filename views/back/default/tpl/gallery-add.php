<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('add gallery file');?>
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
        
        <form id="gallery-file-add-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            
                            
                            <!-- images loading -->
                            <div class="form-group">
                                <?php
                                    $uploadInputName = 'images';
                                ?>
                                <label for=""><?=$this->getTranslation('upload images')?></label><br>
                                <label for=""><?=$this->getTranslation('recommended size')?></label><br>
                                <label><?=$this->getTranslation('file category product')?> - <?=$recommendedSizeProduct?></label><br>
                                <label><?=$this->getTranslation('file category category')?> - <?=$recommendedSizeCategory?></label><br>
                                <label><?=$this->getTranslation('file category brand')?> - <?=$recommendedSizeCategory?></label><br>
                                <label><?=$this->getTranslation('file category post')?> - <?=$recommendedSizePost?></label>

                                <div id="loaded-<?=$uploadInputName?>"></div>
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
                                            //console.log(data);
                                        });
                                    }
                                    $(document).ready(function(){
                                    	var uploadUrl = '/<?=$this->config['adminAccess']?>/file/upload/image/' + $('#upload_dir_name option:selected').val() + '/';
                                    	var multipleImageFileinput = $('.multiple-image-fileinput');
                                    	var multipleImageFileinputInit = function(){
                                    		multipleImageFileinput.fileinput({
	                                          theme: "explorer",
	                                          language: "ru",
	                                          uploadUrl: uploadUrl,
	                                          uploadAsync: true,
	                                          maxFileCount: 100,
	                                          showRemove: false,
	                                          allowedFileTypes: ["image"],
	                                          allowedFileExtensions: ["jpg", "gif", "png"],
	                                          overwriteInitial: false,
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
                                    	}
                                    	multipleImageFileinputInit();

                                    	$('#upload_dir_name').on('change', function(){
                                    		uploadUrl = '/<?=$this->config['adminAccess']?>/file/upload/image/' + $(this).val() + '/';
                                    		if (multipleImageFileinput.data('fileinput')) {
									            multipleImageFileinput.fileinput('destroy');
									            multipleImageFileinputInit();
									        }
                                    	});

                                    	
                                    	
                                    });
                                </script>
                            </div>
                            <!-- images loading -->
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">

                            <!-- file category dir -->
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('product category')?></label>
                                <select name="upload_dir_name" id="upload_dir_name" class="form-control selectpicker">
                                    <option value="common" selected><?=$this->getTranslation('file category common')?></option>
                                    <option value="product"><?=$this->getTranslation('file category product')?></option>
                                    <option value="category"><?=$this->getTranslation('file category category')?></option>
                                    <option value="brand"><?=$this->getTranslation('file category brand')?></option>
                                    <option value="post"><?=$this->getTranslation('file category post')?></option>
                                </select>
                            </div>
                            <!-- file category -->

                        </div>
                    </div>

                </div>
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        