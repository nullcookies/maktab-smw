
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=$user['icon']?>" class="img-circle" alt="<?=$user['name']?>">
        </div>
        <div class="pull-left info">
          <p><?=$user['name']?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> <?=$this->getTranslation('online')?></a>
        </div>
      </div>

     <?/*
	 <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
     */?>
	
	<?php if($menu){ ?>
    <?php
      $faIcons = [
        'page' => 'file-text-o',
        'category' => 'th-large',
        'product' => 'truck',
        'order' => 'shopping-bag',
        'user' => 'users',
        'brand' => 'apple',
        'teacher' => 'user-secret',
        'student' => 'child',
        'subject' => 'book',
        'settings' => 'cog',
        'group' => 'group',
      ];
    ?>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="<?php if($controller == 'home'){ ?>active<?php } ?>">
          <a title="<?=$this->getTranslation('main page')?>" href="<?=$mainPage?>"><i class="fa fa-dashboard"></i> <span><?=$this->getTranslation('main page')?></span></a>
        </li>
        <?php foreach($menu as $value){ ?>
        <li class="<?php if($value['active']){ ?>active<?php } ?>">
          <a title="<?=$this->getTranslation('menu ' . $value['alias'])?>" href="<?=$value['url']?>"><i class="fa fa-<?=((!empty($faIcons[$value['alias']])) ? $faIcons[$value['alias']] : 'link')?>"></i> <span><?=$this->getTranslation('menu ' . $value['alias'])?></span></a>
        </li>
        <?php } ?>
        <?php 
          $settingsMenuActive = false;
          if(in_array(CONTROLLER, ['option', 'translation', 'importproducts']) ){
            $settingsMenuActive = true;
          }
        ?>
        <li class="treeview<?php if($settingsMenuActive){ ?> active<?php } ?>">
          <a href="#"><i class="fa fa-cog"></i> <span><?=$this->getTranslation('settings')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu<?php if($settingsMenuActive){ ?> menu-open<?php } ?>">
            <li class="<?php if(CONTROLLER == 'option' && ACTION == 'index'){ ?> active<?php } ?>"><a href="<?=$commonSettingsUrl?>"><?=$this->getTranslation('common settings')?></a></li>
            <li class="<?php if(CONTROLLER == 'option' && ACTION == 'additional'){ ?> active<?php } ?>"><a href="<?=$additionalSettingsUrl?>"><?=$this->getTranslation('additional settings')?></a></li>
            <li class="<?php if(CONTROLLER == 'translation' && ACTION == 'index'){ ?> active<?php } ?>"><a href="<?=$translationsUrl?>"><?=$this->getTranslation('translations')?></a></li>
            <li class="<?php if(CONTROLLER == 'importproducts' && ACTION == 'index'){ ?> active<?php } ?>"><a href="<?=$xmlUploadUrl?>"><?=$this->getTranslation('xml file upload')?></a></li>
          </ul>
        </li>
        
      </ul>
      <!-- /.sidebar-menu -->
      <?php } ?>

    </section>
    <!-- /.sidebar -->
  </aside>