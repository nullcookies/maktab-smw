        
        
        <!--orders-starts-->
        <div class="content-block">
            <?php
                include('breadcrumbs.php');
            ?>
            <div class="container">

                <h1 class="main-header"><?=$this->translation('order')?> #<?=$orderId?></h1>

                <?php if($userMenu){ ?>
                <div class="user-menu">
                  <div class="btn-group">
                    <?php foreach($userMenu as $value){ ?>
                    <a class="btn btn-light <?php if($value['active']){ ?>active<?php } ?>" href="<?=$value['url']?>">
                      <?=$value['name']?>
                    </a>
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>

                <div class="content-block">
                  <div class="main-box">
                    <strong><?=$this->translation('current status')?>: </strong>
                    <span class="order-status order-status-<?=$order['status']?>">
                      <img src="<?=$statusIconsPath . '/' . (int)$order['status'] . '.png'?>" alt="Status <?=(int)$order['status']?>" title="<?=$this->getTranslation('order status ' . (int)$order['status'])?>">
                      <span>
                        <?=$this->getTranslation('order status ' . (int)$order['status'])?>
                      </span>
                    </span>
                  </div>
                </div>

                <?php /* if($order['status'] == 1){ ?>
                <div class="content-block">
                  <div class="main-box">
                    
                    <form method="POST" action="<?=$paycomCheckoutUrl?>">
                      <input type="hidden" name="merchant" value="<?=$this->config['paycom']['merchant_id']?>"/>
                      <!-- Сумма платежа в тиинах -->
                      <input type="hidden" name="amount" value="<?=$order['items']['total'] * 100?>"/>
                      <input type="hidden" name="account[order_id]" value="<?=$order['id']?>"/>

                      <input type="hidden" name="lang" value="<?=LANG_PREFIX?>"/>
                      <input type="hidden" name="callback" value="<?=BASEURL . $returnURL?>"/>
                      <input type="hidden" name="callback_timeout" value="15"/>
                      <!-- <input type="hidden" name="payment" value="{payment_id}"/> -->
                      <input type="hidden" name="description" value="Заказ №<?=$order['id']?>. fpg.uz"/>
                      
                      <?php
                        $orderDescription = array();
                        $orderDescription['items'] = array();
                        foreach($order['items'] as $orderItem){
                          $orderItemTitle = $orderItem['product']['name'][LANG_ID];
                          if(isset($orderItem['product']['configuration_show']) && count($orderItem['product']['configuration_show'])){
                            foreach($orderItem['product']['configuration_show'] as $configItem){
                              $orderItemTitle .= ' ' . $configItem['name'] . ':' . $configItem['value'];
                            }
                          }

                          $orderDescription['items'][] = array(
                            'title' => $orderItemTitle,
                            'price' => $orderItem['price'],
                            'count' => $orderItem['quantity']
                          );
                        }
                        $orderDescription = base64_encode(json_encode($orderDescription));
                      ?>
                      <input type="hidden" name="detail" value="<?=$orderDescription?>"/>
                      <!-- ================================================================== -->

                      <button class="btn transparent black-text waves-effect" type="submit" style="white-space: normal;height: auto;box-shadow: 0 0 5px rgba(0,0,0,0.2);min-height: 50px;padding: 6px 20px 8px;">
                        Оплатить с помощью <img style="vertical-align: middle;margin-left: 10px;" src="/uploads/payme.png" alt="Payme">
                      </button>
                    </form>

                    <?php //$this->ppp($order['items']['total']); ?>
                  </div>
                </div>
                <?php } */ ?>

                <?php if($orderHistory){ ?>
                <div class="table-responsive">
                    <table class="table table-bordered cart-table">
                    <?php foreach($orderHistory as $value){ ?>
                      <tr>
                        <td>
                          <strong><?=date('d-m-Y', $value['date'])?></strong>
                          <?=date('H:i', $value['date'])?>
                        </td>
                        <td>
                          <span class="order-status order-status-<?=$value['new_status']?>">
                            <img src="<?=$statusIconsPath . '/' . $value['new_status'] . '.png'?>" alt="Status <?=$value['new_status']?>" title="<?=$this->getTranslation('order status ' . $value['new_status'])?>">
                          </span>
                        </td>
                        <td>
                          <?=$value['comment']?>
                        </td>
                      </tr>
                    <?php } ?>
                    </table>
                </div>
                <?php } ?>


                <?php if($order){ ?>
                <h3 class="custom-header"><?=$this->translation('order info')?></h3>
                <div class="table-responsive">
                    <table class="table cart-table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2"><?=$this->translation('product')?></th>
                                <th><?=$this->translation('price')?></th>
                                <th style="text-align: center;"><?=$this->translation('quantity')?></th>
                                <th><?=$this->translation('line total')?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($order['items']['items'] as $value){?>
                            <tr>
                              <td class="cart-img">
                                <a href="<?=$value['product']['url']?>">
                                  <img src="<?=$value['product']['icon']?>" alt="<?=$value['product']['name'][LANG_ID]?>">
                                </a>
                              </td>
                              <td>
                                <p>
                                  <a class="dark-text" href="<?=$value['product']['url']?>">
                                    <?=$value['product']['name'][LANG_ID]?>
                                  </a>
                                </p>
                                <?php if($value['product']['configuration_show']){ ?>
                                <?php foreach($value['product']['configuration_show'] as $value1){ ?>
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
                                <span class="item_price current-price"><?=$this->formatPrice($value['product']['price_show'])?>
                              </td>
                              <td style="text-align: center;">
                                <div class="cart_item_content">
                                  <?=$value['product']['quantity']?>
                                </div>
                              </td>
                              <td class="cart-line-price">
                                <?=$this->formatPrice($value['product']['line_total'])?>
                              </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="content-block">
                  <div class="main-box">
                    
                    <?php if(isset($order['items']['subtotal']) && $order['items']['total'] != $order['items']['subtotal']){ ?>
                    <div class="cart-subtotal text-right">
                      <strong>
                        <?=$this->translation('subtotal')?>: 
                      </strong>
                      <span class="green-text">
                        <?=$this->formatPrice($order['items']['subtotal'])?>
                      </span>
                    </div>
                    <?php } ?>
                    <?php if(!empty($order['items']['coupon'])){ ?>
                    <div class="cart-coupon text-right">
                      <?php printf($this->t('Coupon "%s" applied'), $order['items']['coupon']['coupon_code']); ?> (<?=$order['items']['coupon']['coupon_value']?>)
                    </div>
                    <?php } ?>

                    <div class="cart-total">
                      <strong>
                        <?=$this->translation('total')?>: 
                      </strong>
                      <span class="blue-text">
                        <?=$this->formatPrice($order['items']['total'])?>
                      </span>
                    </div>
                  </div>
                </div>



                <div class="content-block">
                    <h3 class="custom-header"><?=$this->translation('client info')?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered cart-table">
                          <tr>
                            <td><strong><?=$this->translation('date')?></strong></td>
                            <td>
                              <strong><?=date('d-m-Y', $order['date'])?></strong>
                              <?=date('H:i', $order['date'])?>
                            </td>
                          </tr>
                          <tr>
                            <td><strong><?=$this->translation('fio')?></strong></td>
                            <td><?=$order['fio']?></td>
                          </tr>
                          <tr>
                            <td><strong><?=$this->translation('email')?></strong></td>
                            <td><?=$order['email']?></td>
                          </tr>
                          <tr>
                            <td><strong><?=$this->translation('phone')?></strong></td>
                            <td><?=$order['phone']?></td>
                          </tr>
                          <tr>
                            <td><strong><?=$this->translation('shipping address')?></strong></td>
                            <td><?=$order['address']?></td>
                          </tr>
                        </table>
                    </div>
                </div>

                <br>
                <br>

                <?php } ?>

            </div>

                

        </div>
        <!--orders-end-->

          

