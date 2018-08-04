        <?php
            include('breadcrumbs.php');

            $product = $products[0];
        ?>

        <div class="configurator-page">
          
          <div class="content-block">
            <div class="main-box">
              <h1 class="product-header">
                <?=$textName?>
              </h1>
              <div>
                <?=htmlspecialchars_decode($textContent)?>
              </div>
              <br>

              <?php if($products){ ?>
              <ul class="tabs configurator-tabs">      
                <?php foreach($products as $product){ ?>
                <li class="tab">
                  <a href="#requestproduct<?=$product['id']?>">
                    <img src="/uploads/configurator/<?=$product['id']?>.png" alt="<?=$product['name'][LANG_ID]?>">
                  </a>
                </li>
                <?php } ?>
              </ul>
            <?php } ?>
            </div>
          </div>



            <?php if($products){ ?>

            <?php foreach($products as $product){ ?>
            <!-- product content -->
            <div id="requestproduct<?=$product['id']?>">
              <form method="post" action="<?=$addCartUrl?>">
                <div class="item_content">
                  <!-- cart-options -->
                  <div class="cart-options">
                    
                    <form method="post" action="#">
                      <?php
                        $lightColors = ['#ffffff'];
                      ?>
                      <div class="content-block">
                        <div class="product-params main-box">
                          <?php if($product['options']){ ?>
                            <?php foreach($product['options'] as $key => $value){ ?>
                            <?php
                              switch ($value['name'][LANG_ID]) {
                                case 'Исполнение':
                                  $imgCode = 'case';
                                  break;
                                case 'Процессор':
                                case 'Количество процессоров':
                                  $imgCode = 'cpu';
                                  break;
                                case 'Оперативная память':
                                  $imgCode = 'memory';
                                  break;
                                case 'Требуемые уровни RAID':
                                  $imgCode = 'raid';
                                  break;
                                case 'Жесткие диски':
                                case 'Доп. жесткие диски':
                                case 'Количество жестких дисков':
                                case 'Количество доп. жестких дисков':
                                  $imgCode = 'hdd';
                                  break;
                                case 'Сетевые интерфейсы':
                                case 'Количество сетевых интерфейсов':
                                  $imgCode = 'network';
                                  break;
                                case 'Удаленное управление':
                                  $imgCode = 'remote';
                                  break;
                                case 'Блок питания':
                                  $imgCode = 'power';
                                  break;
                                case 'Гарантия':
                                  $imgCode = 'warranty';
                                  break;
                                
                                default:
                                  $imgCode = 'universal';
                                  break;
                              }
                            ?>
                            <!-- option-container -->
                            <div class="configurator-product-option-container product-option-container product-option-<?=$value['type']?>-container">
                              <div class="row">
                                <div class="col l4 m12 s12">
                                  <h5 class="product-option-header">
                                    <span class="product-option-block-img">
                                      <img src="/uploads/configurator/<?=$imgCode?>.png" alt="">
                                    </span>
                                    <span class="product-option-block-name">
                                      <?=$value['name'][LANG_ID]?>:
                                    </span>
                                  </h5>
                                </div>
                                <div class="col l8 m12 s12">
                                  <!-- option values -->
                                  <?php if($value['type'] == 'radio'){ ?>
                                    <?php $firstOption = true; ?>
                                  <?php foreach($value['values'] as $key1 => $value1){ ?>
                                  <span class="product-option-radio">
                                    <input class="product-option-input" data-price="<?=$value1['price']?>" name="option[<?=$key?>]" type="radio" id="option-<?=$key?>-<?=$key1?>-<?=$product['id']?>" value="<?=$key1?>" <?php if($firstOption){ ?>checked<?php } ?> />
                                    <label for="option-<?=$key?>-<?=$key1?>-<?=$product['id']?>"><?=$value1['name'][LANG_ID]?></label>
                                  </span>
                                    <?php  $firstOption = false; ?>
                                  <?php } ?>
                                  <?php } elseif($value['type'] == 'color'){ ?>
                                    <?php $firstOption = true; ?>
                                  <?php foreach($value['values'] as $key1 => $value1){ ?>
                                  <span class="product-option-color">
                                    <input class="product-option-input" data-price="<?=$value1['price']?>" name="option[<?=$key?>]" type="radio" id="option-<?=$key?>-<?=$key1?>-<?=$product['id']?>" value="<?=$key1?>" <?php if($firstOption){ ?>checked<?php } ?> />
                                    <label class="<?php if(in_array(strtolower($value1['color']), $lightColors)){ ?>option-light-color<?php } ?>" for="option-<?=$key?>-<?=$key1?>-<?=$product['id']?>" title="<?=$value1['name'][LANG_ID]?>" style="background-color:<?=$value1['color']?>;"></label>
                                  </span>
                                    <?php  $firstOption = false; ?>
                                  <?php } ?>
                                  <?php } elseif($value['type'] == 'select'){ ?>
                                  <select class="product-option-select material-select" name="option[<?=$key?>]" id="option-<?=$key?>-<?=$product['id']?>">
                                    <?php foreach($value['values'] as $key1 => $value1){ ?>
                                    <option data-price="<?=$value1['price']?>" id="option-<?=$key?>-<?=$key1?>-<?=$product['id']?>" value="<?=$key1?>"><?=$value1['name'][LANG_ID]?></option>
                                    <?php } ?>
                                  </select>
                                  <?php } ?>
                                  <!-- option values -->
                                </div>
                              </div>
                            </div>
                            <!-- option-container -->
                            <?php } ?>
                          <?php } ?>
                        </div>
                      </div>

                                                      
                      <div class="content-block">
                        <div class="product-actions main-box">
                          <div class="addtocart">
                            <?php if($product['request_product']){ ?>
                              <div class="row">
                                <div class="col s6">
                                  <div class="input-field">
                                    <input class="form-control" name="fio" id="form-fio-<?=$product['id']?>" type="text">
                                    <label for="form-fio-<?=$product['id']?>">
                                      <?=$this->translation('your name')?>
                                    </label>
                                  </div>
                                </div>
                                <div class="col s6">
                                  <div class="input-field">
                                    <input class="form-control" name="email" id="form-email-<?=$product['id']?>" type="text">
                                    <label for="form-email-<?=$product['id']?>">
                                      <?=$this->translation('your email')?>
                                    </label>
                                  </div>
                                </div>
                                <div class="col s6">
                                  <div class="input-field">
                                    <input class="form-control" name="phone" id="form-phone-<?=$product['id']?>" type="text">
                                    <label for="form-phone-<?=$product['id']?>">
                                      <?=$this->translation('your phone')?>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div>
                                <input type="hidden" class="item_quantity" name="item_quantity" value="1">
                                <input type="hidden" name="confirm_checkout" value="1">
                                <button type="submit" class="item_request btn waves-effect waves-light" data-target="<?=$requestProductUrl?>" data-pid="<?=$product['id']?>">
                                  <?=$this->translation('send request')?>
                                </button>
                              </div>
                              <div class="modal" id="request-end-<?=$product['id']?>">
                                  <div class="modal-content">
                                    <h4 class="result-text"></h4>
                                  </div>
                              </div>
                            <?php } ?>
                          </div>
                        <div class="clearfix"></div>
                      </div>

                        
                      </div>

                    </form>   
                  </div>
                  <!-- cart-options -->
                </div>
              </form>
            </div>
            <!-- product content -->
            <?php } ?>
          <?php } ?>

        </div>
