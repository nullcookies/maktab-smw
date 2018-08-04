<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->getTranslation('edit order');?>
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
    
        <form id="order-edit-form" role="form" action="<?=$controls['action']?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$order['id']?>" />
            
            <div class="form-group">
                <a class="btn btn-default btn-app" href="<?=$controls['back']?>">
                    <i class="fa fa-arrow-left"></i>
                    <?=$this->getTranslation('btn back')?>
                </a>
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <a target="_blank" class="btn btn-warning btn-app" href="<?=$controls['invoice']?>">
                    <i class="fa fa-print"></i>
                    <?=$this->getTranslation('invoice')?>
                </a>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="date">
                                    <?=$this->getTranslation('date')?>
                                </label>
                                <p class="form-control-static">
                                    <?=date('Y/m/d', $order['date'])?>
                                </p>
                                <input type="hidden" name="date" value="<?=$order['date']?>">
                            </div>
                            <div class="form-group <?php if($errors['fio']) { ?>has-error<?php } ?>">
                                <label for="fio">
                                    <?=$this->getTranslation('fio')?>
                                </label>
                                <input type="text" class="form-control" name="fio" id="fio" value="<?=$order['fio']; ?>" />
                                <?php if($errors['fio']) { ?><div class="help-block"><?=$this->getTranslation($errors['fio'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['email']) { ?>has-error<?php } ?>">
                                <label for="email">
                                    <?=$this->getTranslation('email')?>
                                </label>
                                <input type="text" class="form-control" name="email" id="email" value="<?=$order['email']; ?>" />
                                <?php if($errors['email']) { ?><div class="help-block"><?=$this->getTranslation($errors['email'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['phone']) { ?>has-error<?php } ?>">
                                <label for="phone">
                                    <?=$this->getTranslation('phone')?>
                                </label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?=$order['phone']; ?>" />
                                <?php if($errors['phone']) { ?><div class="help-block"><?=$this->getTranslation($errors['phone'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['address']) { ?>has-error<?php } ?>">
                                <label for="address">
                                    <?=$this->getTranslation('address')?>
                                </label>
                                <input type="text" class="form-control" name="address" id="address" value="<?=$order['address']; ?>" />
                                <?php if($errors['address']) { ?><div class="help-block"><?=$this->getTranslation($errors['address'])?></div><?php } ?>
                            </div>
                            
                            <?php /*
                            <div class="form-group <?php if($errors['dover']) { ?>has-error<?php } ?>">
                                <label for="dover">
                                    <?=$this->getTranslation('dover')?>
                                </label>
                                <input type="text" class="form-control" name="dover" id="dover" value="<?=$order['dover']; ?>" />
                                <?php if($errors['dover']) { ?><div class="help-block"><?=$this->getTranslation($errors['dover'])?></div><?php } ?>
                            </div>
                            <div class="form-group <?php if($errors['dover_date']) { ?>has-error<?php } ?>">
                                <label for="dover_date">
                                    <?=$this->getTranslation('dover_date')?>
                                </label>
                                <input type="text" class="form-control datepicker" name="dover_date" id="dover_date" value="<?=$order['dover_date']; ?>" />
                                <?php if($errors['dover_date']) { ?><div class="help-block"><?=$this->getTranslation($errors['dover_date'])?></div><?php } ?>
                            </div>
                            */ ?>

                            <div class="form-group">
                                <label for="comment">
                                    <?=$this->getTranslation('comment')?>
                                </label>
                                <p class="form-control-static" ><?=$order['comment']?></p>
                            </div>

                            <?php if($orderComments){ ?>
                            <div class="form-group">
                            <?php foreach($orderComments as $value){ ?>
                            <div class="form-control-static">
                                <strong><?=date('Y-m-d H:i')?></strong> // <?=$this->getTranslation('order status')?>: <?=$this->getTranslation('order status ' . $value['new_status'])?> // <?=$this->getTranslation('customer notified')?>: <?php echo ( ($value['customer_notified']) ? $this->getTranslation('yes') : $this->getTranslation('no') ) ?><br>
                                <?=$value['comment']?> 
                            </div>
                            <?php } ?>
                            </div>
                            <?php } ?>
                            
                            <div class="form-group">
                                <label for="notify_customer"><?=$this->getTranslation('send email to customer');?></label>
                                <div class="form-control-static">
                                    <input class="flat-blue" type="checkbox" name="notify_customer" id="notify_customer" />
                                </div>
                            </div>
                            
                            <div class="form-group <?php if($errors['add_comment']) { ?>has-error<?php } ?>">
                                <label for="add_comment">
                                    <?=$this->getTranslation('add comment')?>
                                </label>
                                <textarea class="form-control" name="add_comment" id="add_comment" ><?=$order['add_comment']; ?></textarea>
                                <?php if($errors['add_comment']) { ?><div class="help-block"><?=$this->getTranslation($errors['add_comment'])?></div><?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label for=""><?=$this->getTranslation('status')?></label>
                                <select name="status" class="form-control selectpicker">
                                    <option value="0">-</option>
                                    <?php if($orderStatuses){ ?>
                                    <?php foreach($orderStatuses as $value){ ?>
                                    <option value="<?=$value?>" <?php if($value == $order['status']){ ?>selected<?php } ?> ><?=$this->getTranslation('order status ' . $value)?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="items" value="<?=htmlspecialchars($order['items'])?>">
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th><?=$this->getTranslation('product name')?></th>
                                        <th><?=$this->getTranslation('price')?></th>
                                        <th><?=$this->getTranslation('quantity')?></th>
                                        <th><?=$this->getTranslation('line total')?></th>
                                    </tr>
                                    <?php if($currentItems){ ?>
                                    <?php foreach($currentItems as $value){ ?>
                                    <tr>
                                        <td>
                                            <img src="<?=$value['icon']?>" alt="<?=$value['name']?>">
                                        </td>
                                        <td>
                                            <p>
                                                <a target="_blank" href="<?=$value['url']?>"><?=$value['name']?></a>
                                            </p>
                                            <?php if($value['configuration']){ ?>
                                            <?php foreach($value['configuration'] as $value1){ ?>
                                            <div>
                                              <strong><?=$value1['name']?>: </strong>
                                              <span><?=$value1['value']?></span>
                                              <?php if($value1['price'] > 0){ ?>
                                              <span>(+<?=$value1['price']?>&nbsp;<?=$this->translation($this->getOption('currency'))?>)</span>
                                              <?php } ?>
                                            </div>
                                            <?php } ?>
                                            <?php } ?>

                                        </td>
                                        <td><?=$value['price']?>&nbsp;<?=$this->translation($this->getOption('currency'))?></td>
                                        <td><?=$value['quantity']?> <?=$value['unit']?></td>
                                        <td><?=$value['line_total']?>&nbsp;<?=$this->translation($this->getOption('currency'))?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>

                                    <?php if(isset($subtotal) && $total != $subtotal){ ?>
                                    <tr>
                                        <td colspan="4">
                                            <strong>
                                                <?=$this->getTranslation('subtotal')?>
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="green-text">
                                                <?=$this->formatPrice($subtotal)?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                    <?php if(!empty($coupon)){ ?>
                                    <tr>
                                        <td colspan="5">
                                            <?php printf($this->getTranslation('Coupon "%s" applied'), $coupon['coupon_code']); ?> (<?=$coupon['coupon_value']?>)
                                        </td>
                                    </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="4">
                                            <strong><?=$this->getTranslation('total')?></strong>
                                        </td>
                                        <td>
                                            <strong><?=$total?>&nbsp;<?=$this->translation($this->getOption('currency'))?></strong>
                                        </td>
                                    </tr>
                                </table>
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
                <button class="btn btn-success btn-app" type="submit">
                    <i class="fa fa-save"></i>
                    <?=$this->getTranslation('btn save')?>
                </button>
                <input type="hidden" name="btn_edit" value="<?=$this->getTranslation('btn save')?>" />
            </div>

        </form>
    </section>
    <!-- /.content -->
</div>

        