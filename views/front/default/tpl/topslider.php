        <?php if($slider){ ?>
        <!--slider-starts-->
        <div class="content-block">
          <div class="top-slider-container">
            <div id="wowslider-container1" class="top-slider">
              <div class="ws_images">
                  <ul>
                      <?php foreach($slider as $value){ ?>
                      <li>
                          <!-- <div class="top-slide"> -->
                              <a href="<?=$value['url'][LANG_ID]?>" title="<?=$value['name'][LANG_ID]?>">
                                  <img src="<?=$value['image']?>" alt="<?=$value['name'][LANG_ID]?>">
                              </a>
                          <!-- </div> -->
                      </li>
                      <?php } ?>
                  </ul>
              </div>
              <div class="ws_bullets"></div>
            </div>
          </div>
        </div>
        <!--slider-ends--> 
        <?php } ?>