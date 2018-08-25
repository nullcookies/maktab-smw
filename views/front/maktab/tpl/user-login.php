<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <h1 class="auth-title">
                    <div class="logo">
                        <span class="l l1"></span>
                        <span class="l l2"></span>
                        <span class="l l3"></span>
                        <span class="l l4"></span>
                        <span class="l l5"></span>
                    </div> 
                    Maktab 
                </h1>
            </header>
            <div class="auth-content">
                <form id="login-form" action="<?=$action?>" method="post" novalidate="">
                    <div class="form-group">
                        <label for="username"><?=$this->translation('username')?></label>
                        <input type="text" class="form-control boxed <?php if(!empty($errors['username'])){ ?>is-invalid<?php } ?>" name="username" id="username" value="<?=$username?>" required>
                        <?php if(!empty($errors['username'])){ ?><span class="invalid-feedback"><?=$this->t($errors['username'], 'front')?></span><?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="password"><?=$this->translation('password')?></label>
                        <input type="password" class="form-control boxed <?php if(!empty($errors['password'])){ ?>is-invalid<?php } ?>" name="password" id="password" required>
                        <?php if(!empty($errors['password'])){ ?><span class="invalid-feedback"><?=$this->t($errors['password'], 'front')?></span><?php } ?>
                    </div>
                    <?php 
                    /*
                    <div class="form-group">
                        <label for="remember">
                            <input class="checkbox" id="remember" type="checkbox">
                            <span>Remember me</span>
                        </label>
                        <a href="reset.html" class="forgot-btn pull-right">Forgot password?</a>
                    </div>
                    */ 
                    ?>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">
                            <?=$this->translation('login')?>
                        </button>
                    </div>
                    
                    <?php 
                    /*
                    <div class="form-group">
                        <p class="text-muted text-center">Do not have an account?
                            <a href="signup.html">Sign Up!</a>
                        </p>
                    </div>
                    */ 
                    ?>
                    

                </form>
            </div>
        </div>
        
        <?php 
        /*
        <div class="text-center">
            <a href="<?=$homeUrl?>" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back to dashboard 
            </a>
        </div>
        */ 
        ?>
        

    </div>
</div>
