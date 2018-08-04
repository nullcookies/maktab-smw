        
        <div id="category-products" class="content-block">

            <?php
                include('breadcrumbs.php');
            ?>
            <div class="container">

                <h1 class="main-header">
                  <?=$name?>
                </h1>

                <form action="<?=$currentBaseUrlOptions?>" method="post">
                  
                  <input type="hidden" name="order" value="<?=$order?>">
                  <input type="hidden" name="quantity" value="<?=$quantity?>">
                

                  <?php
                  /*
                  <?php if($categories){ ?>
                  <!-- subcategories -->
                  <div class="mod_cat_desc_main">
                    <ul class="brand-cats">
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
                  <?php } ?>
                  */
                  ?>
                  

                  <!-- products -->
                  <div class="products products-full">
                  <?php if($products){ ?>

                  <?php 
                  /*
                  <ul class="product-sort-ul">
                    <li>
                      <button class="order-change btn waves-effect <?php if($order == 1){ ?>active<?php } ?>" data-target="1"><?=$this->translation('order 1')?></button>
                    </li>
                    <li>
                      <button class="order-change btn waves-effect <?php if($order == 3){ ?>active<?php } ?>" data-target="3"><?=$this->translation('order 3')?></button>
                    </li>
                    <li>
                      <button class="order-change btn waves-effect <?php if($order == 4){ ?>active<?php } ?>" data-target="4"><?=$this->translation('order 4')?></button>
                    </li>
                  </ul>
                  */ 
                  ?>

                  
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
                      </div>
                  </div>

                  <?php
                  /*
                  
                  <!-- module-sort -->
                  <div class="mod_cat_sort mod_cat_sort_bottom">
                    <div class="row">
                      <div class="col l10 m9 s12">
                        <?php if($pagination){ ?>
                        <?php
                          include('pagination.php');
                        ?>
                        <?php } ?>
                      </div>
                      <div class="col l2 m3 s12">
                        <div class="quantity-dropdown-container">
                          <a class='dropdown-button btn btn-default' data-activates='quantity-dropdown'>
                            <?=$quantity?>
                            <span class="caret"></span>
                          </a>
                          <ul class="dropdown-content" id="quantity-dropdown">
                            <li><a class="quantity-change" data-target="1" href="#">1</a></li>
                            <li><a class="quantity-change" data-target="10" href="#">10</a></li>
                            <li><a class="quantity-change" data-target="20" href="#">20</a></li>
                            <li><a class="quantity-change" data-target="50" href="#">50</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- module-sort -->
                  */
                  ?>
                </form>
            </div>
        </div>
        