
<!--cart-->
<div id="cart-content" class="cart content-block" >
    <?php
      include('breadcrumbs.php');
    ?>
    <div class="container">

        <h1 class="main-header">
          <?=$this->translation('cart')?>
        </h1>

        <?php if($cartItems){ ?>
        <div class="table-responsive">
            <table class="table table-bordered cart-table">
              <thead class="thead-light">
                  <tr>
                      <th colspan="2"><?=$this->translation('product')?></th>
                      <th><?=$this->translation('price')?></th>
                      <th><?=$this->translation('quantity')?></th>
                      <th><?=$this->translation('line total')?></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach($cartItems as $value){?>
                  <tr class="<?php if(!$value['checkoutAvailable']){ ?>checkout_unavailable<?php } ?>">
                    <td class="cart-img">
                      <a href="<?=$value['url']?>">
                        <img src="<?=$value['icon']?>" alt="<?=$value['name'][LANG_ID]?>">
                      </a>
                    </td>
                    <td>
                      <p>
                        <a class="text-dark" href="<?=$value['url']?>">
                          <?=$value['name'][LANG_ID]?>
                        </a>
                      </p>
                      <?php if($value['configuration_show']){ ?>
                      <?php foreach($value['configuration_show'] as $value1){ ?>
                      <div>
                        <strong><?=$value1['name']?>: </strong>
                        <span><?=$value1['value']?></span>
                        <?php if($value1['price'] > 0){ ?>
                        <span>(+<?=$this->formatPrice($value1['price'])?>)</span>
                        <?php } ?>
                      </div>
                      <?php } ?>
                      <?php } ?>
                    </td>
                    <td class="cart-price">
                      <span class="item_price current-price"><?=$this->formatPrice($value['price_show'])?></span>
                      <?php if($value['discount'] > 0){ ?>
                      <span class="old-price"><?=$this->formatPrice($value['price_old'])?></span>
                      <?php } ?>
                    </td>
                    <td>
                      <div class="cart_item_content">
                        <div class="input-group">
                            <input type="text" class="cart_item_change form-control" value="<?=$value['quantity']?>">
                            <div class="input-group-append">
                                <a class="item_change btn btn-outline-success" data-pid="<?=$value['id']?>" data-cart-item-id="<?=$value['cartItemId']?>" href="#" data-target="<?=$changeCartUrl?>" title="<?=$this->t('update')?>">
                                  <i class="green-text fa fa-refresh"></i>
                                </a>
                                <a class="item_delete btn btn-outline-danger" data-pid="<?=$value['id']?>" data-cart-item-id="<?=$value['cartItemId']?>" href="#" data-target="<?=$deleteCartUrl?>" title="<?=$this->t('delete')?>">
                                  <i class="red-text fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        
                            
                      </div>
                    </td>
                    <td class="cart-line-price">
                      <?=$this->formatPrice($value['line_total'])?>
                    </td>
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
        </div>
        
        <div class="content-block">
          <br>
          <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4 offset-sm-4 offset-md-6 offset-lg-8">
              <form action="<?=$applyCouponUrl?>" class="apply-coupon-form">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" name="coupon_code" class="form-control">
                    <span class="input-group-append">
                      <button class="btn btn-info">
                        <?=$this->t('apply coupon')?>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="coupon-apply-results"></div>
              </form>
            </div>
          </div>
              
        </div>

        <div class="content-block">
          <div class="main-box">
            <?php if(isset($subtotal) && $total != $subtotal){ ?>
            <div class="cart-subtotal text-right">
              <strong>
                <?=$this->translation('subtotal')?>: 
              </strong>
              <span class="green-text">
                <?=$this->formatPrice($subtotal)?>
              </span>
            </div>
            <?php } ?>
            <?php if(!empty($coupon)){ ?>
            <div class="cart-coupon text-right">
              <?php printf($this->t('Coupon "%s" applied'), $coupon['coupon_code']); ?> (<?=$coupon['coupon_value']?>)
            </div>
            <?php } ?>
            <div class="cart-total">
              <strong>
                <?=$this->translation('total')?>: 
              </strong>
              <span class="green-text">
                <?=$this->formatPrice($total)?>
              </span>
            </div>
          </div>
        </div>

        
        <?php /* balans
        <div class="user_balance">
          <strong><?=$this->translation('contract balance available')?>: </strong>
          <span class="<?php if($user['balance'] > $total){ ?>green-text<?php } else { ?>red-text<?php } ?>">
            <?=$this->formatPrice($user['balance'])?>
          </span>
        </div>

        <?php if($errorNotEnough){ ?>
        <div class="card-panel red white-text">
          <?=$this->translation('not enough balance')?>
        </div>
        <?php } ?>
        */ ?>

        <div class="content-block">
          <?php if($checkoutAvailable){ ?>
          <div class="cart-checkout">
            <a class="btn btn-success" href="<?=$checkout?>">
              <?=$this->translation('go checkout')?>
            </a>
          </div>
          <?php } else { ?>
          <div class="text-danger">
            <strong><?=$this->translation('checkout unavailable')?></strong><br>
            <?php foreach($cartItems as $value){?>
            <?php if(!$value['checkoutAvailable']){?>
            <?=$this->translation('not enough')?> - <?=$value['name'][LANG_ID]?> (<?=$this->translation('in stock')?>: <?=$value['stock_' . $_SESSION['stock']]?>) <br>
            <?php } ?>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        

        <?php } else { ?>
        <div class="lead">
          <span class="text-danger">
            <?=$this->translation('cart empty')?>
          </span>
        </div>
        <?php } ?>

    </div>
</div>

<!--/cart-->