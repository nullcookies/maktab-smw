                <?php if($newProducts){ ?>
                <div class="side-block">
                    <div class="side-box">
                        <h3 class="side-block-header">
                          <?=$this->translation('new products')?>
                        </h3>
                        <div class="side-block-content">
                          <?php foreach($newProducts as $value){ ?>
                          <div class="side-product">
                              <div class="side-product-img">
                                  <a href="<?=$value['url']?>">
                                      <img src="<?=$value['icon']?>" alt="<?=$value['name'][LANG_ID]?>">
                                  </a>
                              </div>
                              <div class="side-product-content">
                                  <h4 class="side-product-name" title="<?=$value['name'][LANG_ID]?>">
                                      <a href="<?=$value['url']?>"><?=$value['name'][LANG_ID]?></a>
                                  </h4>
                                  <div class="side-product-current-price">
                                    <?=number_format($value['price_show'], 0, ',', '.')?>&nbsp;<?=$this->translation($this->getOption('currency'))?>
                                  </div>
                                  <?php if($value['discount'] > 0){ ?>
                                  <div class="side-product-old-price">
                                    <?=number_format($value['price_old'], 0, ',', '.')?>&nbsp;<?=$this->translation($this->getOption('currency'))?>
                                  </div>
                                  <?php } ?>
                              </div>
                          </div>
                          <?php } ?>
                          <!-- <div>
                            <a href="#">
                              <?=$this->translation('view all products')?>
                            </a>
                          </div> -->
                        </div>
                    </div>
                </div>
                <?php } ?>