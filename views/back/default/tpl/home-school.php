<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->t('main page', 'back')?>
        <small><?=$this->t('control panel', 'back')?></small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$teachersQuantity?></h3>
              <p><?=$this->t('teachers', 'back')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-user-secret"></i>
            </div>
            <a href="<?=$teachersUrl?>" class="small-box-footer"><?=$this->t('more info', 'back')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green" title="<?=$leader['name']?>">
            <div class="inner">
              <h3><?=$studentsQuantity?></h3>
              <p><?=$this->t('students', 'back')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-child"></i>
            </div>
            <a href="<?=$studentsUrl?>" class="small-box-footer"><?=$this->t('more info', 'back')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$usersQuantity?></h3>
              <p><?=$this->t('users', 'back')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?=$usersUrl?>" class="small-box-footer"><?=$this->t('more info', 'back')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$lessonsQuantity?></h3>
              <p><?=$this->t('lessons', 'back')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>
            <a href="<?=$lessonsUrl?>" class="small-box-footer"><?=$this->t('more info', 'back')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      
      <!-- Main row -->
      <div class="row">
        
        <section class="col-lg-4 col-md-5 connectedSortable">
          <!-- Calendar -->
          <div class="box box-solid">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title"><?=$this->t('calendar', 'back')?></h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" data-language="<?=LANG_PREFIX?>" style="width: 100%"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>


      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->