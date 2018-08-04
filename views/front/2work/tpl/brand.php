          
      <div class="content-block">
          <?php
              include('breadcrumbs.php');
          ?>
          <div class="container">
              <h1 class="category-header">
                <?=$name?>
              </h1>

              <?php if($brands){ ?>
              <div class="content-block">
                  <div class="brands">
                    <div class="row">
                      <?php foreach($brands as $value){ ?>
                      <div class="col-sm-6 col-lg-4 col-xl-3">
                        <?php include('brand-one.php'); ?>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
              </div>
              <?php } ?>
            
              <?php if($textName || $textContent){ ?>
              <div class="content-block" >
                <div class="main-box">
                  <h2 class="main-header"><?=$textName?></h2>
                  <div class="main-box-text">
                    <?=$textContent?>
                  </div>
                </div>
              </div>
              <?php } ?>
          </div>
      </div>

