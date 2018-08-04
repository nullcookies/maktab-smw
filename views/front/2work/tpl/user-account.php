        
        
        <?php if($user){ ?>
        <!--account-starts-->
        <div class="content-block">

          <?php
              include('breadcrumbs.php');
          ?>

          <div class="container">

              <h1 class="main-header"><?=$this->translation('my account')?></h1>

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

              <div class="user-table">
                  <div class="table-responsive">
                    <table class="table cart-table table-bordered">
                      
                      <tr>
                        <td>
                          <span>
                            <?=$this->translation('fio')?>
                          </span>
                        </td>
                        <td>
                          <strong>
                            <?=$user['lastname']?> <?=$user['firstname']?> <?=$user['middlename']?>
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span>
                            <?=$this->translation('email')?>
                          </span>
                        </td>
                        <td>
                          <strong>
                            <?=$user['email']?>
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span>
                            <?=$this->translation('phone')?>
                          </span>
                        </td>
                        <td>
                          <strong>
                            <?=$user['phone']?>
                          </strong>
                        </td>
                      </tr>
                    </table>
                  </div>
              </div>

          </div>    
        </div>
        <!--account-end-->
        <?php } ?>

          

