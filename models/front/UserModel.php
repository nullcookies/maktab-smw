<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends Model {
    
    public $defaultUsergroup = 10;

    public function index(){
        $data = [];
        $this->document = new Document();

        $this->data = $data;

        return $this;
    }

    public function account(){
        $data = [];
        $this->document = new Document();

        $userMenu = [
            [
                'url' => $this->linker->getUrl('user/account'),
                'name' => $this->translation('account'),
                'active' => true
            ],
            [
                'url' => $this->linker->getUrl('user/orders'),
                'name' => $this->translation('orders'),
                'active' => false
            ],
            [
                'url' => $this->linker->getUrl('user/logout'),
                'name' => $this->translation('logout'),
                'active' => false
            ]
        ];
        $data['userMenu'] = $userMenu;
        
        $breadcrumbs = [];
        $name = '';

        $id = (int)$_GET['param1'];

        $breadcrumbPages = ['home'];
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

        $this->document->title = $this->translation('my account');
        $breadcrumbs[] = [
            'name' => $this->translation('my account'),
            'url' => 'active'
        ];

        $user = [];
        $getUser = $this->qb->where('id', '?')->get('??user', [$_SESSION['user_id']])->fetch();
        if($getUser){
            $user = $getUser;
            $user['icon'] = $this->linker->getIcon($this->media->resize($user['image'], 150, 150, true));
        }

        $data['user'] = $user;

        $data['breadcrumbs'] = $breadcrumbs;

        
        $this->data = $data;

        return $this;
    }

    public function orders(){
        $data = [];
        $this->document = new Document();

        $userMenu = [
            [
                'url' => $this->linker->getUrl('user/account'),
                'name' => $this->translation('account'),
                'active' => false
            ],
            [
                'url' => $this->linker->getUrl('user/orders'),
                'name' => $this->translation('orders'),
                'active' => true
            ],
            [
                'url' => $this->linker->getUrl('user/logout'),
                'name' => $this->translation('logout'),
                'active' => false
            ]
        ];
        $data['userMenu'] = $userMenu;

        $data['statusIconsPath'] = $this->linker->getIcon('order-status');
        
        $breadcrumbs = [];
        $name = '';

        $breadcrumbPages = ['home'];
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

        $this->document->title = $this->translation('orders');
        $breadcrumbs[] = [
            'name' => $this->translation('my account'),
            'url' => $this->linker->getUrl('user/account')
        ];
        $breadcrumbs[] = [
            'name' => $this->translation('orders'),
            'url' => 'active'
        ];

        $orders = [];
        $getOrders = $this->qb->where('user_id', '?')->order('date', true)->limit(50)->get('??order', [$_SESSION['user_id']]);
        if($getOrders->rowCount() > 0){
            $orders = $getOrders->fetchAll();
            foreach($orders as $key => $value){
                $orders[$key]['url'] = $this->linker->getUrl('user/orders/' . $value['id'] . '-' . $value['date']);
                $orders[$key]['items'] = $this->getOrder($value);
            }
        }
        $data['orders'] = $orders;

        $data['breadcrumbs'] = $breadcrumbs;

        
        $this->data = $data;

        return $this;
    }

    public function orderView(){
        $data = [];
        $this->document = new Document();

        $userMenu = [
            [
                'url' => $this->linker->getUrl('user/account'),
                'name' => $this->translation('account'),
                'active' => false
            ],
            [
                'url' => $this->linker->getUrl('user/orders'),
                'name' => $this->translation('orders'),
                'active' => false
            ],
            [
                'url' => $this->linker->getUrl('user/logout'),
                'name' => $this->translation('logout'),
                'active' => false
            ]
        ];
        $data['userMenu'] = $userMenu;

        $data['statusIconsPath'] = $this->linker->getIcon('order-status');
        
        $breadcrumbs = [];
        $name = '';

        $breadcrumbPages = ['home'];
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

        $this->document->title = $this->translation('order view');
        $breadcrumbs[] = [
            'name' => $this->translation('my account'),
            'url' => $this->linker->getUrl('user/account')
        ];
        $breadcrumbs[] = [
            'name' => $this->translation('orders'),
            'url' => $this->linker->getUrl('user/orders')
        ];
        $breadcrumbs[] = [
            'name' => $this->translation('order view'),
            'url' => 'active'
        ];

        $orderParam = (isset($_GET['param1'])) ? explode('-', $_GET['param1']) : array(0, 0);

        $id = (int)$orderParam[0];
        $order_date = (int)$orderParam[1];

        $data['orderId'] = $id;

        //$order = $this->qb->where([['user_id', '?'], ['id', '?']])->get('??order', [$_SESSION['user_id'], $id])->fetch();
        $order = $this->qb->where([['date', '?'], ['id', '?']])->get('??order', [$order_date, $id])->fetch();
        if($order){
            $order['items'] = $this->getOrder($order);
        }
        $data['order'] = $order;

        $orderHistory = $this->qb->where('order_id', '?')->order('date', true)->get('??order_change', [$id])->fetchAll();
        $data['orderHistory'] = $orderHistory;

        $user = $this->qb->select('address_phy, address_jur')->where('id', '?')->get('??user', [$_SESSION['user_id']])->fetch();
        $data['userAddr'] = $user['address_jur'];

        $data['breadcrumbs'] = $breadcrumbs;

        $data['returnURL'] = $_SERVER['REQUEST_URI'];
        if(isset($this->config['paycom_environment']) && $this->config['paycom_environment'] == 'test'){
            $data['paycomCheckoutUrl'] = 'https://checkout.test.paycom.uz/';
        }
        else{
            $data['paycomCheckoutUrl'] = 'https://checkout.paycom.uz/';
        }
        

        
        $this->data = $data;

        return $this;
    }

    public function restore(){
        
        $data = [];
        $this->document = new Document();
        
        $breadcrumbs = [];
        $name = '';

        $breadcrumbPages = ['home'];
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

        $this->document->title = $this->translation('restore password');
        $breadcrumbs[] = [
            'name' => $this->translation('restore password'),
            'url' => 'active'
        ];

        $data['uid'] = (int)$_GET['uid'];
        $data['forgetkey'] = $_GET['forgetkey'];

        if(isset($_POST['forgetkey'])){
            
            $data['ajax'] = true;

            $ajaxData = [];
            $ajaxData['success'] = false;
            $ajaxData['message'] = $this->t('error restoring password');

            foreach($_POST as $key => $value){
                $_POST[$key] = trim($value);
            }
            $errors = [];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];

            if(empty($password1)){
                $errors['password1'] = $this->translation('error password empty');
            }
            if(empty($password2)){
                $errors['password2'] = $this->translation('error password repeat empty');
            }
            if($password1 !== $password2) {
                $errors['password2'] = $this->translation('error passwords not equal');
            }

            //check forgetkey
            $uid = (int)$_POST['uid'];
            $forgetkey = $_POST['forgetkey'];
            if(empty($uid)){
                $errors['unknown'] = $this->translation('error unknown');
            }
            if(empty($forgetkey)){
                $errors['unknown'] = $this->translation('error unknown');
            }

            $currentUser = [];
            $checkUserExist = $this->qb->where('id', '?')->get('??user', [$uid]);
            if($checkUserExist->rowCount() == 0){
                $errors['unknown'] = $this->translation('error unknown');
            }
            else{
                $currentUser = $checkUserExist->fetch();
                if($currentUser['forgetkey'] != $forgetkey || $currentUser['forgetkey'] == 'activated'){
                    $errors['unknown'] = $this->translation('error unknown');
                }
            }

            //if no errors change password
            if(count($errors) == 0 && $currentUser){

                $password = $this->hashPassword($password1);
                $result = $this->qb->where('id', '?')->update('??user', ['password' => $password, 'forgetkey' => ''], [$uid]);
                if($result->rowCount() == 1){
                    $ajaxData['success'] = true;
                    $ajaxData['message'] = $this->t('Password has been successfully changed. You can login now');
                }
                else{
                    $errors['unknown'] = $this->translation('error unknown');
                }
            }

            $ajaxData['errors'] = $errors;

            $data['ajaxData'] = $ajaxData;
        }

        $data['breadcrumbs'] = $breadcrumbs;

        $data['restoreURL'] = $this->linker->getUrl('user/restore');
        
        $this->data = $data;

        return $this;
    }

    public function register(){
        $data = [];
        $this->document = new Document();
        $data['success'] = false;
        
        foreach($_POST as $key => $value){
            $_POST[$key] = trim($value);
        }
        $errors = [];
        $username = '';
        if(isset($_POST['username']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['password2'])){
            $username = strtolower($_POST['username']);
            $name = $_POST['name'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $accept_privacy = $_POST['accept_privacy'];

            if($password !== $password2) {
                $errors['password2'] = $this->translation('error passwords not equal');
            }
            if(empty($username)){
                $errors['username'] = $this->translation('error username empty');
            }
                
            if(!$this->validator->isEmail($username)) {
                $errors['username'] = $this->translation('error not email');
            }
            elseif(strlen($username) < $this->config['params']['min_username_length']) {
                $errors['username'] = $this->translation('error min username length') . ': ' . $this->config['params']['min_username_length'];
            }

            if(empty($name)) {
                $errors['name'] = $this->translation('error name empty');
            }

            if(empty($password)) {
                $errors['password'] = $this->translation('error password empty');
            }
            if(empty($password2)) {
                $errors['password2'] = $this->translation('error password repeat empty');
            }
            if(empty($accept_privacy)) {
                $errors['accept_privacy'] = $this->translation('error accept rules and privacy policy');
            }
            
            $checkUserExist = $this->qb->where('username', '?')->get('??user', [$username]);
            if($checkUserExist->rowCount() > 0){
                $errors['username'] = $this->translation('error username already exist');
            }

            //if no errors register user
            if(!$errors){
                

                $insert = [];
                $passwordRaw = $password;
                $password = $this->hashPassword($password);

                $activationkey = md5('activation' . $username . $password . time());

                $insert['username'] = $username;
                $insert['email'] = $username;
                $insert['firstname'] = $name;
                $insert['password'] = $password;
                $insert['usergroup'] = $this->defaultUsergroup;

                $insert['status'] = 0;
                $insert['activationkey'] = $activationkey;

                $result = $this->qb->insert('??user', $insert);
                $userId = $this->qb->lastInsertId();

                if($result->rowCount() == 1){
                    $data['success'] = true;
                    $data['message'] = $this->t('Your account has been successfully registered. Please check your email');
                    //немедленная авторизация
                    /*
                    $checkUser = $this->qb->where([['username', '?'], ['password', '?']])->get('??user', [$username, $password]);
                    if($checkUser->rowCount() > 0){
                        $user = $checkUser->fetch();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['usergroup'] = $user['usergroup'];
                        $update = [
                            'phpsessid' => $_COOKIE['PHPSESSID'],
                            'last_ip' => $_SERVER['REMOTE_ADDR'],
                            'last_login' => time(),
                            'activity_at' => time()
                        ];
                        $this->qb->where('id', '?')->update('??user', $update, [$user['id']]);
                        //header('Location: ' . BASEURL . '/');
                        //exit;
                    }
                    */
                    
                    //авктивация по email
                    $mailer = new MailerModel();

                    $subject = $this->translation('register');

                    $messageData = [];
                    $messageData['activationkey'] = $activationkey;
                    $messageData['activateUrl'] = $this->linker->getUrl('user/activate') . '?uid=' . $userId . '&activationkey=' . $activationkey;
                    $messageData['password'] = $passwordRaw;
                    $messageData['username'] = $username;
                    $messageData['sitename'] = $this->getOption('sitename');

                    $message = $this->render('email-confirm-register', $messageData);

                    $_SESSION['toast'][] = sprintf($this->translation('register success confirm email'), $insert['email']);

                    $mailer->sendMail($this->getOption('robot_mail'), $this->translation('no-reply'), $insert['email'], $insert['name'], $subject, $message);
                    //header('Location: ' . BASEURL . '/');
                    //exit;

                    //TODO: if $_POST['subscribe'] checked

                    //add to subscribe table
                    $insertSubscriber = [];
                    $insertSubscriber['email'] = $username;
                    $insertSubscriber['subscribe'] = 1;
                    $insertSubscriber['type'] = 1;
                    $insertSubscriber['name'] = $name;
                    $insertSubscriber['token'] = md5(mt_rand());
                    $insertSubscriber['phone'] = '';
                    
                    $insertSubscriber['date_modify'] = time();

                    $checkSubscriberExist = $this->qb->where('email', '?')->get('??subscribe', [$username]);
                    if($checkUserExist->rowCount() > 0){
                        $this->qb->where('email', '?')->update('??subscribe', $insertSubscriber, [$username]);
                    }
                    else{
                        $insertSubscriber['date_add'] = time();
                        $this->qb->insert('??subscribe', $insertSubscriber);
                    }
                    
                }
                
                    
            }
            
        }
        $data['username'] = $_POST['username'];
        $data['errors'] = $errors;

        $data['homeUrl'] = $this->linker->getUrl('');
        $data['action'] = $this->linker->getUrl('user/register');

        $this->data = $data;

        return $this;
    }

    public function login(){
        $data = [];
        $this->document = new Document();
        $data['success'] = false;
        foreach($_POST as $key => $value){
            $_POST[$key] = trim($value);
        }
        $errors = [];
        $username = '';
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = strtolower($_POST['username']);
            $password = $_POST['password'];
            if(empty($_POST['username'])) {
                $errors['username'] = $this->translation('error username empty');
            }

            if(!$this->validator->isEmail($_POST['username'])) {
                $errors['username'] = $this->translation('error email invalid');
            }
            if(empty($_POST['password'])) {
                $errors['password'] = $this->translation('error password empty');
            }

            $checkUserExist = $this->qb->where('username', '?')->get('??user', [$username]);
            if($checkUserExist->rowCount() == 0){
                $errors['username'] = $this->translation('error no such username');
            }
            else{
                //если аккаунт существует проверяем активирован ли
                $checkUserExist = $this->qb->where([['username', '?'], ['status', '?']])->get('??user', [$username, 1]);
                if($checkUserExist->rowCount() == 0){
                    $errors['username'] = $this->translation('error account hasnt been activated yet');
                }
            }
            

            if(!$errors){
                $password = $this->hashPassword($password);
                $checkUser = $this->qb->where([['username', '?'], ['password', '?']])->get('??user', [$username, $password]);
                
                if($checkUser->rowCount() > 0){
                    $user = $checkUser->fetch();
                    $data['success'] = $this->loginUser($user['id'], $user['usergroup']);
                }
                else{
                    $errors['password'] = $this->translation('error password');
                }
            }
        }
        $data['username'] = $_POST['username'];
        $data['errors'] = $errors;

        $data['homeUrl'] = $this->linker->getUrl('');
        $data['action'] = $this->linker->getUrl('user/login');

        $this->data = $data;

        return $this;
    }

    public function forgetPassword(){
        $data = [];
        
        $errors = [];
        $data['success'] = false;
        $username = strtolower(trim($_POST['username']));

        if(empty($username)){
            $errors['username'] = $this->translation('error email invalid');
        }
        elseif(!$this->validator->isEmail($username)){
            $errors['username'] = $this->translation('error email invalid');
        }

        $user = [];
        if(count($errors) == 0){
            $checkUserExist = $this->qb->where('username', '?')->get('??user', [$username]);
            if($checkUserExist->rowCount() == 0){
                $errors['username'] = $this->translation('error no such username');
            }
            else{
                $user = $checkUserExist->fetch();
            }
        }

        if(count($errors) == 0 && $user){
            $forgetKey = md5('forget' . $user['password'] . $user['username'] . time());
            $update = [
                'forgetkey' => $forgetKey,
            ];
            $this->qb->where('id', '?')->update('??user', $update, [$user['id']]);
            $restoreLink = $this->linker->getUrl('user/restore') . '?uid=' . $user['id'] . '&forgetkey=' . $forgetKey;
            
            $mailer = new MailerModel();

            $subject = $this->t('restore password') . ' - ' . $this->getOption('sitename');

            $messageData = [];
            $messageData['forgetkey'] = $forgetKey;
            $messageData['restoreUrl'] = $restoreLink;

            $messageData['sitename'] = $this->getOption('sitename');

            $message = $this->render('email-restore-password', $messageData);

            $_SESSION['toast'][] = sprintf($this->translation('password restore instructions has been sent to %s'), $username);

            $data['success'] = $mailer->sendMail($this->getOption('robot_mail'), $this->translation('no-reply'), $username, $user['name'], $subject, $message);
            if(!$data['success']){
                $errors['mail'] = $this->t('error cant send email');
            }
            else{
                $data['message'] = $this->t('password recovery instructions has been sent to email');
            }
        }
        $data['errors'] = $errors;

        $data['homeUrl'] = $this->linker->getUrl('');
        $data['action'] = $this->linker->getUrl('user/login');

        $this->data = $data;

        return $this;
    }

    public function loginUser($userid, $usergroup){
        
        $update = [
            'phpsessid' => $_COOKIE['PHPSESSID'],
            'last_ip' => $_SERVER['REMOTE_ADDR'],
            'last_login' => time(),
            'activity_at' => time()
        ];
        $result = $this->qb->where('id', '?')->update('??user', $update, [$userid]);
        if($result->rowCount() == 1){
            $_SESSION['user_id'] = $userid;
            $_SESSION['usergroup'] = $usergroup;
            return true;
        }
        return false;
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['usergroup']);
        session_destroy();
        header('Location: ' . BASEURL);
        exit;
    }

    public function getOrder($orderRow) {

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
        $coupon = json_decode($orderRow['coupon'], true);
        $order = [];
        $items = json_decode($orderRow['items'], true);
        $total = 0;
        $quantity = 0;
        if(count($items) > 0){
            $productModel = new ProductModel();
            foreach($items as $key => $value){
                $product = $this->qb->where('id', '?')->get('??product', [$value['product_id']])->fetch();
                $product = $this->langDecode($product, ['name'], false);
                
                //цена из заказа
                $product['price_show'] = $value['price'];

                $product['configuration_show'] = $value['configuration'];

                $product['url'] = $this->linker->getUrl($product['alias']);
                $mainIcon = $this->getMainIcon($product['images']);
                $product['icon'] = $this->linker->getIcon($this->media->resize($mainIcon, $smallIconW, $smallIconH, true));
                $product['quantity'] = $value['quantity'];
                $product['line_total'] = $value['quantity'] * $product['price_show'];

                $total += $product['line_total'];
                $quantity += $product['quantity'];
                $items[$key]['product'] = $product;
            }
        }
        $order['items'] = $items;
        $order['subtotal'] = $total;
        if(isset($coupon['coupon_discount'])){
            $total -= (float)$coupon['coupon_discount'];
        }
        $order['total'] = $total;
        $order['quantity'] = $quantity;
        $order['coupon'] = $coupon;
        return $order;
    }

    public function activate(){

        $this->document = new Document();
        
        $breadcrumbs = [];
        $breadcrumbPages = ['home'];
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

        $this->document->title = $this->translation('account activation');
        $breadcrumbs[] = [
            'name' => $this->translation('account activation'),
            'url' => 'active'
        ];



        $successActivate = false;

        $uid = (int)$_GET['uid'];
        $activationkey = substr($_GET['activationkey'], 0, 32);

        $errors = [];

        if(empty($uid)){
            $errors['unknown'] = $this->t('error unknown');
        }
        if(empty($activationkey)){
            $errors['unknown'] = $this->t('error unknown');
        }

        $currentUser = [];
        $checkUserExist = $this->qb->where('id', '?')->get('??user', [$uid]);
        if($checkUserExist->rowCount() == 0){
            $errors['unknown'] = $this->translation('error unknown');
        }
        else{
            $currentUser = $checkUserExist->fetch();
            if($currentUser['activationkey'] != $activationkey){
                $errors['unknown'] = $this->translation('error unknown');
            }
        }

        //if no errors activate account
        if(count($errors) == 0 && $currentUser){
            $result = $this->qb->where('id', '?')->update('??user', ['status' => '1', 'activationkey' => ''], [$uid]);
            if($result->rowCount() == 1){
                $this->loginUser($currentUser['id'], $currentUser['usergroup']);
                $successActivate = true;
            }
        }

        $data = $this->data;
        $data['successActivate'] = $successActivate;

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->data = $data;

        return $this;
    }

}



