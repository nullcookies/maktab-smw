				
				<div class="product news-big-one">
          <div class="product-big-img">
            <a title="<?=$value['name'][LANG_ID]?>" href="<?=$value['url']?>">
              <img class="img-fluid" src="<?=$value['icon_big']?>" alt="<?=$value['name'][LANG_ID]?>">
            </a>
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

