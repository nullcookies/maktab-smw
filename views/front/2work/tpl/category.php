        <?php
            include('breadcrumbs.php');
        ?>
        <?php if($categories){ ?>
        
        <!-- categories -->
        <div class="catalogue-categories content-block">
            <div class="container">
                <div class="main-box">
                    <h1 class="category-header">
                        <?=$name?>
                    </h1>
                    <div class="main-box-content">
                        <div class="slider-container categories-full">
                            <div class="row">
                                <?php foreach($categories as $value){ ?>
                                <div class="col-sm-6 col-md-4">
                                    <?php include('category-one.php'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <span class="standard-arrow standard-next categories-next">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- /categories -->
        
        <?php $i = 0; ?>
        <?php foreach($categories as $categoryKey => $category){ ?>
        <?php if(count($category['products']) > 0){ ?>
        <!-- categories-<?=$value['id']?> -->
        <div class="category-products-list content-block <?php if($i % 2 == 0){ ?>orange-block<?php } ?>">
            <div class="container">
                <div class="main-box">
                    <h2 class="main-header">
                        <span class="main-header-text">
                            <?=$category['name'][LANG_ID]?>
                        </span>
                        <a href="<?=$category['url']?>" class="btn btn-success">
                            <?=$this->t('view category')?>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </h2>
                    <div class="main-box-content">
                        <div class="category-products-slider-container products-full" data-category-id="<?=$category['id']?>">
                            <div class="row">
                                <?php foreach($category['products'] as $value){ ?>
                                <div class="col-sm-6 col-lg-4 col-xl-3 ">
                                    <?php include('product-recommended-one.php'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <span class="standard-arrow standard-next category-products-next-<?=$category['id']?>">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- /categories-<?=$value['id']?> -->
            <?php $i++; ?>
        <?php } ?>
        <?php } ?>


        <?php } ?>

        