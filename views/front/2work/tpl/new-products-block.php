                
                <?php if($newProducts){ ?>
                <!-- new-products-block -->
                <div class="new-products-block orange-block">
                    <div class="container">
                        <h2 class="main-header">
                            <span class="main-header-text">
                                <?=$this->t('new toy sets')?>
                            </span>
                            <a href="<?=$categoryPage['url']?>" class="btn btn-success">
                                <?=$this->t('all products')?>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </h2>
                        <div class="slider-container products-full">
                            <div class="row">
                                <?php foreach($newProducts as $value){ ?>
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <?php include('product-recommended-one.php'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <span class="standard-arrow standard-next new-products-block-next">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /new-products-block -->
                <?php } ?>