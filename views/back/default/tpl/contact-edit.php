<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('view contact');?>
        <!-- <?=$this->getTranslation('edit contact');?> -->
        <!-- <small>Optional description</small> -->
      </h1>
      <?php 
          if(isset($breadcrumbs)){ 
            $this->renderBreadcrumbs($breadcrumbs);
          }
      ?>
    </section>

    <!-- Main content -->
    <section class="content">

        <?=$this->renderNotifications($successText, $errorText)?>
    
        <form id="contact-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$contact['id']?>" />
            <input type="hidden" value="2" name="<?=$contact['type']?>">
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <!-- <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button> -->
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label for="name"><?=$this->getTranslation('contact form name')?></label>
                                <!-- <input class="form-control"  name="name" id="name" value="<?=$contact['name']?>"> -->
                                <p class="form-control-static"><?=$contact['name']?></p>
                            </div>
                            
                            <div class="form-group">
                                <label for="email"><?=$this->getTranslation('email')?></label>
                                <!-- <input class="form-control"  name="email" id="email" value="<?=$contact['email']?>"> -->
                                <p class="form-control-static"><?=$contact['email']?></p>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone"><?=$this->getTranslation('phone')?></label>
                                <!-- <input class="form-control"  name="phone" id="phone" value="<?=$contact['phone']?>"> -->
                                <p class="form-control-static"><?=$contact['phone']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-success">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="message"><?=$this->getTranslation('message')?></label>
                                <!-- <textarea class="form-control ck-editor"  name="message" id="message"><?=$contact['message']?></textarea> -->
                                <p class="form-control-static"><?=$contact['message']?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <!-- <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button> -->
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        