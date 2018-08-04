          
        <div class="content-block news-list-block">
            <?php if($banners){ ?>
            <div class="promotion-block">
              <div class="container">
                <div class="news-promotion-block">
                  <?php 
                      shuffle($banners); 
                      $banner = $banners[0];
                  ?>
                  <a href="<?=$banner['url'][LANG_ID]?>">
                    <img class="img-fluid" src="<?=$banner['icon']?>" alt="<?=$banner['name'][LANG_ID]?>">
                  </a>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php
                include('breadcrumbs.php');
            ?>
            <div class="container">
                <h1 class="main-header">
                  <?=$textName?>
                </h1>
                <?php if($posts){ ?>
                <div class="news-full">
                    <div class="row">
                      <?php foreach($posts as $value){ ?>
                      <div class="col-sm-6 col-lg-4 col-xl-3">
                        <?php include($typeName . '-one.php'); ?>
                      </div>
                      <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <?php
                include('pagination.php');
            ?>
            </div>
            
              
            
        </div>
