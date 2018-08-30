
  	<!-- Main Footer -->
  	<footer class="main-footer">

		<script>
			var updateProductAddedGalleryTimeout;
			var updatedProductAddedGallery = false;
			function loadGallery(){
				$.ajax({
					url: '<?=$loadGalleryUrl?>',
					beforeSend: function(){}
				})
				.done(function(data){
					$('.mix-gallery-container').addClass('loaded').html(data);
				})
				.fail(function(data){

				});
			}
			function updateProductAddedGallery(){
				
				updateProductAddedGalleryTimeout = setTimeout(function(){
					if(!updatedProductAddedGallery){
						if(!$('.mix-gallery-container').hasClass('loaded')){
							loadGallery();
							updateProductAddedGallery();
						}
						else{
							updatedProductAddedGallery = true;
							$('.added-from-gallery').each(function(){
								var fileId = $(this).data('id');
								var mixTargetBlockImg = $('.mix-target-' + fileId + ' img');
								if(mixTargetBlockImg.length){
									var currentImg = mixTargetBlockImg.eq(0).clone();
									$(this).find('img').remove();
									$(this).append(currentImg);
								}
							});
						}
							
					}
					else{
						clearTimeout(updateProductAddedGalleryTimeout);
					}
				}, 500);
				
			}

			$(document).ready(function(){
					
				$('#gallery-modal-block').on('show.bs.modal', function(){
					if(!$('.mix-gallery-container').hasClass('loaded')){
						loadGallery();
					}
				});
				$('#gallery-modal-block').on('shown.bs.modal', function(){
					mixitup('.mix-gallery-container', {
					  	load: {
					    	filter: 'all',
					    	sort: 'default:asc'
					  	},
					  	animation: {
						    effects: 'fade rotateZ(-180deg)',
						    duration: 600
					  	},
					  	classNames: {
						    block: 'mix-gallery-container',
						    elementFilter: 'mix-filter-btn',
						    elementSort: 'mix-sort-btn'
					  	},
					  	selectors: {
					    	target: '.mix-target'
					  	}
					});

					$('.mix-filter-btn-default').trigger('click');
				});

				$('body').on('click', '.mix-target', function(){
					var currentFileBlock = $(this);
					var galleryBlock = $('#added-from-gallery-container');
					var fileId = currentFileBlock.data('id');
					if(galleryBlock.length && fileId > 0){
						if($('.added-from-gallery-' + fileId).length){
							$('.added-from-gallery-' + fileId).remove();
						}
						if(!currentFileBlock.hasClass('active')){
							galleryBlock.append('<div class="added-from-gallery added-from-gallery-' + fileId + '" data-id="' + fileId + '"><i class="fa fa-times added-from-gallery-remove"></i></div>');
							currentAddedBlock = $('.added-from-gallery-' + fileId);
							currentFileBlock.find('img').eq(0).clone().appendTo(currentAddedBlock);
							currentAddedBlock.append('<input type="hidden" name="images_gallery[]" value="' + fileId + '" />');
							currentFileBlock.addClass('active');
						}
						else{
							currentFileBlock.removeClass('active');
						}
						
					}
				});
				$('body').on('click', '.added-from-gallery-remove', function(){
					var currentBlock = $(this).closest('.added-from-gallery');
					if(currentBlock.length){
						var fileId = currentBlock.data('id');
						$('.mix-target-' + fileId).removeClass('active');
						currentBlock.remove();
					}
				});

				if($('.added-from-gallery').length){
					updateProductAddedGallery();
				}
			});
		</script>
  		<div id="gallery-modal-block" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><?=$this->getTranslation('gallery')?></h4>
					</div>
					<div class="modal-body">
						<?php if($gallery){ ?>
						<h4><?=$this->getTranslation('filter')?></h4>
						<div class="btn-group">
							
							<button class="btn btn-default mix-filter-btn mix-filter-btn-default" data-filter="all"><?=$this->getTranslation('all')?></button>
							<button class="btn btn-default mix-filter-btn" data-filter=".mix-category-brand"><?=$this->getTranslation('brand')?></button>
							<button class="btn btn-default mix-filter-btn" data-filter=".mix-category-category"><?=$this->getTranslation('category')?></button>
							<button class="btn btn-default mix-filter-btn" data-filter=".mix-category-product"><?=$this->getTranslation('product')?></button>
							<button class="btn btn-default mix-filter-btn" data-filter=".mix-category-post"><?=$this->getTranslation('post')?></button>
							<button class="btn btn-default mix-filter-btn" data-filter=".mix-category-common"><?=$this->getTranslation('common jen')?></button>
						</div>

						<!-- <h4><?=$this->getTranslation('sort')?></h4>
						<div class="btn-group">
							<button class="btn btn-default mix-sort-btn" data-sort="default:asc"><?=$this->getTranslation('default')?></button>
							<button class="btn btn-default mix-sort-btn" data-sort="id:asc">ID <i class="fa fa-arrow-up"></i></button>
							<button class="btn btn-default mix-sort-btn" data-sort="id:desc">ID <i class="fa fa-arrow-down"></i></button>

						</div> -->
							
						<!-- mix-gallery-container content added when modal shown script.js -->
						<div class="mix-gallery-container"></div>
						<?php } ?>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->getTranslation('close')?></button>
					</div>
				</div>

			</div>
		</div>


	    <!-- To the right -->
	    <div class="pull-right hidden-xs">
	      Version <?=PROJECT_VERSION?>
	    </div>
	    <!-- Default to the left -->
    	<strong>&copy; <?php echo date("Y"); ?> <a target="_blank" href="http://zipwolf.uz/">Zipwolf</a></strong>
  	</footer>


