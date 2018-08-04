<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\front\MailerModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class OrderModel extends Model {

    public $orderStatuses = [0, 1, 2, 3];
	//0 - Order is available for sell, anyone can buy it.
    //1 - Pay in progress, order must not be changed.
    //2 - Order completed and not available for sell.
    //3 - Order is cancelled.

    public function index() {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');

        $controls = [];

        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $data['statusIconsPath'] = $this->linker->getIcon('order-status');

        $orders = [];
        $getOrders = $this->qb->select('o.*, u.name u_name, u.company_name u_company_name')->join('??user u', 'o.user_id = u.id')->get('??order o');
        if($getOrders->rowCount() > 0){
            $orders = $getOrders->fetchAll();
            foreach($orders as $key => $value){
                $orders[$key]['coupon'] = json_decode($value['coupon'], true);
                $orders[$key]['items'] = json_decode($value['items'], true);
                $orders[$key]['info'] = [];
                $orders[$key]['info']['sum'] = 0;
                $orders[$key]['info']['quantity'] = 0;
                if($orders[$key]['items']){
                    foreach($orders[$key]['items'] as $item){
                        $orders[$key]['info']['sum'] += $item['price'] * $item['quantity'];
                        $orders[$key]['info']['quantity'] += $item['quantity'];
                    }
                    if(isset($orders[$key]['coupon']['coupon_discount'])){
                        $orders[$key]['info']['sum'] -= (float)$orders[$key]['coupon']['coupon_discount'];
                    }
                }
            }
        }

        $data['orders'] = $orders;
        $data['orderStatuses'] = $this->orderStatuses;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    /*
    public function add(){
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('add ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('add ' . $this->control);

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/all.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/adapters/jquery.js');
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/add', true);

        $data['controls'] = $controls;

        $data[$this->control] = [];
        if($_POST){
            $data[$this->control] = $_POST;
        }
        
        $categories = [];
        $getOrders = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??order');
        if($getOrders->rowCount() > 0){
            $categories = $getOrders->fetchAll();
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['categories'] = $categories;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    */

    public function edit() {

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
        
        $id = (int)$_GET['param1'];
        if(!$id){
            $id = (int)$_POST['id'];
        }
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('edit ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control);

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/all.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/adapters/jquery.js');
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['invoice'] = $this->linker->getUrl($this->control . '/invoice/' . $id, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);

        $data['controls'] = $controls;

        $current = [];
        if($id){
            $getOrder = $this->qb->where('id', '?')->get('??order', [$id]);
            if($getOrder->rowCount() > 0){
                $order = $getOrder->fetchAll();
                $current = $order[0];
                if($current['new']){
                    $this->qb->where('id', '?')->update('??order', ['new' => 0], [$id]);
                }
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $total = 0;
        $orderItems = [];
        $coupon = json_decode($current['coupon'], true);
        $currentItems = json_decode($current['items'], true);
        $orderItemIds = [];
        if($currentItems){
            foreach($currentItems as $value){
                $orderItemIds[] = $value['product_id'];
            }
            $getOrderItems = $this->qb->select('id, name, alias, images, unit')->where('id IN', $orderItemIds)->get('??product');
            if($getOrderItems->rowCount() > 0){
                $orderItems = $getOrderItems->fetchAll();
                foreach ($currentItems as $key => $value) {
                    $currentItems[$key]['line_total'] = $value['price'] * $value['quantity'];
                    $total += $currentItems[$key]['line_total'];
                    foreach($orderItems as $k => $v){
                        if($value['product_id'] == $v['id']){
                            $currentItems[$key]['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($v['images']), $smallIconW, $smallIconH));
                            $currentItems[$key]['name'] = json_decode($v['name'], true)[LANG_ID];
                            $currentItems[$key]['url'] = $this->linker->getUrl($v['alias']);
                            $currentItems[$key]['unit'] = $v['unit'];
                        }
                    }
                }
            }
        }

        $data[$this->control] = $current;

        $orderComments = [];
        $getOrderComments = $this->qb->where('order_id', '?')->order('date')->get('??order_change', [$id]);
        if($getOrderComments->rowCount() > 0){
            $orderComments = $getOrderComments->fetchAll();
        }
        $data['orderComments'] = $orderComments;

        $data['orderStatuses'] = $this->orderStatuses;
        $data['subtotal'] = $total;
        if(isset($coupon['coupon_discount'])){
            $total -= (float)$coupon['coupon_discount'];
        }
        $data['total'] = $total;
        $data['coupon'] = $coupon;
        $data['currentItems'] = $currentItems;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }

    public function invoice() {

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
        
        $id = (int)$_GET['param1'];
        if(!$id){
            $id = (int)$_POST['id'];
        }
        
        $data = [];

        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('invoice') . ' - ' . $id;

        $current = [];
        if($id){
            $getOrder = $this->qb->where('id', '?')->get('??order', [$id]);
            if($getOrder->rowCount() > 0){
                $order = $getOrder->fetchAll();
                $current = $order[0];
            }
        }
        $user = $this->qb->where('id', '?')->get('??user', [$current['user_id']])->fetch();
        $data['user'] = $user;


        $total = 0; //тотал цнеа
        $totalOrig = 0; //тотал оригинал цена
        $totalExcise = 0; //тотал акциз
        $totalNds = 0; //тотал ндс

        $coupon = json_decode($current['coupon'], true);

        $orderItems = [];
        $currentItems = json_decode($current['items'], true); //товары в текущем заказе
        $orderItemIds = [];

        if($currentItems){
            foreach($currentItems as $value){
                $orderItemIds[] = $value['product_id'];
            }
            //товары из заказа в базе 
            $getOrderItems = $this->qb->where('id IN', $orderItemIds)->get('??product');
            if($getOrderItems->rowCount() > 0){
                $orderItems = $getOrderItems->fetchAll();
                foreach ($currentItems as $key => $value) {
                    $currentItems[$key]['line_total'] = $value['price'] * $value['quantity'];
                    $total += $currentItems[$key]['line_total'];
                    foreach($orderItems as $k => $v){
                        if($value['product_id'] == $v['id']){
                            $currentItems[$key]['line_total_orig'] = $v['price_orig'] * $value['quantity'];
                            $totalOrig += $currentItems[$key]['line_total_orig'];
                            
                            $currentItems[$key]['excise'] = $v['excise'];
                            $currentItems[$key]['line_excise'] = $v['excise'] * $value['quantity'];
                            $totalExcise += $currentItems[$key]['line_excise'];

                            $currentItems[$key]['nds_percent'] =  $v['nds'];
                            $currentItems[$key]['nds'] = $v['nds'] / 100 * $value['price'];
                            $currentItems[$key]['line_nds'] = $currentItems[$key]['nds'] * $value['quantity'];
                            $totalNds += $currentItems[$key]['line_nds'];

                            $currentItems[$key]['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($v['images']), $smallIconW, $smallIconH));
                            $currentItems[$key]['name'] = json_decode($v['name'], true)[LANG_ID];
                            $currentItems[$key]['url'] = $this->linker->getUrl($v['alias']);
                        }
                    }
                }
            }
        }
            


        $data[$this->control] = $current;
        $data['orderStatuses'] = $this->orderStatuses;
        
        $data['subtotal'] = $total;
        if(isset($coupon['coupon_discount'])){
            $total -= (float)$coupon['coupon_discount'];
        }
        $data['total'] = $total;
        $data['coupon'] = $coupon;

        $data['totalStr'] = $this->num2str($total);
        $data['totalOrig'] = $totalOrig;
        $data['totalExcise'] = $totalExcise;
        $data['totalNds'] = $totalNds;

        $data['currentItems'] = $currentItems;

        $requisites = [];
        $requisites['supplier'] = $this->getOption('supplier');
        $requisites['address'] = $this->getOption('address');
        $requisites['phone'] = $this->getOption('phone1');
        $requisites['checking_account'] = $this->getOption('checking_account');
        $requisites['bank_name'] = $this->getOption('bank_name');
        $requisites['mfo'] = $this->getOption('mfo');
        $requisites['inn'] = $this->getOption('inn');
        $requisites['okonx'] = $this->getOption('okonx');
        $data['requisites'] = $requisites;

        $data['chiefDirector'] = $this->getOption('chiefDirector');
        $data['chiefAccountant'] = $this->getOption('chiefAccountant');

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false){
        
        if(!$new) {
            $id = (int)$_POST['id'];
        }

        $rules = [ 
            'post' => [
                'fio' => ['isRequired'],
                //'dover' => ['isRequired'],
                //'dover_date' => ['isRequired'],
            ]
        ];

        $_POST = $this->cleanForm($_POST);
        
        $data['post'] = $_POST;

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){

            if(!$new){
                $this->errorText = $this->getTranslation('error edit ' . $this->control);
            }
            else{
                $this->errorText = $this->getTranslation('error add ' . $this->control);
            }
            $this->errors = $this->validator->lastErrors;
            return false;

        }
        else{

            if(!$new) {

                $update = [];

                $newStatus = (int)$_POST['status'];
                $notifyCustomer = ($_POST["notify_customer"]) ? 1 : 0;

                $currentOrder = $this->qb->where('id', '?')->get('??order', [$id])->fetch();

                $orderStock = (int)$currentOrder['stock_id'];
                $orderTotal = 0;
                $orderItems = json_decode($currentOrder['items'], true);
                if($orderItems){
                    foreach($orderItems as $key => $value){
                        $orderTotal += $value['quantity'] * $value['price'];
                    }
                }

                //если новый статус заказа отмена и если ранее не был отменен
                if($newStatus == 3 && $currentOrder['last_stock_change'] == 'decrease' && $currentOrder['last_balance_change'] == 'decrease'){
                    
                    //если заказ не анонимный возвращаем деньги в баланс пользователя
                    if($currentOrder['user_id'] != 0){
                        $userBalance = (int)$this->qb->where('id', '?')->get('??user', [$currentOrder['user_id']])->fetch()['balance'];
                        $userBalance += $orderTotal;
                        $this->qb->where('id', '?')->update('??user', ['balance' => $userBalance], [$currentOrder['user_id']]);
                    }
                    //возвращаем товары в сток
                    if($orderItems){
                        $returnProductSth = $this->qb->prepare('UPDATE ??product SET stock_' . $orderStock . ' = stock_' . $orderStock . ' + ? WHERE id = ?');
                        foreach($orderItems as $key => $value){
                            $returnProductSth->execute([$value['quantity'], $value['product_id']]);
                        }
                    }
                    //отметим что товары и деньги из этого заказа был возвращены в сток и баланс пользователя соответственно
                    $this->qb->where('id', '?')->update('??order', ['last_stock_change' => 'increase', 'last_balance_change' => 'increase'], [$currentOrder['id']]);
                }

                //если новый статус заказа ожидание, оплачен или завершен и если ранее был отменен
                if(($newStatus == 1 || $newStatus == 2 || $newStatus == 4) && $currentOrder['last_stock_change'] == 'increase' && $currentOrder['last_balance_change'] == 'increase'){
                    //если заказ не анонимный списываем деньги из баланса пользователя
                    if($currentOrder['user_id'] != 0){
                        $userBalance = (int)$this->qb->where('id', '?')->get('??user', [$currentOrder['user_id']])->fetch()['balance'];
                        $userBalance -= $orderTotal;
                        $this->qb->where('id', '?')->update('??user', ['balance' => $userBalance], [$currentOrder['user_id']]);
                    }
                    //уменьшаем к-во товара в стоке
                    if($orderItems){
                        $withdrawProductSth = $this->qb->prepare('UPDATE ??product SET stock_' . $orderStock . ' = stock_' . $orderStock . ' - ? WHERE id = ?');
                        foreach($orderItems as $key => $value){
                            $withdrawProductSth->execute([$value['quantity'], $value['product_id']]);
                        }
                    }
                    //отметим что товары и деньги из этого заказа былы сняты из стока и из баланса пользователя соответственно
                    $this->qb->where('id', '?')->update('??order', ['last_stock_change' => 'decrease', 'last_balance_change' => 'decrease'], [$currentOrder['id']]);
                }

                //отправляем email если отмечена оповещения покупателя
                if($notifyCustomer){
                    $mailer = new MailerModel;
                    
                    //admin mail
                    $fromemail = $this->getOption('contact_mail'); 
                    $fromname = $this->getOption('store_name');
                    $toemail = $_POST['email']; 
                    $toname = $_POST['fio'];
                    $subject = $this->getTranslation('order has been changed') . ' - ' . $this->config['sitename'];;
                    $message = '<h1>' . $subject . '</h1>';
                    $message .= '<p>' . $_POST['add_comment'] . '</p>';
                    $customerOrderLink = $this->linker->getUrl('user/orders/') . $id . '-' . $_POST['date'] . '/';
                    $message .= '<p><a target="_blank" href="' . $customerOrderLink . '">' . $this->translation('order details') . '</a></p>';
                    $mailer->sendMail($fromemail, $fromname, $toemail, $toname, $subject, $message);
                }

                //делаем отметку в истории заказа
                $this->qb->insert('??order_change', ['order_id' => $currentOrder['id'], 'new_status' => $newStatus, 'date' => time(), 'comment' => $_POST['add_comment'], 'customer_notified' => $notifyCustomer]);
                
                //сохраняем заказ
                $update['status'] = $newStatus;
                $update['items'] = htmlspecialchars_decode($_POST['items']);
                $update['fio'] = $_POST['fio'];
                $update['email'] = $_POST['email'];
                $update['phone'] = $_POST['phone'];
                $update['address'] = $_POST['address'];

                $updateResult = $this->qb->where('id', '?')->update('??order', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
                
            }
            else{
                $insert = [];
                
                $insert['status'] = (int)$_POST['status'];
                $insert['items'] = json_encode($_POST['items']);
                $insert['fio'] = $_POST['fio'];
                $insert['phone'] = $_POST['phone'];
                $insert['dover'] = $_POST['dover'];
                $insert['dover_date'] = $_POST['dover_date'];
                $insert['comment'] = $_POST['comment'];

                $insertResult = $this->qb->insert('??order', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $this->successText = $this->getTranslation('success add ' . $this->control);
                    return true;
                }
            }
        }
    }
    
    public function delete(){

        $id = (int)$_GET['param1'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }

        $currentOrder = $this->qb->where('id', '?')->get('??order', [$id])->fetch();
        $orderStock = (int)$currentOrder['stock_id'];
        $orderTotal = 0;
        $orderItems = json_decode($currentOrder['items'], true);
        if($orderItems){
            foreach($orderItems as $key => $value){
                $orderTotal += $value['quantity'] * $value['price'];
            }
        }
        //если заказ ранее не был отменен
        if($currentOrder['last_stock_change'] == 'decrease' && $currentOrder['last_balance_change'] == 'decrease'){
            
            //если заказ не анонимный возвращаем деньги в баланс пользователя
            if($currentOrder['user_id'] != 0){
                $userBalance = (int)$this->qb->where('id', '?')->get('??user', [$currentOrder['user_id']])->fetch()['balance'];
                $userBalance += $orderTotal;
                $this->qb->where('id', '?')->update('??user', ['balance' => $userBalance], [$currentOrder['user_id']]);
            }
            //возвращаем товары в сток
            if($orderItems){
                $returnProductSth = $this->qb->prepare('UPDATE ??product SET stock_' . $orderStock . ' = stock_' . $orderStock . ' + ? WHERE id = ?');
                foreach($orderItems as $key => $value){
                    $returnProductSth->execute([$value['quantity'], $value['product_id']]);
                }
            }
        }
        //делаем отметку в истории заказа
        $this->qb->insert('??order_change', ['order_id' => $currentOrder['id'], 'new_status' => 0, 'date' => time(), 'comment' => $this->getTranslation('order deleted')]);

        $resultDelete = $this->qb->where('id', '?')->delete('??order', [$id]);
        
        if(!$resultDelete){
            $this->errorText = $this->getTranslation('error delete ' . $this->control);
            $this->errors['error db'];
            return false;
        }
        else{
            $this->successText = $this->getTranslation('success delete ' . $this->control);
            return true;
        }
    }

    
}

