<div class="container">
    <div class="invoice-container">
        
        <h1 class="invoice-header">
            <?=$this->getTranslation('invoice-waybill')?> №<?=$order['id']?>
        </h1>
        <div class="invoice-top">
            <?=$this->getTranslation('from')?> <?=date('d-m-Y')?>
        </div>

        <div class="invoice-addresses">
            <div class="row">
                <div class="col-xs-6">
                    <table class="invoice-address-table">
                        <tr>
                            <td><?=$this->getTranslation('supplier')?></td>
                            <td><?=$requisites['supplier']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('address')?></td>
                            <td><?=$requisites['address']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('phone')?></td>
                            <td><?=$requisites['phone']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('checking account')?></td>
                            <td><?=$requisites['checking_account']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('bank name')?></td>
                            <td><?=$requisites['bank_name']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('mfo')?></td>
                            <td><?=$requisites['mfo']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('inn')?></td>
                            <td><?=$requisites['inn']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('okonx')?></td>
                            <td><?=$requisites['okonx']?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-6">
                    <table class="invoice-address-table">
                        <tr>
                            <td><?=$this->getTranslation('receipent')?></td>
                            <td><?=$user['company_name']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('address')?></td>
                            <td><?=$user['address_jur']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('phone')?></td>
                            <td><?=$user['phone']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('checking account')?></td>
                            <td><?=$user['checking_account']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('bank name')?></td>
                            <td><?=$user['bank_name']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('mfo')?></td>
                            <td><?=$user['mfo']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('inn')?></td>
                            <td><?=$user['inn']?></td>
                        </tr>
                        <tr>
                            <td><?=$this->getTranslation('okonx')?></td>
                            <td><?=$user['okonx']?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>





        <table class="table table-bordered invoice-table">
            <tr>
                <th rowspan="2"><?=$this->getTranslation('product name')?></th>
                <th rowspan="2"><?=$this->getTranslation('prod. unit')?></th>
                <th rowspan="2"><?=$this->getTranslation('qty')?></th>
                <th rowspan="2"><?=$this->getTranslation('price')?></th>
                <th rowspan="2"><?=$this->getTranslation('total original')?></th>
                <th colspan="2"><?=$this->getTranslation('excise')?></th>
                <th colspan="2"><?=$this->getTranslation('nds')?></th>
                <th rowspan="2"><?=$this->getTranslation('total with nds')?></th>
            </tr>
            <tr>
                <th><?=$this->getTranslation('for item')?></th>
                <th><?=$this->getTranslation('sum')?></th>
                <th><?=$this->getTranslation('for item')?></th>
                <th><?=$this->getTranslation('sum')?></th>
            </tr>
            <?php foreach($currentItems as $value){ ?>
            <tr>
                <td><?=$value['name']?></td>
                <td><?=$this->getTranslation('unit')?></td>
                <td style="text-align: center;"><?=$value['quantity']?></td>
                <td style="text-align: right;"><?=number_format($value['price'], 2)?></td>
                <td style="text-align: right;"><?=number_format($value['line_total_orig'], 2)?></td>
                <td style="text-align: right;"><?=number_format($value['excise'], 2)?></td>
                <td style="text-align: right;"><?=number_format($value['line_excise'], 2)?></td>
                <td style="text-align: center;"><?=$value['nds_percent']?></td>
                <td style="text-align: right;"><?=number_format($value['line_nds'], 2)?></td>
                <td style="text-align: right;"><?=number_format($value['line_total'], 2)?></td>
            </tr>
            <?php } ?>
            
            <?php if(isset($subtotal) && $total != $subtotal){ ?>
            <tr>
                <td><strong><?=$this->getTranslation('total')?></strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"><strong><?=number_format($totalOrig, 2)?></strong></td>
                <td></td>
                <td style="text-align: right;"><strong><?=number_format($totalExcise, 2)?></strong></td>
                <td></td>
                <td style="text-align: right;"><strong><?=number_format($totalNds, 2)?></strong></td>
                <td style="text-align: right;"><strong><?=number_format($subtotal, 2)?></strong></td>
            </tr>
            <?php } ?>

            <tr>
                <td><strong><?=$this->getTranslation('total payment')?></strong></td>
                <td colspan="9" style="text-align: right;">
                    <?php if(!empty($coupon)){ ?>
                    <span>
                        <?php printf($this->getTranslation('Coupon "%s" applied'), $coupon['coupon_code']); ?> (<?=$coupon['coupon_value']?>)
                    </span>
                    <br>
                    <?php } ?>
                    <strong><?=number_format($total, 2)?></strong>
                </td>
            </tr>
        </table>

        <div class="invoice-sum-propis">
            <?=$this->getTranslation('goods released sum')?> 
            <i><?=$totalStr?></i>
        </div>

        <div class="invoice-bottom">
            <div class="row">
                <div class="col-xs-6">
                    <p>
                        <?=$this->getTranslation('chief director')?> ___________________ <?=$chiefDirector?>
                    </p>
                    <p>
                        <?=$this->getTranslation('chief accountant')?> ____________________ <?=$chiefAccountant?>
                    </p>
                    <p>
                        М.П.
                    </p>
                    <p>
                        <?=$this->getTranslation('goods released')?> __________________
                    </p>
                </div>
                <div class="col-xs-6">
                    <p>
                        <?=$this->getTranslation('accepted')?> ____________________________ 
                    </p>
                    <p>
                        <?=$this->getTranslation('through')?> ______________________________
                    </p>
                    <p>
                        <?=$this->getTranslation('dover')?> № <?=$order['dover']?> <?=$this->getTranslation('from')?> <?=$order['dover_date']?>
                    </p>
                    <p>
                        <?=$this->getTranslation('cargo accepted to shipping')?> _______________
                    </p>
                    <p>
                        ___________________________________
                    </p>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
    window.print();
</script>