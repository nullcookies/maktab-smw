                  <div class="product">
                    <div class="product-img">
                      <a title="<?=$value['name'][LANG_ID]?>" href="<?=$value['url']?>">
                        <img class="img-fluid" src="<?=$value['icon']?>" alt="<?=$value['name'][LANG_ID]?>">
                      </a>
                      <div class="product-actions item_content">
                        <form action="<?=$addCartUrl?>">
                          <input class="item_quantity" type="hidden" name="item_quantity" value="1">
                          <button class="btn btn-outline-white item_add_buy" title="<?=$this->t('buy')?>"  data-target="<?=$addCartUrl?>" data-checkout="<?=$checkoutUrl?>" data-pid="<?=$value['id']?>">
                            <i class="fa fa-shopping-cart"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                    <div class="product-content">
                      <h4 class="product-name" title="<?=$value['name'][LANG_ID]?>">
                        <a href="<?=$value['url']?>"><?=$value['name'][LANG_ID]?></a>
                      </h4>
                      <div class="product-price">
                        <span class="current-price"><?=$this->formatPrice($value['price_show'])?></span>
                        <?php if($value['discount'] > 0){ ?>
                          <span class="old-price"><?=$this->formatPrice($value['price_old'])?></span>
                        <?php } ?>
                      </div>
                    </div>
                    
                  </div>

