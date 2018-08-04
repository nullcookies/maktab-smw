                
                <?php if($news){ ?>
                <div class="content-block home-news-block">
                    <div class="container">
                        <div class="main-box">
                            <h2 class="main-header">
                                <span class="main-header-text">
                                    <?=$newsLink['name']?>
                                </span>
                                <a href="<?=$newsLink['url']?>" class="btn btn-success">
                                    <?=$this->t('all news')?>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </h2>
                            <div class="main-box-content">
                                <div class="news-list">
                                    <div class="row">
                                        <?php foreach($news as $key => $value){ ?>
                                        <?php if($key > 0){ ?>
                                        <div class="col-sm-6 col-lg-3">
                                            <?php include('news-one.php'); ?>
                                        </div>
                                        <?php } else { ?>
                                        <div class="col-lg-6">
                                            <?php if($newsHasVideo){ ?>
                                            <?php include('news-video-one.php'); ?>
                                            <?php } else { ?>
                                            <?php include('news-big-one.php'); ?>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
