<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('stats page')?>
        <small><?=$this->getTranslation('contract completion')?></small>
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
      
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
            <?=$this->getTranslation('sales')?>
          </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="<?=$controls['current']?>" method="post">
            <div class="form-group">
              <div style="position: relative;">
                <button type="button" class="btn btn-default" id="my-date-range">
                  <span>
                    <i class="fa fa-calendar"></i> <?=$this->getTranslation('choose period')?>
                  </span>
                  <i class="fa fa-caret-down"></i>
                </button>
                <input name="filter_period" id="filter_period" class="form-control" type="hidden">
              </div>
            </div>
            <input class="btn btn-primary" type="submit" value="<?=$this->getTranslation('btn view')?>">
            <script>
              $(document).ready(function(){
                $('#my-date-range').daterangepicker(
                  {
                    <?php if($periodStartDate && $periodEndDate){ ?>
                    startDate: '<?=$periodStartDate?>',
                    endDate: '<?=$periodEndDate?>',
                    <?php } else { ?>
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    <?php } ?>
                    locale: {
                      format: "YYYY/MM/DD",
                      cancelLabel: 'отмена',
                      applyLabel: 'применить',
                      customRangeLabel: "выбрать",
                    },
                    ranges: {
                      'Сегодня': [moment(), moment()],
                      'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                      'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                      'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                      'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                      'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                  },
                  function (start, end) {
                    $('#my-date-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#filter_period').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
                  }
                );
              });
            </script>

            

          </form>
          <br>
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->


      
      
      <div class="box">
        <div class="box-header">
            <?php
              usort($users, function ($a, $b){
                  if ($a['period_all_fact_sum'] == $b['period_all_fact_sum']) {
                      return 0;
                  }
                  return ($a['period_all_fact_sum'] < $b['period_all_fact_sum']) ? +1 : -1;
              });
            ?>
            </div>
            <div class="box-body">
              <div class="">
                <button class="btn btn-default pull-right print-contract-table" data-target="period-table">
                  <i class="fa fa-print"></i>
                  <?=$this->getTranslation('print')?>
                </button>
                <div id="period-table">
                  <h3>
                    <?=$this->getTranslation('period')?>, <?=$periodStartName?> - <?=$periodEndName?>
                  </h3>
                  <div class="table-responsive">
                    <table class="table table-bordered stat-cc-table">
                      <thead>
                          <tr>
                            <th><?=$this->getTranslation('company name')?></th>
                            <?php foreach($categoryNames as $key => $value){ ?>
                            <th colspan="3" class="category-bg-<?=$key?>"><?=$value?></th>
                            <?php } ?>
                            <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <td></td>
                            <?php foreach($categoryNames as $key => $value){ ?>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('in fact quantity')?>, <?=$this->getTranslation('unit_dal')?></td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('in fact quantity')?>, <?=$this->getTranslation('unit')?></td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('in fact sum')?></td>
                            <?php } ?>
                            <td></td>
                          </tr>
                          <?php if($users){ ?>
                          <?php foreach($users as $value){ ?>
                          <tr>
                            <td class="stat-cc-name"><?=$value['company_name']?></td>
                            <?php foreach($categoryNames as $key1 => $value1){ ?>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=round($value['period_fact'][$key1]['quantity_dal'])?>
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=(int)$value['period_fact'][$key1]['quantity']?>
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=number_format($value['period_fact'][$key1]['sum'])?>&nbsp;<?=$this->translation($this->getOption('currency'))?>
                            </td>
                            <?php } ?>
                            <td class="td-shrink">
                                <!-- <a class="btn btn-success" title="<?=$this->getTranslation('btn view')?>" href="<?=$controls['view'] . $value['id'] . '/' . $i?>">
                                    <i class="fa fa-eye"></i>
                                </a> -->
                            </td>
                          </tr>
                          <?php } ?>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
          
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->