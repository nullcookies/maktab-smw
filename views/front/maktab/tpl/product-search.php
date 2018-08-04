          

      <div id="category-products" >
          <?php
              include('breadcrumbs.php');
          ?>

          <div class="content-block">
              <div class="container">
                  <h1 class="main-header"><?=$this->translation('search')?></h1>
                  <form action="<?=$searchUrl?>" method="post" id="category-params-form">
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?=$search?>" >
                        <span class="input-group-append">
                          <input type="submit" class="btn btn-primary" value="<?=$this->translation('search')?>">
                        </span>
                      </div>
                    </div>
                  </form>
              </div>
          </div>
          <div class="content-block">
              <div class="container">
                  <?php if($search && $allQuantity){ ?>
                  <h2 class="main-header">
                    <?=$this->translation('found')?>: <?=$allQuantity?>
                  </h2>
                  <?php } ?>
                  <?php if($search && !$allQuantity){ ?>
                  <h3 class="main-header">
                    <?=$this->translation('nothing found')?>
                  </h3>
                  <?php } ?>
              
                  <!--products-starts-->
                  <?php if($products){ ?>
                  <div class="products products-full"> 
                  
                    <div class="row">
                      <?php foreach($products as $value){ ?>
                      <div class="col col-sm-3">
                        <?php include('product-one.php'); ?>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                   <!-- module-sort -->
                  <div class="content-block sort-block">
                    <?php if($pagination){ ?>
                    <?php
                      include('pagination.php');
                    ?>
                    <?php } ?>
                  </div>
                  <!-- module-sort -->
                  <?php } else { ?>
                  <div class="no-products">
                    <?=$this->translation('no products')?>
                  </div>
                  <?php } ?>
                 
                  <!--products-end-->
              </div>
          </div>
      </div>

        


          

