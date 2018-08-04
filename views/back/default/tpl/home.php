Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('main page')?>
        <small><?=$this->getTranslation('control panel')?></small>
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
              <h3><?=$newOrders?></h3>
              <p><?=$this->getTranslation('new orders')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-basket"></i>
            </div>
            <a href="<?=$newOrdersUrl?>" class="small-box-footer"><?=$this->getTranslation('more info')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green" title="<?=$leader['name']?>">
            <div class="inner">
              <!-- <h3><?=$leader['quantity']?></h3> -->
              <h3>0</h3>

              <p style="max-width: 130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?=$leader['name']?>&nbsp;</p>
            </div>
            <div class="icon">
              <i class="fa fa-pie-chart"></i>
            </div>
            <a href="<?=$leader['url']?>" class="small-box-footer"><?=$this->getTranslation('more info')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$bases?></h3>
              <p><?=$this->getTranslation('users2')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?=$basesUrl?>" class="small-box-footer"><?=$this->getTranslation('more info')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=$products?></h3>
              <p><?=$this->getTranslation('products2')?></p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>
            <a href="<?=$productsUrl?>" class="small-box-footer"><?=$this->getTranslation('more info')?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> <?=$this->getTranslation('sales monthly')?> (<?=$this->getTranslation('sum')?>)</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title"><?=$this->getTranslation('sales monthly')?> (<?=$this->getTranslation('quantity')?>)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
            
            <div class="box-footer no-border">
              <div class="row">
                <?php
                /*
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">

                  <div class="knob-label">Mail-Orders</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">

                  <div class="knob-label">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">

                  <div class="knob-label">In-Store</div>
                </div>
                <!-- ./col -->
                */
                ?>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
          <!-- /.nav-tabs-custom -->
          

        </section>
        <!-- /.Left col -->
        

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
          
          <!-- Calendar -->
          <div class="box box-solid">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title"><?=$this->getTranslation('calendar')?></h3>
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

          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> <?=$this->getTranslation('sales by category')?></li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->




        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function(){
      
      <?php if($allOrdersCategories){ ?>
      //Donut Chart
      var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        formatter: function(y, data){
          return y + '%';
        },
        colors: ["#3c8dbc", "#f56954", "#00a65a", "#FCB712", "#00C0EF"],
        data: [
          <?php foreach($allOrdersCategories as $key => $value){ ?>
            {label: "<?=$value['name']?>", value: <?=$value['percent']?>}<?php if($value !== end($allOrdersCategories)){ ?>,<?php } ?>
          <?php } ?>
        ],
        hideHover: 'auto'
      });
      <?php } ?>

      // Sales chart
      var area = new Morris.Area({
        element: 'revenue-chart',
        resize: true,
        data: [
          <?php if($salesSort){ ?>
          <?php foreach($salesSort as $key => $value){ ?>
            {y: '<?=$value['y']?>', item1: <?=$value['sum']?>}<?php if($value !== end($salesSort)){ ?>,<?php } ?>
          <?php } ?>
          <?php } ?>
        ],
        postUnits: ' <?=$this->translation($this->getOption('currency'))?>',
        xkey: 'y',
        ykeys: ['item1'],
        labels: ['<?=$this->getTranslation('sum')?>'],
        lineColors: ['#a0d0e0'],
        hideHover: 'auto'
      });

      var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        data: [
          <?php if($salesSort){ ?>
          <?php foreach($salesSort as $key => $value){ ?>
            {y: '<?=$value['y']?>', item1: <?=$value['quantity']?>}<?php if($value !== end($salesSort)){ ?>,<?php } ?>
          <?php } ?>
          <?php } ?>
        ],
        postUnits: ' <?=$this->getTranslation('unit')?>',
        xkey: 'y',
        ykeys: ['item1'],
        labels: ['<?=$this->getTranslation('quantity')?>'],
        lineColors: ['#efefef'],
        lineWidth: 2,
        hideHover: 'auto',
        gridTextColor: "#fff",
        gridStrokeWidth: 0.4,
        pointSize: 4,
        pointStrokeColors: ["#efefef"],
        gridLineColor: "#efefef",
        gridTextSize: 10
      });
    });
  </script>