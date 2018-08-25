<div class="user-login-page">
  <div class="user-login">
    <div class="container-fluid">
      <div class="row">
        
        <div class="col-md-4 col-md-push-4 col-sm-6">
          <div class="login-logo">
            <a href="<?=$homeUrl?>">
              <img src="/uploads/logo.png" alt="<?=$this->translation('logo')?>">
            </a>
          </div>
        </div>
        <div class="col-md-4 col-md-push-4 col-sm-6">
          <div class="user-login-form">
            <form action="<?=$action?>" method="post">
              <div class="form-group">
                <label for="username"><?=$this->translation('username')?></label>
                <input type="text" name="username" id="username" class="form-control">
              </div>
              <div class="form-group">
                <label for="password"><?=$this->translation('password')?></label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              <div class="buttons">
                <input type="submit" class="btn btn-warning btn-sm btn-block" value="<?=$this->translation('login')?>">
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-4 col-md-pull-8 col-sm-12">
          <div class="user-warning">
            <h3><?=$this->translation('attention 3')?> / <?=$this->translation('attention 1')?></h3>
            <p><?=$this->translation('warning 3')?></p>
            <p><?=$this->translation('warning 1')?></p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>