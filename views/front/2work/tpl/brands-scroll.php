        
        <?php if($brands){ ?>
        <div id="brands-slider-container">
          <div class="container">
            <div class="brands-slider">
              <?php foreach($brands as $value){ ?>
              <div class="brands-slide">
                <a title="<?=$value['name'][LANG_ID]?>" href="<?=$value['url']?>">
                  <img src="<?=$value['icon']?>" alt="<?=$value['name'][LANG_ID]?>">
                </a>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>
