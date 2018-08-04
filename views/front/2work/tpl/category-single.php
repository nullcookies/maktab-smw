        
        <div id="category-products" class="content-block">
            <?php
                include('breadcrumbs.php');
            ?>
            <div class="container">
                <h1 class="category-header">
                  <?=$this->t('toys')?> <?=$name?>
                </h1>

                <div id="category-params" class="category-params-block">
                    

                    <?php if($filters){ ?>
                    <?php
                      $colorNames = ['Цвет', 'Color', 'Rang'];
                    ?>

                    <form id="category-params-form" action="<?=$categoryBaseUrlOptions?>" method="post">

                      <input type="hidden" name="tag" value="<?=$tag_id?>">
                      <input type="hidden" name="brand" value="<?=$brand_id?>">
                      
                      <div class="row category-params-row">
                        <div class="col-md-6 col-lg-6 category-params-block-1">
                          <div class="category-params-block-1-1">
                            <?php if($categories){ ?>
                            <div class="category-params-block-dropdown">
                              <div class="filter-block-name">
                                <?=$this->t('by categories')?>
                              </div>
                              <div class="btn-group">
                                  <button class="dropdown-toggle btn btn-light" data-toggle="dropdown">
                                    <?=$currentCategory['name'][LANG_ID]?>
                                    <!-- <?=$this->t('categories')?> -->
                                  </button>
                                  <div class="dropdown-menu">
                                      <?php foreach($categories as $value){ ?>
                                      <a href="<?=$value['url']?>" class="dropdown-item <?php if($value['id'] == $currentCategory['id']){ ?>active<?php } ?>">
                                        <?=$value['name'][LANG_ID]?> (<?=$value['cnt']?>)
                                      </a>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                            
                            <?php } ?>

                            <?php if($filters[2]){ ?>
                            <div class="category-params-block-dropdown">
                              <div class="filter-block-name">
                                <?=$this->t('by set')?>:
                              </div>
                              <div class="btn-group">
                                  <button class="dropdown-toggle btn btn-light" data-toggle="dropdown">
                                    <?=$this->t('qty')?>
                                    <!-- <?=$filters[2]['name']?> -->
                                  </button>
                                  <div class="dropdown-menu">
                                      <?php foreach($filters[2]['values'] as $v){ ?>
                                      <label class="dropdown-item">
                                        <input type="checkbox" class="" name="filter[2][<?=$v['id']?>]" id="filter_<?=$v['id']?>" <?php if(in_array($v['id'], $filterValueIds)){ ?>checked<?php } ?>>
                                        <label for="filter_<?=$v['id']?>">
                                          <span class="filter-name"><?=$v['name']?></span>
                                        </label>
                                      </label>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                            <?php unset($filters[2]); ?>
                            <?php } ?>

                          </div>
                          <div class="category-params-block-1-2">
                            <?php if($filters[5]){ ?>
                            <div class="category-params-block-list">
                              <div class="filter-block-name">
                                <?=$this->t('by age')?>:
                              </div>
                              <ul class="category-params-block-list-ul">
                                  <?php foreach($filters[5]['values'] as $v){ ?>
                                  <li>
                                    <input type="checkbox" class="" name="filter[5][<?=$v['id']?>]" id="filter_<?=$v['id']?>" <?php if(in_array($v['id'], $filterValueIds)){ ?>checked<?php } ?>>
                                    <label for="filter_<?=$v['id']?>">
                                      <span class="filter-name"><?=$v['name']?></span>
                                    </label>
                                  </li>
                                  <?php } ?>
                              </ul>
                            </div>
                            <?php unset($filters[5]); ?>
                            <?php } ?>
                          </div>
                          
                        </div>
                        <div class="col-md-3 col-lg-3 category-params-block-2">
                          <?php if($filters[1]){ ?>
                            <div class="category-params-block-color-list">
                              <div class="filter-block-name">
                                <?=$this->t('by color')?>:
                              </div>
                              <ul class="category-params-block-color-list-ul">
                                  <?php foreach($filters[1]['values'] as $v){ ?>
                                  <li>
                                    <input type="checkbox" class="" name="filter[1][<?=$v['id']?>]" id="filter_<?=$v['id']?>" <?php if(in_array($v['id'], $filterValueIds)){ ?>checked<?php } ?>>
                                    <label for="filter_<?=$v['id']?>" style="background-color: <?=$v['color']?>" title="<?=$v['name']?>"></label>
                                  </li>
                                  <?php } ?>
                              </ul>
                            </div>
                            <?php unset($filters[1]); ?>
                            <?php } ?>
                        </div>
                        <div class="col-md-3 col-lg-3 category-params-block-3">
                            <div class="category-params-block-price">
                              <div class="filter-block-name">
                                <?=$this->t('by price')?>:
                              </div>
                              <div class="range-slider-container">
                                <input name="price_range" id="price_range" type="text" 
                                  data-min="<?=$categoryPriceRange[0]?>" 
                                  data-max="<?=$categoryPriceRange[1]?>" 
                                  <?php if($selectedPriceRange){ ?>
                                  data-from="<?=$selectedPriceRange[0]?>" 
                                  data-to="<?=$selectedPriceRange[1]?>" 
                                  <?php } ?>
                                >
                              </div>

                              
                            </div>
                        </div>
                      </div>

                      

                      

                      <!-- <div class="filters-list">
                        
                        <?php foreach($filters as $value){ ?>
                        <div class="filter-block">
                          <h3 class="filter-block-name">
                            <?=$value['name']?>:
                          </h3>
                          <ul class="filter-block-ul">
                            <?php foreach($value['values'] as $v){ ?>
                            <li class="filter-block-li">
                              <input type="checkbox" class="" name="filter[<?=$v['id']?>]" id="filter_<?=$v['id']?>" <?php if(in_array($v['id'], $filterValueIds)){ ?>checked<?php } ?>>
                              <label for="filter_<?=$v['id']?>">
                                <span class="filter-name"><?=$v['name']?></span>
                              </label>
                            </li>
                            <?php } ?>
                          </ul>
                        </div>
                        <?php } ?>

                        
                        

                      </div> -->

                      <button style="display:none;" title="<?=$this->translation('apply')?>" type="submit" class="filter-btn btn btn-success">
                        <i class="fa fa-check"></i>
                      </button>
                    </form>
                    <?php } ?>

                    <?php /*if($brands){ ?>
                    <div class="left-block">
                      <div class="left-box">
                        <h3 class="left-block-header">
                          <?=$this->translation('manufacturers')?>
                        </h3>
                        <div class="brands-list">
                          <?php foreach($brands as $value){ ?>
                          <a class="brands-list-item <?php if($value['id'] == $brand_id){ ?>active<?php } ?>" href="<?=$value['url']?>" >
                            <?=$value['name'][LANG_ID]?>
                          </a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <?php } ?>

                    <?php if($tags){ ?>
                    <?php
                    shuffle($tags);
                    ?>
                    <div class="left-block">
                      <div class="left-box">
                        <h3 class="left-block-header">
                          <?=$this->translation('tags')?>
                        </h3>
                        <div class="filter-tags">
                          <?php foreach($tags as $value){ ?>
                          <?php 
                            $fontSize = floor($value['cnt'] / 1) + 15;
                            if($fontSize > 24){
                              $fontSize = 24;
                            }
                          ?>
                          <a style="font-size:<?=$fontSize?>px;" class="dark-text <?php if($value['id'] == $tag_id){ ?>active<?php } ?>" href="<?=$categoryBaseUrl?>?tag=<?=$value['id']?>" >
                            <?=$value['name']?>
                          </a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <?php } */?>

                </div>

                <?php if($filterValueIds){ ?>
                <div class="filter-clear-block">
                  <a href="<?=$categoryBaseUrl?>" class="text-danger filter-clear-btn">
                    <i class="fa fa-times"></i>
                    <?=$this->translation('clear filter')?>
                  </a>
                </div>
                <?php } ?>

                <form action="<?=$categoryBaseUrlOptions?>" method="post">
                  
                  <input type="hidden" name="tag" value="<?=$tag_id?>">
                  <input type="hidden" name="brand" value="<?=$brand_id?>">
                

                  <?php /*if($categories){ ?>
                  <!-- subcategories -->
                  <div class="mod_cat_desc_main">
                    <ul>
                      <?php foreach($categories as $value){ ?>
                      <li>
                        <a href="<?=$value['url']?>" title="<?=$value['name'][LANG_ID]?>">
                          <?=$value['name'][LANG_ID]?> (<?=$value['cnt']?>)
                        </a>
                      </li>
                      <?php } ?>
                    </ul>
                  </div>
                  <!-- subcategories -->
                  <?php }*/ ?>
                  
                  <?php if($products){ ?>

                  <?php 
                  /*

                  */
                  ?>
                  <div class="product-sort-group btn-group d-none">
                      <button class="order-change btn btn-light <?php if($order == 3){ ?>active<?php } ?>" data-target="3"><?=$this->translation('order 3')?></button>
                      <button class="order-change btn btn-light <?php if($order == 1){ ?>active<?php } ?>" data-target="1"><?=$this->translation('order 1')?></button>
                      <button class="order-change btn btn-light <?php if($order == 4){ ?>active<?php } ?>" data-target="4"><?=$this->translation('order 4')?></button>
                      <button class="order-change btn btn-light <?php if($order == 7){ ?>active<?php } ?>" data-target="7"><?=$this->translation('order 7')?></button>
                      <button class="order-change btn btn-light <?php if($order == 6){ ?>active<?php } ?>" data-target="6"><?=$this->translation('order 6')?></button>
                  </div>

                  <!-- products -->
                  <div class="products products-full">
                  
                    <div class="row">
                      <?php foreach($products as $value){ ?>
                      <div class="col-sm-6 col-lg-4 col-xl-3">
                        <?php include('product-one.php'); ?>
                      </div>
                      <?php } ?>
                    </div>
                  
                    <!-- products -->
                    <?php } else { ?>
                    <div class="no-products">
                      <?=$this->translation('no products')?>
                    </div>
                  <?php } ?>
                  </div>

                  
                  <!-- module-sort -->
                  <div class="content-block sort-block">
                    <div class="row">
                      <div class="col-sm-10">
                        <?php if($pagination){ ?>
                        <?php
                          include('pagination.php');
                        ?>
                        <?php } ?>
                      </div>
                      <div class="col-sm-2">
                        <div class="quantity-per-page">
                          <div class="btn-group">
                            <a class='dropdown-toggle btn btn-light' data-toggle="dropdown" >
                              <?=$quantity?>
                              <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                              <li><a class="quantity-change dropdown-item" data-target="12" href="#">12</a></li>
                              <li><a class="quantity-change dropdown-item" data-target="40" href="#">40</a></li>
                              <li><a class="quantity-change dropdown-item" data-target="100" href="#">100</a></li>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- module-sort -->
                  
                  

                </form>
            </div>
            

                
        </div>
        