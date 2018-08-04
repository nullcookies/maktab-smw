        <?php if($banners){ ?>
        <div class="home-promotions-block blue-block">
            <div class="container">
                <div class="main-box">
                    <div class="main-box-content">
                        <div class="home-promotions">
                            <div class="row">
                                <?php foreach ($banners as $value) { ?>
                                <div class="col-sm-6">
                                    <div class="home-promotion">
                                        <a href="<?=$value['url'][LANG_ID]?>">
                                            <img class="img-fluid" src="<?=$value['icon']?>" alt="<?=$value['name'][LANG_ID]?>">
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        