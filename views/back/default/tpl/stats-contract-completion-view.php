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
          <p>
            <a class="btn btn-default" href="<?=$allUsercontracts?>">
              <i class="fa fa-arrow-left"></i>
              <?=$this->getTranslation('all usercontracts')?>
            </a>
          </p>
          <h3 class="box-title">
            <?=$this->getTranslation('usercontract')?> #<?=$usercontract['contract_number']?>, <?=$filterYear?><br>
          </h3>
          <p><?=$usercontract['company_name']?></p>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="<?=$controls['current']?>" class="form-inline">
            <div class="form-group">
              <!-- <?php if($years){ ?>
              <select class="form-control" name="year" id="filter_year">
                <?php foreach($years as $value){ ?>
                <option value="<?=$value?>"><?=$value?></option>
                <?php } ?>
              </select>
              <?php } ?>
              <input class="btn btn-primary" type="submit" value="<?=$this->getTranslation('filter')?>">
              &nbsp;
              &nbsp;
              &nbsp; -->
              <?php for($i = 1; $i <= 4; $i++){ ?>
              <a class="btn btn-default quarter-btn <?php if($quarterActive == $i){ ?>active<?php } ?>" data-toggle="tab" href="#tab-quarter-<?=$i?>" >
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
              <div id="tab-quarter-<?=$i?>" class="tab-pane quarter-tab-pane fade <?php if($quarterActive == $i){ ?>in active<?php } ?>">
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
                          </tr>
                          <?php if($usercontract){ ?>
                          <tr>
                            <td class="stat-cc-name"><?=$usercontract['company_name']?></td>
                            <?php foreach($categoryNames as $key1 => $value1){ ?>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$usercontract['quarter_' . $i][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$usercontract['quarter_' . $i . '_fact'][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$usercontract['quarter_' . $i . '_fact'][$key1]['quantity_dal'] - $usercontract['quarter_' . $i][$key1]['quantity_dal']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <?php } ?>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <?php foreach($categoryNames as $key => $value){ ?>
                  <div class="quarter-orders-details">
                    <h4><?=$value?></h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <tr>
                          <th colspan="2"><?=$this->getTranslation('product name')?></th>
                          <th><?=$this->getTranslation('quantity')?></th>
                          <th><?=$this->getTranslation('sum')?></th>
                        </tr>
                        <?php 
                          $currentArr = $usercontract['quarter_' . $i . '_fact'][$key]['items'];
                        ?>
                        <?php if($currentArr){ ?>
                        <?php foreach($currentArr as $key1 => $value1){ ?>
                        <tr>
                          <td class="td-shrink">
                            <a target="_blank" href="<?=$value1['url']?>">
                              <img src="<?=$value1['icon']?>" alt="<?=$value1['name'][LANG_ID]?>">
                            </a>
                          </td>
                          <td>
                            <a target="_blank" href="<?=$value1['url']?>">
                              <?=$value1['name'][LANG_ID]?>
                            </a>
                          </td>
                          <td class="td-shrink">
                            <?=round($value1['sold_quantity_dal'])?>&nbsp;<?=$this->getTranslation('unit_dal')?>
                          </td>
                          <td class="td-shrink">
                            <?=number_format($value1['sold_sum'])?>&nbsp;<?=$this->translation($this->getOption('currency'))?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                          <td colspan="4" ">
                            <?=$this->getTranslation('no orders')?>
                          </td>
                        </tr>
                        <?php } ?>
                      </table>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
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
                          </tr>
                          <?php if($usercontract){ ?>
                          <tr>
                            <td class="stat-cc-name"><?=$usercontract['company_name']?></td>
                            <?php foreach($categoryNames as $key1 => $value1){ ?>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$usercontract['year_total'][$key1]['quantity']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$usercontract['year_total_fact'][$key1]['quantity']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <td class="td-shrink stat-cc-td category-bg-<?=$key1?>">
                              <?=$usercontract['year_total_fact'][$key1]['quantity'] - $usercontract['year_total'][$key1]['quantity']?><!-- &nbsp;<?=$this->getTranslation('unit')?> -->
                            </td>
                            <?php } ?>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  
                  <?php foreach($categoryNames as $key => $value){ ?>
                  <div class="quarter-orders-details">
                    <h4><?=$value?></h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <tr>
                          <th colspan="2"><?=$this->getTranslation('product name')?></th>
                          <th><?=$this->getTranslation('quantity')?></th>
                          <th><?=$this->getTranslation('sum')?></th>
                        </tr>
                        <?php 
                          $currentArr = $usercontract['year_total_fact'][$key]['items'];
                        ?>
                        <?php if($currentArr){ ?>
                        <?php foreach($currentArr as $key1 => $value1){ ?>
                        <tr>
                          <td class="td-shrink">
                            <a target="_blank" href="<?=$value1['url']?>">
                              <img src="<?=$value1['icon']?>" alt="<?=$value1['name'][LANG_ID]?>">
                            </a>
                          </td>
                          <td>
                            <a target="_blank" href="<?=$value1['url']?>">
                              <?=$value1['name'][LANG_ID]?>
                            </a>
                          </td>
                          <td class="td-shrink">
                            <?=round($value1['sold_quantity_dal'])?>&nbsp;<?=$this->getTranslation('unit_dal')?>
                          </td>
                          <td class="td-shrink">
                            <?=number_format($value1['sold_sum'])?>&nbsp;<?=$this->translation($this->getOption('currency'))?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                          <td colspan="4" ">
                            <?=$this->getTranslation('no orders')?>
                          </td>
                        </tr>
                        <?php } ?>
                      </table>
                    </div>
                  </div>
                  <?php } ?>

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