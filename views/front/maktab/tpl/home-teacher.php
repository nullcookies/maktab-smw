<article class="content">
    <div class="title-block">
        <h3 class="title"> 
            <?=$this->t('profile', 'front')?>
        </h3>
        <p class="title-description"> <?=$this->t('view profile', 'front')?> </p>
    </div>
    <section class="section">
		<div class="card">
	        <div class="card-block">
	            <div class="card-title-block">
	                <h3 class="title">
	                    <?=$this->t('information', 'front')?>
	                </h3>
	            </div>
	            <div>
	            	<ul class="list-group">
	            		<li class="list-group-item">
	            			<?=$user->lastname?> <?=$user->firstname?> <?=$user->middlename?>
	            		</li>
	            	</ul>
	            </div>
	        </div>
	   	</div>
	</section>
    <section class="section">
		<div class="card">
	        <div class="card-block">
	            <div class="card-title-block">
	                <h3 class="title">
	                    <?=$this->t('teacher subjects', 'front')?>
	                </h3>
	            </div>
	            <div>
	            	<ul class="list-group">
	            		<?php foreach ($subjects as $value) { ?>
	            			<li class="list-group-item">
	            				<?=$value['name']?>
	            			</li>
	            		<?php } ?>
	            	</ul>
	            </div>
	        </div>
	   	</div>
	</section>
    <section class="section">
		<div class="card">
	        <div class="card-block">
	            <div class="card-title-block">
	                <h3 class="title">
	                    <?=$this->t('teacher groups', 'front')?>
	                </h3>
	            </div>
	            <div>
	            	<ul class="list-group">
	            		<?php foreach ($groups as $value) { ?>
	            			<li class="list-group-item">
	            				<?=$value['grade']?> - <?=$value['name']?> (<?=$value['start_year']?> - <?=$value['end_year']?>) 
	            			</li>
	            		<?php } ?>
	            	</ul>
	            </div>
	        </div>
	   	</div>
	</section>
</article>

