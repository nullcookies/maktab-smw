        
        
        <!--orders-starts-->
        <div class="content-block">
            <?php
                include('breadcrumbs.php');
            ?>
            <div class="container">

                <h1 class="main-header"><?=$this->translation('restore password')?></h1>

                <div class="content-block">
                  <div class="row">
                    <div class="col-sm-6 col-md-5 col-lg-4">
                      <form action="<?=$restoreURL?>" class="restore-password-form">
                        <input type="hidden" name="uid" value="<?=$uid?>">
                        <input type="hidden" name="forgetkey" value="<?=$forgetkey?>">
                        <div class="form-group">
                          <label for="password1"><?=$this->t('new password')?></label>
                          <input type="text" class="form-control" name="password1" id="password1">
                        </div>
                        <div class="form-group">
                          <label for="password2"><?=$this->t('confirm new password')?></label>
                          <input type="text" class="form-control" name="password2" id="password2">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">
                            <?=$this->translation('send')?>
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <br>
                <br>

            </div>
                

        </div>
        <!--orders-end-->

          

