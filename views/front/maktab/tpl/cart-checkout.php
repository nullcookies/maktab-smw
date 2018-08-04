
<!--checkout-->
<div id="cart-content" class="cart content-block" >
    <?php
      include('breadcrumbs.php');
    ?>
    <div class="container">
        <h1 class="main-header">
          <?=$this->translation('checkout')?>
        </h1>
        <?php if($cartItems){ ?>
        
        <form action="<?=$checkout?>" method="post">
          <div class="content-block">
            
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                  <h3 class="custom-header">
                    <?=$this->translation('payment details')?>
                  </h3>
                  <div class="form-group">
                    <label class="control-label" for="fio"><?=$this->translation('fio')?>&nbsp;<span class="text-danger">*</span></label>
                    <input type="text" name="fio" id="fio" class="form-control <?php if($errors['fio']){ ?> is-invalid<?php } ?>" value="<?=$postData['fio']?>">
                    <?php if($errors['fio']){ ?><span class="invalid-feedback"><?=$this->translation($errors['fio'])?></span><?php } ?>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="email"><?=$this->translation('email')?>&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" class="form-control <?php if($errors['email']){ ?> is-invalid<?php } ?>" value="<?=$postData['email']?>">
                        <?php if($errors['email']){ ?><span class="invalid-feedback"><?=$this->translation($errors['email'])?></span><?php } ?>
                      </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                      <div class="form-group">
                        <label class="control-label" for="phone"><?=$this->translation('phone')?>&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control <?php if($errors['phone']){ ?> is-invalid<?php } ?>" value="<?=$postData['phone']?>">
                        <?php if($errors['phone']){ ?><span class="invalid-feedback"><?=$this->translation($errors['phone'])?></span><?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="address"><?=$this->translation('address')?>&nbsp;<span class="text-danger">*</span></label>
                    <textarea name="address" id="address" class="form-control <?php if($errors['address']){ ?> is-invalid<?php } ?>"><?=$postData['address']?></textarea>
                    <?php if($errors['address']){ ?><span class="invalid-feedback"><?=$this->translation($errors['address'])?></span><?php } ?>
                  </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                  <h3 class="custom-header">
                    <?=$this->translation('additional information')?>
                  </h3>
                  <div class="form-group">
                    <label class="control-label" for="comment"><?=$this->translation('order comment')?></label>
                    <textarea name="comment" id="comment" class="form-control"><?=$postData['comment']?></textarea>
                  </div>
                </div>
            </div>
          </div>

          <div class="content-block">
            <h3 class="custom-header">
              <?=$this->translation('your order')?>
            </h3>
            <div class="table-responsive">
                <table class="table table-bordered cart-table">
                    <thead class="thead-light">
                        <tr>
                          <th colspan="2"><?=$this->translation('product')?></th>
                          <th><?=$this->translation('price')?></th>
                          <th style="text-align: center;"><?=$this->translation('quantity')?></th>
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
                              <a class="dark-text" href="<?=$value['url']?>">
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
                            <span class="item_price current-price"><?=$this->formatPrice($value['price_show'])?>
                            <?php if($value['discount'] > 0){ ?>
                            <span class="old-price"><?=$this->formatPrice($value['price_old'])?></span>
                            <?php } ?>
                          </td>
                          <td>
                            <div class="cart_item_content" style="text-align: center;">
                              <?=$value['quantity']?>
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
            <span class="<?php if($user['balance'] > $total){ ?>green-text<?php } else { ?>text-danger<?php } ?>">
              <?=$this->formatPrice($user['balance'])?>
            </span>
          </div>
          

          <?php if($errorNotEnough){?>
          <div class="alert alert-danger">
            <?=$this->translation('not enough balance')?>
          </div>
          <?php } ?>
          */ ?>

          <?php if($checkoutAvailable){ ?>
          <div class="cart-checkout">
            <input type="hidden" name="confirm_checkout" value="1">
            <button class="btn btn-success waves-effect" type="submit">
              <?=$this->translation('confirm checkout')?>
            </button>
          </div>
          <?php } else { ?>
          <div class="alert alert-danger">
            <strong><?=$this->translation('checkout unavailable')?></strong><br>
            <?php foreach($cartItems as $value){?>
            <?php if(!$value['checkoutAvailable']){?>
            <?=$this->translation('not enough')?> - <?=$value['name'][LANG_ID]?> (<?=$this->translation('in stock')?>: <?=$value['stock_' . $_SESSION['stock']]?>) <br>
            <?php } ?>
            <?php } ?>
          </div>
          <div class="back-to-cart">
            <a href="<?=$cartUrl?>" class="btn btn-warning">
              <i class="fa fa-angle-double-left"></i>
              <?=$this->translation('back to cart')?>
            </a>
          </div>
          <?php } ?>
        </form>
        <?php } else { ?>
        <div class="lead">
          <span class="text-danger">
            <?=$this->translation('cart empty')?>
          </span>
        </div>
        <?php } ?>
    </div>
</div>
  <!--/checkout-->