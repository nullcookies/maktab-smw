<?php

namespace models\front;

use \system\Document;
use \system\Model;
use \models\front\MailerModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class CartModel extends Model {

    public function index(){
        $data = [];
        $this->document = new Document();
        
        $breadcrumbs = [];
        $breadcrumbPages = ['home', 'cart'];
        $statement = $this->qb->where([['side', 'front'], ['controller', '?']])->getStatement('??page');
        $sth = $this->qb->prepare($statement);
        if($sth){
            foreach ($breadcrumbPages as $value) {
                $sth->execute([$value]);
                if($sth->rowCount() > 0){
                    $breadcrumb = $sth->fetchAll();
                    $breadcrumb = $this->langDecode($breadcrumb, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                    $breadcrumb = $breadcrumb[0];
                    $breadcrumbs[] = [
                        'name' => $breadcrumb['nav_name'][LANG_ID],
                        'url' => $this->linker->getUrl($breadcrumb['alias'])
                    ];
                }
            }
        }
        $name = '';
        $textName = '';
        $textContent = '';
        if(isset($breadcrumb)){
            $this->document->title = ($breadcrumb['meta_t'][LANG_ID]) ? $breadcrumb['meta_t'][LANG_ID] : $breadcrumb['name'][LANG_ID];
            $name = $breadcrumb['name'][LANG_ID];
        }
        $data['name'] = $name;

        $cartInfo = $this->cartInfo();

        
        $data['cartItems'] = $cartInfo['cartItems'];
        $data['subtotal'] = $cartInfo['subtotal'];
        $data['total'] = $cartInfo['total'];
        $data['coupon'] = $cartInfo['coupon'];
        $data['checkoutAvailable'] = $cartInfo['checkoutAvailable'];

        $data['checkout'] = $this->linker->getUrl('cart/checkout');

        $user_id = $_SESSION['user_id'];
        $user = [];
        $getUser = $this->qb->select('id, email, phone, firstname, lastname, middlename, balance')->where('id', '?')->get('??user', [$user_id])->fetch();
        if($getUser){
            $user = $getUser;
        }
        $data['user'] = $user;

        $errorNotEnough = false;
        if($user['balance'] < $data['total']){
            //$data['checkoutAvailable'] = false;
            $errorNotEnough = true;
        }
        $data['errorNotEnough'] = $errorNotEnough;


        $data['breadcrumbs'] = $breadcrumbs;

        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['changeCartUrl'] = $this->linker->getUrl('cart/change');
        $data['deleteCartUrl'] = $this->linker->getUrl('cart/delete');
        $data['applyCouponUrl'] = $this->linker->getUrl('cart/applyCoupon');

        
        $this->data = $data;

        return $this;
    }

    public function request(){
        $data = [];
        $data['success'] = false;

        $currentStock = 'request_product';
        $cart = $_SESSION['cart'][$currentStock] = [];
        $id = (int)$_POST['id'];
        $quantity = (int)$_POST['quantity'];
        $configuration = '';
        if(isset($_POST['option'])){
            $configuration = json_encode($_POST['option']);
        }

        $cartItemId = $this->getCartItemId($id, $configuration);

        if($id && $quantity){
            if($cart[$cartItemId]){
                $cart[$cartItemId]['quantity'] = $cart[$cartItemId]['quantity'] + $quantity;
            }
            else{
                $cart[$cartItemId] = ['id' => $id, 'quantity' => $quantity, 'configuration' => $configuration];
            }
        }
        $_SESSION['cart'][$currentStock] = $cart;
        
        $cartInfo = $this->cartInfo($currentStock);

        $data['cartInfo'] = $cartInfo;

        $data['cartItems'] = $cartInfo['cartItems'];
        $data['total'] = $cartInfo['total'];

        $data['checkout'] = $this->linker->getUrl('cart/checkout');

        $productModel = new ProductModel;
        $data['post'] = $_POST;
        //check form
        $errors = [];
        if(isset($_POST['confirm_checkout'])){
            $checkData = [];
            $rules = [ 
                'post' => [
                    'fio' => ['isRequired'],
                    'phone' => ['isRequired'],
                    'email' => ['isRequired', 'isEmail']
                ]
            ];
            $_POST = $this->cleanForm($_POST);
            $checkData['post'] = $_POST;

            $valid = $this->validator->validate($rules, $checkData);
            if(!$valid){
                $errors = $this->validator->lastErrors;
                foreach($errors as $key => $value){
                    $errors[$key] = $this->translation($value);
                }
                $data['resultText'] = $this->translation('please fill in required fields');
            }
            else{

                $insert = [];
                
                $orderItems = [];
                $orderTotal = 0;
                foreach($cartInfo['cartItems'] as $value){
                    $getPrice = $productModel->getPrice($value);

                    $orderItems[] = [
                        'product_id' => $value['id'],
                        'quantity' => $value['quantity'],
                        'price' => $getPrice['price_show'],
                        'price_old' => $getPrice['price_old'],
                        'configuration' => $value['configuration_show'],
                    ];
                    $orderTotal += $value['quantity'] * $getPrice['price_show'];
                }

                $insert['user_id']  = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                $insert['status']   = '1';
                $insert['new']      = '1';
                $insert['items']    = json_encode($orderItems);
                $insert['stock_id'] = $_SESSION['stock'];
                $insert['date']     = time();
                //$insert['fio']    = $_POST['lastname'] . ' ' . $_POST['firstname'] . ' ' . $_POST['middlename'];
                $insert['fio']      = $_POST['fio'];
                $insert['email']    = $_POST['email'];
                $insert['phone']    = $_POST['phone'];
                $insert['address']  = '';
                //$insert['address']  = $_POST['address'];
                //$insert['dover']    = $_POST['dover'];
                //$insert['dover_date'] = $_POST['dover_date'];
                $insert['comment']  = '';
                //$insert['comment']  = $_POST['comment'];
                $insert['last_stock_change'] = 'decrease';
                $insert['last_balance_change'] = 'decrease';
                
                $resultInsert = $this->qb->insert('??order', $insert);
                if($resultInsert->rowCount() > 0){
                    $data['success'] = true;
                    $data['resultText'] = $this->translation('your request has been sent');

                    $orderId = $this->qb->lastInsertId();
                    

                    $mailer = new MailerModel;

                    //admin mail
                    $fromemail = $this->getOption('robot_mail'); 
                    $fromname = $this->getOption('store_name');
                    $toemail = $this->getOption('contact_mail'); 
                    $toname = $this->getOption('contact_name');
                    $subject = $this->translation('new request product order') . ' - ' . $this->config['sitename'];
                    $message = '<h1>' . $subject . '</h1>';
                    $message .= '<p>' . $this->translation('order details') . '</p>';
                    $orderLink = $this->linker->getUrl($this->config['adminAccess'] . '/order/edit/') . $orderId . '/';
                    $message .= '<p><a target="_blank" href="' . $orderLink . '">' . $this->translation('view in admin panel') . '</a></p>';
                    $sendResult = $mailer->sendMail($fromemail, $fromname, $toemail, $toname, $subject, $message);
                    $mailer->sendMail($fromemail, $fromname, 'server@fortpro.uz', $fromname . 'Server Configurator', $subject, $message);
                    $data['sendResult'] = $sendResult;


                    //customer mail
                    $fromemail = $this->getOption('contact_mail'); 
                    $fromname = $this->getOption('store_name');
                    $toemail = $_POST['email']; 
                    $toname = $_POST['fio'];
                    $customerOrderLink = $this->linker->getUrl('user/orders/') . $orderId . '-' . $insert['date'] . '/';
                    $subject = $this->translation('your request has been accepted');
                    $message = '<h1>' . $subject . '</h1>';
                    $message .= '<p>' . $this->translation('thank you for your order. we ll contact you soon') . '</p>';
                    $message .= '<p>' . $this->translation('your order ID') . ': ' . $orderId . '</p>';
                    $message .= '<p><a target="_blank" href="' . $customerOrderLink . '">' . $this->translation('order details') . '</a></p>';
                    $mailer->sendMail($fromemail, $fromname, $toemail, $toname, $subject, $message);
                } 
                else{
                    $errors['db_error'] = 1;
                }
            }
        }
        $data['errors'] = $errors;
        $_SESSION['cart'][$currentStock] = [];
        $_SESSION['coupon'] = '';

        
        $this->data = $data;

        return $this;
    }

    public function checkout(){
        
        $data = [];
        $this->document = new Document();

        $breadcrumbs = [];
        $breadcrumbPages = ['home', 'cart'];
        $statement = $this->qb->where([['side', 'front'], ['controller', '?']])->getStatement('??page');
        $sth = $this->qb->prepare($statement);
        if($sth){
            foreach ($breadcrumbPages as $value) {
                $sth->execute([$value]);
                if($sth->rowCount() > 0){
                    $breadcrumb = $sth->fetchAll();
                    $breadcrumb = $this->langDecode($breadcrumb, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                    $breadcrumb = $breadcrumb[0];
                    $breadcrumbs[] = [
                        'name' => $breadcrumb['nav_name'][LANG_ID],
                        'url' => $this->linker->getUrl($breadcrumb['alias'])
                    ];
                }
            }
        }

        $name = $this->translation('checkout');
        $breadcrumbs[] = [
            'name' => $name,
            //'url' => $this->linker->getUrl('cart/checkout')
            'url' => 'active'
        ];
        $this->document->title = $name;
        $data['name'] = $name;

        $cartInfo = $this->cartInfo();

        $data['cartItems'] = $cartInfo['cartItems'];
        $data['subtotal'] = $cartInfo['subtotal'];
        $data['total'] = $cartInfo['total'];
        $data['coupon'] = $cartInfo['coupon'];
        $data['checkoutAvailable'] = $cartInfo['checkoutAvailable'];

        $data['checkout'] = $this->linker->getUrl('cart/checkout');


        $user_id = $_SESSION['user_id'];
        $user = [];
        $getUser = $this->qb->select('id, email, phone, firstname, lastname, middlename, balance')->where('id', '?')->get('??user', [$user_id])->fetch();
        if($getUser){
            $user = $getUser;
            $user['fio'] = $user['lastname'] . ' ' . $user['firstname'] . ' ' . $user['middlename'];
        }
        $data['user'] = $user;

        $productModel = new ProductModel;

        $postData = [];
        if(isset($_POST['confirm_checkout'])){
            $postData = $_POST;
        }
        else{
            $postData = $user;
        }
        $data['postData'] = $postData;

        $errorNotEnough = false;
        if($user['balance'] < $data['total']){
            //$data['checkoutAvailable'] = false;
            $errorNotEnough = true;
        }
        $data['errorNotEnough'] = $errorNotEnough;


        //check form
            
        $errors = [];
        if(isset($_POST['confirm_checkout'])){
            $checkData = [];
            $rules = [ 
                'post' => [
                    'fio' => ['isRequired'],
                    'phone' => ['isRequired'],
                    'email' => ['isRequired'],
                    'address' => ['isRequired'],
                    //'lastname' => ['isRequired'],
                    //'firstname' => ['isRequired'],
                    //'middlename' => ['isRequired'],
                    //'dover' => ['isRequired'],
                    //'dover_date' => ['isRequired']
                ]
            ];
            $_POST = $this->cleanForm($_POST);
            $checkData['post'] = $_POST;

            $valid = $this->validator->validate($rules, $checkData);
            if(!$valid){
                $errors = $this->validator->lastErrors;
            }
            else{
                if($data['checkoutAvailable']){
                    $insert = [];
                    
                    $orderItems = [];
                    $orderTotal = 0;
                    foreach($cartInfo['cartItems'] as $value){
                        $getPrice = $productModel->getPrice($value);

                        $orderItems[] = [
                            'product_id' => $value['id'],
                            'quantity' => $value['quantity'],
                            'price' => $getPrice['price_show'],
                            'price_old' => $getPrice['price_old'],
                            'configuration' => $value['configuration_show'],
                        ];
                        $orderTotal += $value['quantity'] * $getPrice['price_show'];
                    }

                    //coupon
                    if(isset($data['coupon']['coupon_discount'])){
                        $orderTotal -= (float)$data['coupon']['coupon_discount'];
                    }

                    $insert['user_id']  = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                    $insert['status']   = '1';
                    $insert['new']      = '1';
                    $insert['items']    = json_encode($orderItems);
                    $insert['stock_id'] = $_SESSION['stock'];
                    $insert['date']     = time();
                    //$insert['fio']    = $_POST['lastname'] . ' ' . $_POST['firstname'] . ' ' . $_POST['middlename'];
                    $insert['fio']      = $_POST['fio'];
                    $insert['email']    = $_POST['email'];
                    $insert['phone']    = $_POST['phone'];
                    $insert['address']  = $_POST['address'];
                    //$insert['dover']    = $_POST['dover'];
                    //$insert['dover_date'] = $_POST['dover_date'];
                    $insert['comment']  = $_POST['comment'];
                    $insert['last_stock_change'] = 'decrease';
                    $insert['last_balance_change'] = 'decrease';
                    $insert['coupon'] =json_encode($data['coupon']);

                    $resultInsert = $this->qb->insert('??order', $insert);
                    if($resultInsert->rowCount() > 0){
                        $orderId = $this->qb->lastInsertId();
                        $orderDate = $insert['date'];
                        //change balance and stock
                        $newBalance = $user['balance'] - $orderTotal;
                        $this->qb->where('id', '?')->update('??user', ['balance' => $newBalance], [$_SESSION['user_id']]);
                        $stockCheckSth = $this->qb->prepare('SELECT stock_' . $_SESSION['stock'] . ' FROM ??product WHERE id = ?');
                        foreach($cartInfo['cartItems'] as $key => $value){
                            $stockCheckSth->execute([$value['id']]);
                            if($stockCheckSth->rowCount() > 0){
                                $currentStock = $stockCheckSth->fetch()[0];
                                $newStock = $currentStock - $value['quantity'];
                                $this->qb->where('id', '?')->update('??product', ['stock_' . $_SESSION['stock'] => $newStock], [$value['id']]);
                            }
                        }

                        $mailer = new MailerModel;

                        //admin mail
                        $fromemail = $this->getOption('robot_mail'); 
                        $fromname = $this->getOption('store_name');
                        $toemail = $this->getOption('contact_mail'); 
                        $toname = $this->getOption('contact_name');
                        $subject = $this->translation('new product order') . ' - ' . $this->config['sitename'];
                        $message = '<h1>' . $subject . '</h1>';
                        $message .= '<p>' . $this->translation('order details') . '</p>';
                        $orderLink = $this->linker->getUrl($this->config['adminAccess'] . '/order/edit/') . $orderId . '/';
                        $message .= '<p><a target="_blank" href="' . $orderLink . '">' . $this->translation('view in admin panel') . '</a></p>';
                        $mailer->sendMail($fromemail, $fromname, $toemail, $toname, $subject, $message);

                        //customer mail
                        $fromemail = $this->getOption('contact_mail'); 
                        $fromname = $this->getOption('store_name');
                        $toemail = $_POST['email']; 
                        $toname = $_POST['fio'];
                        $customerOrderLink = $this->linker->getUrl('user/orders/') . $orderId . '-' . $insert['date'] . '/';
                        $subject = $this->translation('your order has been accepted');
                        $message = '<h1>' . $subject . '</h1>';
                        $message .= '<p>' . $this->translation('thank you for your order. we ll contact you soon') . '</p>';
                        $message .= '<p>' . $this->translation('your order ID') . ': ' . $orderId . '</p>';
                        $message .= '<p><a target="_blank" href="' . $customerOrderLink . '">' . $this->translation('order details') . '</a></p>';
                        $mailer->sendMail($fromemail, $fromname, $toemail, $toname, $subject, $message);

                        //clean cart and set toast to show
                        $_SESSION['coupon'] = '';
                        $_SESSION['cart'][$_SESSION['stock']] = [];
                        $_SESSION['checkoutSuccess'] = true;
                        $_SESSION['toast'][] = $this->translation('checkout success') . '<br>' . $this->translation('your order ID') . ': #' . $orderId;
                        header('Location: ' . $this->linker->getUrl('user/orders/' . $orderId . '-' . $orderDate));
                        exit;
                    }
                } 
            }
        }
        $data['errors'] = $errors;

        $data['cartUrl'] = $this->linker->getUrl('cart');
        $data['applyCouponUrl'] = $this->linker->getUrl('cart/applyCoupon');

        $data['breadcrumbs'] = $breadcrumbs;

        
        $this->data = $data;

        return $this;
    }

    public function add() {
        
        $data = [];

        $currentStock = $_SESSION['stock'];
        $cart = $_SESSION['cart'][$currentStock];
        $id = (int)$_POST['id'];
        $quantity = (int)$_POST['quantity'];
        $configuration = '';
        if(isset($_POST['option'])){
            $configuration = json_encode($_POST['option']);
        }

        $cartItemId = $this->getCartItemId($id, $configuration);

        if($id && $quantity){
            if($cart[$cartItemId]){
                $cart[$cartItemId]['quantity'] = $cart[$cartItemId]['quantity'] + $quantity;
            }
            else{
                $cart[$cartItemId] = ['id' => $id, 'quantity' => $quantity, 'configuration' => $configuration];
            }
        }
        $_SESSION['cart'][$currentStock] = $cart;
        
        $cartInfo = $this->cartInfo();

        $data['cartInfo'] = $cartInfo;
        $this->data = $data;
    }

    public function change() {
        
        $data = [];

        $currentStock = $_SESSION['stock'];
        $cart = $_SESSION['cart'][$currentStock];
        $id = (int)$_POST['id'];
        $cartItemId = $_POST['cartItemId'];
        $quantity = (int)$_POST['quantity'];

        if($id){
            if($cart[$cartItemId]){
                if($quantity > 0){
                    $cart[$cartItemId]['quantity'] = $quantity;
                }
                else{
                    unset($cart[$cartItemId]);
                }
                
            }
        }
        $_SESSION['cart'][$currentStock] = $cart;
        
        $cartInfo = $this->cartInfo();

        $data['cartInfo'] = $cartInfo;
        $this->data = $data;
    }

    public function delete() {
        
        $data = [];

        $currentStock = $_SESSION['stock'];
        $cart = $_SESSION['cart'][$currentStock];
        $id = (int)$_POST['id'];
        $cartItemId = $_POST['cartItemId'];

        if($id){
            if($cart[$cartItemId]){
                unset($cart[$cartItemId]);
            }
        }
        $_SESSION['cart'][$currentStock] = $cart;
        
        $cartInfo = $this->cartInfo();

        $data['cartInfo'] = $cartInfo;
        $this->data = $data;
    }

    public function applyCoupon() {
        
        $data = [];
        $success = false;
        $errors = [];

        $productModel = new ProductModel;

        $currentStock = $_SESSION['stock'];
        $cartInfo = $this->cartInfo();

        $_POST = $this->cleanForm($_POST);

        $couponCode = $_POST['coupon_code'];

        $coupon = [];
        $getCoupon = $this->qb->where('coupon_code', '?')->order('id', true)->get('??coupon', [$couponCode]);
        if($getCoupon->rowCount() > 0){
            $currentTime = time();
            $coupon = $getCoupon->fetch();
            $coupon = $this->langDecode($coupon, ['name', 'descr'], false);
            if($coupon['status'] != 1){
                $errors[] = $this->t('coupon is inactive');
            }
            if($coupon['date_start'] > $currentTime){
                $errors[] = $this->t('coupon not available yet');
            }
            if($coupon['date_end'] < $currentTime){
                $errors[] = $this->t('coupon available time expired');
            }
            $exchangeRate = $productModel->getExchangeRate();
            $couponMinPrice = $exchangeRate * $coupon['min_price'];
            if($couponMinPrice > $cartInfo['total']){
                $errors[] = $this->t('order min price for coupon') . ': ' . $this->formatPrice($couponMinPrice);
            }
        }
        else{
            $errors[] = $this->t('coupon not found');
        }
        
        if(count($errors) == 0){
            $success = true;
            $_SESSION['coupon'] = $coupon['coupon_code'];
            $data['coupon_code'] = $coupon['coupon_code'];
        }
        
        //update cart info
        $cartInfo = $this->cartInfo();
        
        $data['cartInfo'] = $cartInfo;

        $data['success'] = $success;
        $data['errors'] = $errors;

        $this->data = $data;
    }

    public function cartInfo($currentStock = false){

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');

        $productModel = new ProductModel();

        $cartInfo = [];
        
        if(!$currentStock) $currentStock = (int)$_SESSION['stock'];
        $cart = (isset($_SESSION['cart'][$currentStock])) ? $_SESSION['cart'][$currentStock] : [];
        
        $cartItems = [];
        $total = 0;
        $totalItems = 0;
        $ids = [];
        $checkoutAvailable = false;
        if(count($cart) > 0){
            
            $checkoutAvailable = true;
            foreach($cart as $key => $value){

                $product = $this->qb->where('id', '?')->get('??product', [$value['id']])->fetch();
                $product = $this->langDecode($product, ['name'], false);

                $product['url'] = $this->linker->getUrl($product['alias']);
                $mainIcon = $this->getMainIcon($product['images']);
                $product['icon'] = $this->linker->getIcon($this->media->resize($mainIcon, $smallIconW, $smallIconH));
                $product['cartItemId'] = $key;
                $product['quantity'] = $value['quantity'];

                //выбранные опции
                $product['configuration_show'] = [];
                $configuration = json_decode($value['configuration'], true);
                $product['options'] = json_decode($product['options'], true);
                if(is_array($configuration)){
                    foreach($configuration as $key1 => $value1){
                        $optionPrice = (float)$product['options'][$key1]['values'][$value1]['price'];
                        $product['configuration_show'][$key1]['name'] = $product['options'][$key1]['name'][LANG_ID];
                        $product['configuration_show'][$key1]['value'] = $product['options'][$key1]['values'][$value1]['name'][LANG_ID];
                        $product['configuration_show'][$key1]['price'] = $optionPrice * $productModel->getExchangeRate();
                        if($optionPrice > 0){
                           $product['price'] += $optionPrice;
                        }
                    }
                }

                //цена
                $getPrice = $productModel->getPrice($product);
                $product['price_show'] = $getPrice['price_show'];
                $product['price_old'] = $getPrice['price_old'];

                $product['line_total'] = $value['quantity'] * $product['price_show'];
                
                $product['checkoutAvailable'] = true;
                $stockManagement = $this->getOption('stock_management');
                if($stockManagement == 1){
                    $product['checkoutAvailable'] = ($value['quantity'] <= $product['stock_' . $_SESSION['stock']]) ? true: false;
                }
                
                if(!$product['checkoutAvailable']){
                    $checkoutAvailable = false;
                }
                $totalItems += $product['quantity'];
                $total += $product['line_total'];
                $cartItems[$key] = $product;
            }
        }
        $cartInfo['cartItems'] = $cartItems;
        $cartInfo['subtotal'] = $total;
        $cartInfo['total'] = $total;
        $cartInfo['totalItems'] = $totalItems;
        $cartInfo['checkoutAvailable'] = $checkoutAvailable;

        $cartInfo['coupon'] = [];

        //apply filters (coupon, shipping, tax and etc.)
        //coupon
        if(isset($_SESSION['coupon']) && $_SESSION['coupon'] != ''){
            $coupon = [];
            $getCoupon = $this->qb->where('coupon_code', '?')->order('id', true)->get('??coupon', [$_SESSION['coupon']]);
            if($getCoupon->rowCount() > 0){
                $coupon = $getCoupon->fetch();
                $coupon = $this->langDecode($coupon, ['name', 'descr'], false);
                $currentTime = time();
                $couponErrors = [];
                if($coupon['status'] != 1){
                    $couponErrors[] = $this->t('coupon is inactive');
                }
                if($coupon['date_start'] > $currentTime){
                    $couponErrors[] = $this->t('coupon not available yet');
                }
                if($coupon['date_end'] < $currentTime){
                    $couponErrors[] = $this->t('coupon available time expired');
                }
                $exchangeRate = $productModel->getExchangeRate();
                $couponMinPrice = $exchangeRate * $coupon['min_price'];
                if($couponMinPrice > $cartInfo['total']){
                    $couponErrors[] = $this->t('order min price for coupon') . ': ' . $this->formatPrice($couponMinPrice);
                }
                if(count($couponErrors) == 0){
                    if($coupon['coupon_type'] == 'percent'){
                        $couponValue = (float)$coupon['coupon_value'];
                        if($couponValue > 100){
                            $couponValue = 100;
                        }
                        if($couponValue < 0){
                            $couponValue = 0;
                        }
                        $couponDiscount = $cartInfo['total'] * $couponValue / 100;
                        $cartInfo['total'] = $cartInfo['total'] - $couponDiscount;
                        $cartInfo['coupon']['coupon_code'] = $coupon['coupon_code'];
                        $cartInfo['coupon']['coupon_value'] = '-' . $couponValue . '%';
                        $cartInfo['coupon']['coupon_name'] = $coupon['name'][LANG_ID];
                        $cartInfo['coupon']['coupon_discount'] = $couponDiscount;
                    }
                    if($coupon['coupon_type'] == 'amount'){
                        $couponValue = (float)$coupon['coupon_value'];
                        $couponDiscount = $couponValue * $exchangeRate;
                        if($couponDiscount > $cartInfo['total']){
                            $couponDiscount = $cartInfo['total'];
                        }
                        $cartInfo['total'] = $cartInfo['total'] - $couponDiscount;
                        $cartInfo['coupon']['coupon_code'] = $coupon['coupon_code'];
                        $cartInfo['coupon']['coupon_value'] = '-' . $this->formatPrice($couponDiscount);
                        $cartInfo['coupon']['coupon_name'] = $coupon['name'][LANG_ID];
                        $cartInfo['coupon']['coupon_discount'] = $couponDiscount;
                    }
                }
                    
            }
        }

        return $cartInfo;
    }
    
    public function checkStock($id, $quantity) {
        return false;
    }

    private function getCartItemId($id, $configuration) {
        return $id . '-' . ((int)preg_replace('#[^\d]#', '', $configuration));
    }
    
    
}



