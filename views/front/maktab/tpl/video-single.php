        
        <div class="content-block news-single-block">
            <?php /*if($banners){ ?>
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
            <?php }*/ ?>
            <?php
                include('breadcrumbs.php');
            ?>
            <div class="clearfix"></div>
            <div class="container">
              
                <h1 class="main-header">
                    <?=$post['name'][LANG_ID]?>
                </h1>

                

                <?php if($post['video_code']){ ?>
                <div class="content-block video-block">
                    <div class="embed-responsive embed-responsive-16by9">
                      <?=htmlspecialchars_decode($post['video_code'])?>
                    </div>
                </div>
                <?php } ?>

                <div class="content-block topic-block">
                    <div class="topic-img">
                      <img src="<?=$post['icon']?>" alt="<?=$post['name'][LANG_ID]?>">
                    </div>
                    <div class="topic-content">
                      <?=htmlspecialchars_decode($post['descr_full'][LANG_ID])?>
                    </div>
                </div>

                <?php if($post['gallery']){ ?>
                <div class="content-block gallery-block">
                    <div class="row">
                        <?php foreach($post['gallery'] as $key => $value) { ?>
                        <div class="col-6 col-sm-4 col-md-3">
                            <div class="gallery-img">
                                <a data-fancybox="gallery-news" href="<?=$value['image']?>">
                                    <img class="img-fluid" src="<?=$value['icon']?>" alt="<?=$post['name'][LANG_ID]?> <?=$key?>">
                                </a>
                            </div>
                        </div>
                        <?php } ?> 
                    </div>
                </div>
                <?php } ?>

                <div class="content-block">
                    <a href="<?=$page['url']?>">
                      <?=$page['nav_name']?>
                    </a>
                </div>


            </div>
        </div>
            