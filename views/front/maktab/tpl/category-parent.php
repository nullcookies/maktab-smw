        
        <div id="category-products" class="content-block">
          <div class="container">
            <?php
                include('breadcrumbs.php');
            ?>

            <h1 class="content-header">
              <?=$name?>
            </h1>

            <form action="<?=$categoryBaseUrlOptions?>" method="post">
              
              <input type="hidden" name="tag" value="<?=$tag_id?>">
              <input type="hidden" name="brand" value="<?=$brand_id?>">
            

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
              

              <!-- products -->
              <div class="products">
              <?php if($products){ ?>
              <ul class="product-sort-ul">
                <li>
                  <button class="order-change btn <?php if($order == 3){ ?>active<?php } ?>" data-target="3"><?=$this->translation('order 3')?></button>
                </li>
                <li>
                  <button class="order-change btn <?php if($order == 1){ ?>active<?php } ?>" data-target="1"><?=$this->translation('order 1')?></button>
                </li>
                <li>
                  <button class="order-change btn <?php if($order == 4){ ?>active<?php } ?>" data-target="4"><?=$this->translation('order 4')?></button>
                </li>
                <li>
                  <button class="order-change btn <?php if($order == 7){ ?>active<?php } ?>" data-target="7"><?=$this->translation('order 7')?></button>
                </li>
                <li>
                  <button class="order-change btn <?php if($order == 6){ ?>active<?php } ?>" data-target="6"><?=$this->translation('order 6')?></button>
                </li>
              </ul>

              
                <div class="row">
                  <?php foreach($products as $value){ ?>
                  <div class="col l4 m6 s6">
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
              <div class="mod_cat_sort mod_cat_sort_bottom">
                <div class="row">
                  <div class="col l10 m12 s12">
                    <?php if($pagination){ ?>
                    <?php
                      include('pagination.php');
                    ?>
                    <?php } ?>
                  </div>
                  <div class="col l2 m12 s12">
                    <div class="quantity-dropdown-container">
                      <a class='dropdown-button btn btn-default' data-activates='quantity-dropdown'>
                        <?=$quantity?>
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-content" id="quantity-dropdown">
                        <li><a class="quantity-change" data-target="12" href="#">12</a></li>
                        <li><a class="quantity-change" data-target="30" href="#">30</a></li>
                        <li><a class="quantity-change" data-target="60" href="#">60</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- module-sort -->
              
              

            </form>
          </div>
        </div>
        