				
				<div class="product news-video-one">
          <div class="product-video">
            <div class="embed-responsive embed-responsive-16by9">
              <?=htmlspecialchars_decode($value['video_code'], ENT_QUOTES)?>
            </div>
          </div>
          <div class="product-content">
            <div class="product-date">
              <?=$value['date']?>
            </div>
            <h4 class="product-name" title="<?=$value['name'][LANG_ID]?>">
              <a href="<?=$value['url']?>">
                <?=$value['name'][LANG_ID]?>
              </a>
            </h4>
          </div>
          <div class="product-view-more">
            <a href="<?=$value['url']?>"><?=$this->t('view more')?></a>
          </div>
          
        </div>

