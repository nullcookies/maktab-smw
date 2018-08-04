        
        <!--account-starts-->
        <div class="content-block">

          <?php
              include('breadcrumbs.php');
          ?>

          <div class="container">

              <h1 class="main-header"><?=$this->translation('account activation')?></h1>

              <?php if(isset($successActivate)){ ?>
              <?php if($successActivate){ ?>
              <div class="alert alert-success">
                <?=$this->translation('account has been successfully activated')?>
              </div>
              <?php } else { ?>
              <div class="alert alert-danger">
                <?=$this->translation('error while activating account')?>
              </div>
              <?php } ?>
              <?php } ?>

          </div>    
        </div>
        <!--account-end-->

          

