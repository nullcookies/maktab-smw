<div class="">
  <div class="login-box">
      <?php if(count($errors) > 0){  ?>
      <div class="alert alert-danger">
        <?=$this->getTranslation('error login')?>
      </div>
      <?php } ?>

    <div class="login-logo">
      <span>Admin <em><strong>Panel</strong></em></span>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg"><?=$this->getTranslation('enter account')?></p>

      <form action="<?php echo $action; ?>" method="post">
        <div class="form-group has-feedback <?php if($errors['username']){ ?>has-error<?php } ?>">
          <input class="form-control" placeholder="<?=$this->getTranslation('username')?>" type="text" name="username" value="<?=$username?>" />
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          <?php if($errors['username']){ ?><div class="help-block"><?=$errors['username']?></div><?php } ?>
        </div>
        <div class="form-group has-feedback <?php if($errors['password']){ ?>has-error<?php } ?>">
          <input class="form-control" type="password" name="password" placeholder="<?=$this->getTranslation('password')?>"/>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          <?php if($errors['password']){ ?><div class="help-block"><?=$errors['password']?></div><?php } ?>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-sm-offset-8 col-sm-4">
            <button type="submit" name="btn_login" class="btn btn-primary btn-block btn-flat"><?=$this->getTranslation('login')?></button>
          </div>
          <!-- /.col -->
        </div>
      </form>


    </div>
    <!-- /.login-box-body -->
  </div>
</div>