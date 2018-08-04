<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('import products page')?>
        <small><?=$this->getTranslation('control panel')?></small>
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

      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('products file upload')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="post" action="<?=$controls['import']?>" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="">
                      <?=$this->getTranslation('choose file')?>
                    </label>
                    <input class="upload-products-xml xml-fileinput" name="file" type="file" />
                  </div>
                  <div class="form-group">
                    <input class="upload-products-xml-btn btn btn-success" type="submit" value="<?=$this->getTranslation('upload file')?>" />
                  </div>
                  
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?=$this->getTranslation('export products')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="<?=$controls['export']?>" class="btn btn-success"><?=$this->getTranslation('export')?></a>
              <br>
              <br>
              <div>
                <p><strong>sku</strong> - Артикул товара (обязательное поле)</p>
                <p><strong>category_id</strong> - ID категории (можно посмотреть в админке) (обязательное поле)</p>
                <p><strong>alias</strong> - URL товара (должен быть уникальным на весь сайт) (обязательное поле) (пример product/product-name)</p>
                <p><strong>sort_number</strong> - Номер сортировки (не используется, можно оставить пустым)</p>
                <p><strong>price</strong> - Цена (пример 500.00)</p>
                <p><strong>discount</strong> - Скидка в процентах (от 0 до 100)</p>
                <p><strong>stock_1</strong> - Количество на складе</p>
                <p><strong>request_product</strong> - Товар по запросу (не используется, можно оставить пустым)</p>
                <p><strong>status</strong> - Статус товара (0 - отключен, 1 - включен)</p>
                <p><strong>name - ru, en</strong> - Название товара (обязательное поле)</p>
                <p><strong>descr - ru2, en3</strong> - Короткое описание</p>
                <p><strong>descr_full - ru4, en5</strong> - Полное описание</p>
                <p><strong>specifications - ru6, en7</strong> - Характеристики (не используется, можно оставить пустым)</p>
                <p><strong>meta_t - ru8, en9</strong> - Мета название (SEO)</p>
                <p><strong>meta_d - ru10, en11</strong> - Мета описание (SEO)</p>
                <p><strong>meta_k - ru12, en13</strong> - Ключевые слова (SEO)</p>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->