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
            <?=$this->getTranslation('usercontract list')?> - 
            <?=$filterYear?>
          </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="<?=$controls['current']?>" class="form-inline">
            <div class="form-group">
              <?php if($years){ ?>
              <select class="form-control" name="year" id="filter_year">
                <?php foreach($years as $value){ ?>
                <option value="<?=$value?>"><?=$value?></option>
                <?php } ?>
              </select>
              <?php } ?>
              <input class="btn btn-primary" type="submit" value="<?=$this->getTranslation('filter')?>">
              &nbsp;
              &nbsp;
              &nbsp;
              <?php for($i = 1; $i <= 4; $i++){ ?>
              <a class="btn btn-default quarter-btn <?php if($currentQuarter == $i){ ?>active<?php } ?>" data-toggle="tab" href="#tab-quarter-<?=$i?>" >
                <?=$this->getTranslation('quarter')?> <?=$i?>
              </a>
              <?php } ?>
              <a class="btn btn-default quarter-btn" data-toggle="tab" href="#tab-year">
                <?=$this->getTranslation('year')?>
              </a>


            </div>

          </form>
          <br>
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->


      
      
      <div class="box">
        <div class="box-header">
            <div class="tab-content">
              <?php for($i = 1; $i <= 4; $i++){ ?>
              <?php
                usort($usercontracts, function ($a, $b) use ($i){
                    if ($a['quarter_' . $i . '_all_fact_sum'] == $b['quarter_' . $i . '_all_fact_sum']) {
                        return 0;
                    }
                    return ($a['quarter_' . $i . '_all_fact_sum'] < $b['quarter_' . $i . '_all_fact_sum']) ? +1 : -1;
                });
              ?>
              <div id="tab-quarter-<?=$i?>" class="tab-pane quarter-tab-pane fade <?php if($currentQuarter == $i){ ?>in active<?php } ?>">
                <button class="btn btn-default pull-right print-contract-table" data-target="quarter-table-<?=$i?>">
                  <i class="fa fa-print"></i>
                  <?=$this->getTranslation('print')?>
                </button>
                <div id="quarter-table-<?=$i?>">
                  <h3>
                    <?=$this->getTranslation('quarter')?> <?=$i?>, <?=$filterYear?>
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
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('by contract')?></td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('in fact')?></td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('difference')?></td>
                            <?php } ?>
                            <td></td>
                          </tr>
                          <?php if($usercontracts){ ?>
                          <?php foreach($usercontracts as $value){ ?>
                          <tr>
                            <td class="stat-cc-name"><?=$value['company_name']?></td>
                            <?php foreach($categoryNames as $key1 => $value1){ ?>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$value['quarter_' . $i][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=round($value['quarter_' . $i . '_fact'][$key1]['quantity_dal'])?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=round($value['quarter_' . $i . '_fact'][$key1]['quantity_dal']) - $value['quarter_' . $i][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <?php } ?>
                            <td class="td-shrink">
                                <a class="btn btn-success" title="<?=$this->getTranslation('btn view')?>" href="<?=$controls['view'] . $value['id'] . '/' . $i?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                          </tr>
                          <?php } ?>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php } ?>

              <?php
                usort($usercontracts, function ($a, $b){
                    if ($a['year_total_all_fact_sum'] == $b['year_total_all_fact_sum']) {
                        return 0;
                    }
                    return ($a['year_total_all_fact_sum'] < $b['year_total_all_fact_sum']) ? +1 : -1;
                });
              ?>
              <div id="tab-year" class="tab-pane fade">
                <button class="btn btn-default pull-right print-contract-table" data-target="quarter-table-year">
                  <i class="fa fa-print"></i>
                  <?=$this->getTranslation('print')?>
                </button>
                <div id="quarter-table-year">
                  <h3>
                    <?=$this->getTranslation('year')?>
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
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('by contract')?></td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('in fact')?></td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key?>"><?=$this->getTranslation('difference')?></td>
                            <?php } ?>
                            <td></td>
                          </tr>
                          <?php if($usercontracts){ ?>
                          <?php foreach($usercontracts as $value){ ?>
                          <tr>
                            <td class="stat-cc-name"><?=$value['company_name']?></td>
                            <?php foreach($categoryNames as $key1 => $value1){ ?>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$value['year_total'][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=round($value['year_total_fact'][$key1]['quantity_dal'])?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=round($value['year_total_fact'][$key1]['quantity_dal']) - $value['year_total'][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <?php } ?>
                            <td class="td-shrink">
                                <a class="btn btn-success" title="<?=$this->getTranslation('btn view')?>" href="<?=$controls['view'] . $value['id']?>">
                                    <i class="fa fa-eye"></i>
                                </a>
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
          </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
          
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->