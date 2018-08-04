    
        <div class="product-details-page item_content">
          <?php
            include('breadcrumbs.php');
          ?>
          <div class="container">
            <?php /*
            <div class="product-next-prev">
              <?php if($prevProduct){ ?>
              <a href="<?=$prevProduct['url']?>" title="<?=$prevProduct['name'][LANG_ID]?>" class="product-nav product-prev">
                <i class="fa fa-angle-left"></i>
              </a>
              <?php } else { ?>
              <span class="product-nav product-prev disabled">
                <i class="fa fa-angle-left"></i>
              </span>
              <?php } ?>

              <?php if($nextProduct){ ?>
              <a href="<?=$nextProduct['url']?>" title="<?=$nextProduct['name'][LANG_ID]?>" class="product-nav product-next">
                <i class="fa fa-angle-right"></i>
              </a>
              <?php } else { ?>
              <span class="product-nav product-next disabled">
                <i class="fa fa-angle-right"></i>
              </span>
              <?php } ?>
            </div>
            */ ?>
            <div class="product-details-container">
                <form method="post" action="<?=$addCartUrl?>">
                  <div class="row product-details-row">
                    

                    <div class="col-md-6 order-md-1 order-2 product-left-container">
                      
                      <?php 
                          if($product['gallery']) { 
                            $mainImage = array_shift($product['gallery']);
                      ?>
                      <div class="product-details-image">
                        <a data-fancybox="gallery" href="<?=$mainImage['image']?>">
                          <img class="img-fluid" src="<?=$mainImage['icon_large']?>" alt="<?=$name?>">
                        </a>
                      </div>
                      <?php } ?> 

                      <?php if($product['video_code']){ ?>
                      <div class="product-details-video">
                        <div class="embed-responsive embed-responsive-16by9">
                          <?=htmlspecialchars_decode($product['video_code'], ENT_QUOTES)?>
                        </div>
                      </div>
                      <?php } ?>

                    </div>
                    <!-- /order-1 -->

                    <div class="col-md-6 order-md-2 order-1">
                      <h1 class="product-header">
                        <?=$name?>
                        <?php /*<?=$categoryName?>*/ ?>
                      </h1>
                      <div class="product-header-info">
                        <?php if($brand['name'][LANG_ID]){ ?>
                        <?=$this->translation('from brand')?> <a href="<?=$brand['url']?>"><?=$brand['name'][LANG_ID]?></a>
                        <?php } ?>
                        <span class="sku" itemprop="sku">SKU #: <?=$product['sku']?></span>
                      </div>

                      <div class="product-details-price">
                        <?php if($product['request_product']){ ?>
                        <div></div>
                        <?php } else { ?>
                          <div class="prod-price-top">
                            <span class="current-price">
                              <?=$this->formatPrice($product['price_show'])?>
                            </span>
                            <?php if($product['discount'] > 0){ ?>
                            <span class="old-price">
                              <?=$this->formatPrice($product['price_old'])?>
                            </span>
                            &nbsp;
                            <span class="price-discount">
                              <?=$this->t('discount')?>
                              <?=$product['discount']?>%
                            </span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                      <?php if($product['descr'][LANG_ID]){ ?>
                      <div class="product-descr-short">
                        <h4><?=$this->t('product description short')?></h4>
                        <?=$product['descr'][LANG_ID]?>
                      </div>
                      <?php } ?>

                      <div class="product-options">
                        <?php if($product['options']){ ?>
                          <?php foreach($product['options'] as $key => $value){ ?>
                          <div class="product-option-container product-option-<?=$value['type']?>-container">
                            <h5 class="product-option-header">
                              <?=$value['name'][LANG_ID]?>:
                            </h5>
                            <!-- option values -->
                            <?php if($value['type'] == 'radio'){ ?>
                              <?php $firstOption = true; ?>
                            <?php foreach($value['values'] as $key1 => $value1){ ?>
                            <span class="product-option-radio">
                              <input class="product-option-input" data-price="<?=$value1['price']?>" name="option[<?=$key?>]" type="radio" id="option-<?=$key?>-<?=$key1?>" value="<?=$key1?>" <?php if($firstOption){ ?>checked<?php } ?> />
                              <label for="option-<?=$key?>-<?=$key1?>"><?=$value1['name'][LANG_ID]?></label>
                            </span>
                              <?php  $firstOption = false; ?>
                            <?php } ?>
                            <?php } elseif($value['type'] == 'color'){ ?>
                              <?php $firstOption = true; ?>
                            <?php foreach($value['values'] as $key1 => $value1){ ?>
                            <span class="product-option-color">
                              <input class="product-option-input" data-price="<?=$value1['price']?>" name="option[<?=$key?>]" type="radio" id="option-<?=$key?>-<?=$key1?>" value="<?=$key1?>" <?php if($firstOption){ ?>checked<?php } ?> />
                              <label class="<?php if(in_array(strtolower($value1['color']), $lightColors)){ ?>option-light-color<?php } ?>" for="option-<?=$key?>-<?=$key1?>" title="<?=$value1['name'][LANG_ID]?>" style="background-color:<?=$value1['color']?>;"></label>
                            </span>
                              <?php  $firstOption = false; ?>
                            <?php } ?>
                            <?php } elseif($value['type'] == 'select'){ ?>
                            <select class="product-option-select" name="option[<?=$key?>]" id="option-<?=$key?>">
                              <?php foreach($value['values'] as $key1 => $value1){ ?>
                              <option data-price="<?=$value1['price']?>" id="option-<?=$key?>-<?=$key1?>" value="<?=$key1?>">
                                <?=$value1['name'][LANG_ID]?>
                              </option>
                              <?php } ?>
                            </select>
                            <?php } ?>
                            <!-- option values -->

                          </div>
                          <?php } ?>
                        <?php } ?>
                      </div>

                      <div class="product-addtocart">
                          <?php if($product['request_product']){ ?>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="input-field">
                                  <input class="form-control" name="fio" id="form-fio" type="text" placeholder="<?=$this->translation('your name')?>">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="input-field">
                                  <input class="form-control" name="email" id="form-email" type="text" placeholder="<?=$this->translation('your email')?>">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="input-field">
                                  <input class="form-control" name="phone" id="form-phone" type="text" placeholder="<?=$this->translation('your phone')?>">
                                </div>
                              </div>
                            </div>
                            <br>
                            <div>
                              <input type="hidden" class="item_quantity" name="item_quantity" value="1">
                              <input type="hidden" name="confirm_checkout" value="1">
                              <button type="submit" class="item_request btn waves-effect waves-light" data-target="<?=$requestProductUrl?>" data-pid="<?=$product['id']?>">
                                <?=$this->translation('send request')?>
                              </button>
                            </div>
                            <div class="modal" id="request-end-<?=$product['id']?>">
                                <div class="modal-content">
                                  <h4 class="result-text"></h4>
                                </div>
                            </div>
                              
                          <?php } else { ?>
                            <div class="row">
                              <div class="col-sm-6 order-sm-2" style="display:none;">
                                <div class="product_quantity product_quantity_btns">
                                  <span class="btn btn-default item_quantity_minus">-</span>
                                  <input class="form-control item_quantity" data-max-quantity="30" name="item_quantity" value="1" type="text">
                                  <span class="btn btn-default item_quantity_plus">+</span>
                                </div>
                              </div>
                              <div class="col-sm-6 order-sm-1">
                                <button type="submit" class="item_add addToCartButton btn btn-primary" data-target="<?=$addCartUrl?>" data-pid="<?=$product['id']?>">
                                  <?=$this->translation('add to cart')?>
                                </button>
                              </div>
                            </div>
                          
                          <?php } ?>
                      </div>

                      <?php if($product['gallery']) { ?>
                      <div class="product-details-gallery">
                        <?php foreach($product['gallery'] as $key => $value) { ?>
                          <a data-fancybox="gallery" href="<?=$value['image']?>">
                            <img class="img-fluid" src="<?=$value['icon_small']?>" alt="<?=$name . ' - ' . $key?>">
                          </a>
                        <?php } ?>
                      </div>
                      <?php } ?> 

                      <div class="product-details-full-description">
                        <h2 class="main-header">
                          <?=$this->translation('product details')?>
                        </h2>
                        <?=htmlspecialchars_decode($product['descr_full'][LANG_ID], ENT_QUOTES)?>
                          <br>
                          <i>SKU: <strong><?=$product['sku']?></strong></i>
                      </div>

                    </div>
                    <!-- /order-2 -->

                  </div>
                </form>
            </div>
            
            
             
            <?php /* if($brand){ ?>
            <!-- product manufacturer -->
            <div class="content-block">
              <div class="main-box">
                <h3 class="product-small-header">
                  <?=$this->translation('manufacturer details')?>
                </h3>
                <div class="product-brand">
                    <div class="product-brand-img">
                      <a href="<?=$brand['url']?>">
                        <img src="<?=$brand['icon']?>" alt="<?=$brand['name'][LANG_ID]?>">
                      </a>
                    </div>
                    <div class="product-brand-content">
                      <div class="product-brand-descr">
                        <?=$brand['descr'][LANG_ID]?>
                      </div>
                      <div class="product-brand-more">
                        <a class="btn btn-sm btn-default waves-effect" href="<?=$brand['url']?>"><?=$brand['name'][LANG_ID]?></a>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <!-- product manufacturer -->
            <?php } */ ?>
            
            <!-- product reviews -->
            <div class="product-reviews-block content-block" style="display:none;">
                
                <h2 class="main-header">
                  <?=$this->translation('happy customer reviews')?>
                </h2>
                <div class="reviews">
                <?php if($reviews){ ?>
                  <?php foreach($reviews as $value){ ?>
                  <div class="review">
                    <h4 class="review-header"><?=$value['name']?></h4>
                    <div class="review-content"><?=$value['message']?></div>
                    <div class="review-date"><?=date('Y-m-d', $value['date_add'])?></div>
                  </div> 
                  <?php } ?>
                <?php } else { ?>
                <?=$this->translation('no reviews')?>
                <?php } ?>
                </div>
                <br>
                <br>
              
                <h4>
                  <?=$this->translation('add review')?>
                </h4>
                <form class="product-reviews-form" action="<?=$addReviewUrl?>" method="post">
                  <input type="hidden" name="product_id" value="<?=$product['id']?>">

                  <div class="form-group">
                    <input id="review_name" class="form-control" type="text" name="name" value="<?php if(isset($user['firstname'])){ echo $user['firstname']; }?>" placeholder="<?=$this->translation('your name')?>" >
                  </div>
                  
                  <div class="form-group">
                    <input id="review_email" class="form-control" type="text" name="email" value="<?php if(isset($user['email'])){ echo $user['email']; }?>" placeholder="<?=$this->translation('your email')?>" >
                  </div>

                  <div class="form-group">
                    <textarea id="review_message" class="form-control" name="message" placeholder="<?=$this->translation('review')?>"></textarea>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="review-submit-btn btn btn-success">
                      <?=$this->translation('send')?>
                    </button>
                  </div>
                    
                </form>
            </div>


            <?php if($upsells){ ?>
            <!-- similar products -->
            <div class="content-block up-products-block">
                <h2 class="main-header">
                  <?=$this->translation('upsell products')?>
                </h2>
                <div class="slider-container products-full">
                    <div class="row">
                        <?php foreach($upsells as $value){ ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <?php include('product-one.php'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <span class="standard-arrow standard-next up-products-block-next">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </div>
            </div>
            <!-- /similar products -->
            <?php } elseif($similarProducts){ ?>
            <!-- similar products -->
            <div class="content-block similar-products-block">
                <h2 class="main-header">
                  <?=$this->translation('similar products')?>
                </h2>
                <div class="slider-container products-full">
                    <div class="row">
                        <?php foreach($similarProducts as $value){ ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <?php include('product-one.php'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <span class="standard-arrow standard-next similar-products-block-next">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </div>
            </div>
            <!-- /similar products -->
            <?php } ?>

            <?php if($crosssells){ ?>
            <!-- cross products -->
            <div class="content-block cross-products-block">
                <h2 class="main-header">
                  <?=$this->translation('cross products')?>
                </h2>
                <div class="slider-container products-full">
                    <div class="row">
                        <?php foreach($crosssells as $value){ ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <?php include('product-one.php'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <span class="standard-arrow standard-next cross-products-block-next">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </div>
            </div>
            <!-- /cross products -->
            <?php } ?>


          </div>
        </div>
