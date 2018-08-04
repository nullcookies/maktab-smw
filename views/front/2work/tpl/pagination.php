			
			<?php if($pagination){ ?>
			<?php
				$buttons = [];
				//$buttons[] = $pagination['first'];
				$buttons[] = $pagination['prev'];
				for($i = 0; $i < count($pagination['pages']); $i++){
					$buttons[] = $pagination['pages'][$i];
				}
				$buttons[] = $pagination['next'];
				//$buttons[] = $pagination['last'];
			?>
			<nav>
			<ul class="pagination">
				<?php foreach ($buttons as $value){ ?>
				<?php
					$name = str_replace(['prev', 'next', 'first', 'last'], ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-double-left"></i>', '<i class="fa fa-angle-double-right"></i>'], $value['name']);
				?>
				<li class="page-item <?=( ($value['active']) ? 'active' : (($value['disabled']) ? 'disabled' : '' ) )?>">
					<?php if(!$value['active'] && !$value['disabled']){?>
					<a class="page-link pagination-link" href="<?=$value['url']?>"><?=$name?></a>
					<?php } else { ?>
					<a class="page-link pagination-disabled" href="#"><?=$name?></a>
					<?php } ?>
				</li>
				<?php  } ?>
			</ul>
			</nav>
			<?php } ?>
