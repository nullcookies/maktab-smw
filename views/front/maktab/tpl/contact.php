
    <div class="content-block contact-page-container">
        <?php
            //include('breadcrumbs.php');
        ?>

        <div class="our-map" id="our-map"></div>
        
        <div class="feedback-container">
            <div class="container">
                <div class="feedback-block-container">
                    <div class="feedback-block">
                        

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feedback-left">
                                    <?php 
                                    /* 
                                    <h1 class="main-header">
                                        <?=$this->translation('contact us')?>
                                    </h1> 
                                    */ 
                                    ?>
                                    <div class="main-header-info">
                                      <?=$this->translation('our contacts and feedback')?>
                                    </div>
                                    <div class="main-box contact-column">
                                      <div class="contact-phone contact-data">
                                        <i class="fa fa-phone"></i>
                                        <a class="dark-text" href="tel:<?=(preg_replace('#[^0-9]#', '', $phone1))?>"><?=$phone1?></a>
                                      </div>
                                      <div class="contact-mail contact-data">
                                        <i class="fa fa-envelope"></i>
                                        <a class="dark-text" href="mailto:<?=$mail?>"><?=$mail?></a>
                                      </div>
                                      <div class="contact-address contact-data">
                                        <i class="fa fa-map-marker"></i>
                                        <?=$address?>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feedback-right">
                                    <div class="main-box contact-column">
                                      <?php if($errors){ ?>
                                      <div class="alert alert-danger">
                                        <?=$this->translation('contact form submit error')?>
                                      </div>
                                      <?php } ?>
                                      <?php if($submitSuccess){ ?>
                                      <div class="alert alert-success">
                                        <?=$this->translation('contact form submit success')?>
                                      </div>
                                      <?php } ?>
                                      <form action="<?=$contactAction?>" method="post">
                                        <div class="form-group">
                                          <input type="text" name="name" id="name" class="form-control<?php if($errors['name']){ ?> is-invalid<?php } ?>" value="<?=$post['name']?>" placeholder="<?=$this->translation('your name')?>" >
                                          <?php if($errors['name']){ ?><div class="invalid-feedback"><?=$this->translation($errors['name'])?></div><?php } ?>
                                        </div>
                                        <div class="form-group">
                                          <input type="text" name="email" id="email" class="form-control<?php if($errors['email']){ ?> is-invalid<?php } ?>" value="<?=$post['email']?>" placeholder="<?=$this->translation('your email')?>" >
                                          <?php if($errors['email']){ ?><div class="invalid-feedback"><?=$this->translation($errors['email'])?></div><?php } ?>
                                        </div>
                                        <input type="hidden" name="phone" value="">
                                        <?php
                                        /*
                                        <div class="form-group">
                                          <label class="control-label" for="phone"><?=$this->translation('your phone')?></label>
                                          <input type="text" name="phone" id="phone" class="form-control<?php if($errors['phone']){ ?> is-invalid<?php } ?>" value="<?=$post['phone']?>">
                                          <?php if($errors['phone']){ ?><div class="invalid-feedback"><?=$this->translation($errors['phone'])?></div><?php } ?>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label" for="project_id"><?=$this->translation('choose project')?></label>
                                          <select name="project_id" id="project_id" class="form-control">
                                            <option value="0">-</option>
                                            <?php if($products){ ?>
                                            <?php foreach($products as $value){ ?>
                                            <option value="<?=$value['id']?>" <?php if($value['id'] == $post['project_id']){ ?>selected<?php } ?>><?=$value['name']?></option>
                                            <?php } ?>
                                            <?php } ?>
                                          </select>
                                        </div>
                                        */
                                        ?>
                                        <div class="form-group">
                                          <textarea name="message" id="message" class="form-control<?php if($errors['message']){ ?> is-invalid<?php } ?>" placeholder="<?=$this->translation('your message')?>"><?=$post['message']?></textarea>
                                          <?php if($errors['message']){ ?><div class="invalid-feedback"><?=$this->translation($errors['message'])?></div><?php } ?>
                                        </div>
                                        <div class="form-group">
                                          <button class="btn btn-success btn-block btn-lg" type="submit">
                                            <i class="icon icon-feedback-send"></i>
                                            <?=$this->translation('send')?>
                                          </button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
    </div>

    <script>
        var map;
        var marker;
        var infoWindow;
        var ourCords = {
          lat: <?=$map['lat']?>,
          lng: <?=$map['lng']?>,
        };
        function initMap() {
          map = new google.maps.Map(document.getElementById('our-map'), {
            center: ourCords,
            zoom: 16
          });
          marker = new google.maps.Marker({
            position: ourCords,
            map: map
          });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$map['api_key']?>&callback=initMap" async defer></script>