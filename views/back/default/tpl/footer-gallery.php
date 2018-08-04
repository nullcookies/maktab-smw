						
						<?php if($gallery){ ?>
							<?php foreach ($gallery as $value) { ?>
							<div class="mix-target mix-target-<?=$value['id']?> mix-category-<?=$value['file_category']?>" data-id="<?=$value['id']?>" data-id="<?=$value['path']?>">
								<img src="<?=$value['icon']?>" alt="">
							</div>
							<?php } ?>
						<?php } ?>
