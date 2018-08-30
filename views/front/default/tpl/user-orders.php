        
        <!--orders-starts-->
        <div class="content-block">

          <?php
              include('breadcrumbs.php');
          ?>

          <div class="container">

              <h1 class="main-header"><?=$this->translation('orders')?></h1>

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

              <?php if($orders){ ?>
              <div class="table-responsive">
                  <table class="table cart-table table-bordered">
                      <thead class="thead-light">
                          <tr>
                            <th class="td-shrink">
                              <?=$this->translation('order')?>
                            </th>
                            <th class="td-shrink">
                              <?=$this->translation('date')?>
                            </th>
                            <th class="td-shrink">
                              <?=$this->getTranslation('status')?>
                            </th>
                            <th>
                              <?=$this->translation('total')?>
                            </th>
                            <th class="td-shrink"></th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach($orders as $value){ ?>
                          <tr>
                            <td>
                              #<?=$value['id']?>
                            </td>
                            <td>
                              <?=date('d-m-Y', $value['date'])?>
                            </td>
                            <td>
                              <span class="order-status order-status-<?=$value['status']?>">
                                <img src="<?=$statusIconsPath . '/' . $value['status'] . '.png'?>" alt="Status <?=$value['status']?>" title="<?=$this->getTranslation('order status ' . $value['status'])?>">
                              </span>
                            </td>
                            <td>
                              <strong><?=$this->getTranslation('total')?>:</strong> <?=$this->formatPrice($value['items']['total'])?>,
                              <strong><?=$this->getTranslation('quantity')?>:</strong> <?=$value['items']['quantity']?>
                            </td>
                            <td>
                              <a class="btn btn-warning" href="<?=$value['url']?>">
                                  <?=$this->t('order details')?>
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
              </div>
              <?php } ?>
          </div>

              

          
              

        </div>
        <!--orders-end-->

          

