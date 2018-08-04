<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class ContactModel extends Model {
    
    public function index(){

        $data = [];
        $this->document = new Document();

        $breadcrumbs = [];
        $breadcrumbPages = ['home', 'contact'];
        $statement = $this->qb->where([['side', 'front'], ['controller', '?']])->getStatement('??page');
        $sth = $this->qb->prepare($statement);
        if($sth){
            foreach ($breadcrumbPages as $value) {
                $sth->execute([$value]);
                if($sth->rowCount() > 0){
                    $breadcrumb = $sth->fetchAll();
                    $breadcrumb = $this->langDecode($breadcrumb, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                    $breadcrumb = $breadcrumb[0];
                    $breadcrumbUrl = ($value != 'contact') ? $this->linker->getUrl($breadcrumb['alias']) : 'active';
                    $breadcrumbs[] = [
                        'name' => $breadcrumb['nav_name'][LANG_ID],
                        'url' => $breadcrumbUrl
                    ];
                }
            }
        }
        $name = '';
        $textName = '';
        $textContent = '';
        if(isset($breadcrumb)){
            $this->document->title = ($breadcrumb['meta_t'][LANG_ID]) ? $breadcrumb['meta_t'][LANG_ID] : $breadcrumb['name'][LANG_ID];
            $this->document->description = $breadcrumb['meta_d'][LANG_ID];
            $this->document->keywords = $breadcrumb['meta_d'][LANG_ID];
            $name = $breadcrumb['name'][LANG_ID];
            $textName = $breadcrumb['text_name'][LANG_ID];
            $textContent = $breadcrumb['descr_full'][LANG_ID];

        }

        $data['name'] = $name;
        $data['textName'] = $textName;
        $data['textContent'] = $textContent;
        $data['breadcrumbs'] = $breadcrumbs;

        $products = [];
        $getProducts = $this->qb->select('p.id, p.name, b.name b_name, b.id b_id, c.name c_name, c.id c_id')->where('p.status', '1')->join('??brand b', 'p.brand_id = b.id')->join('??category c', 'p.category_id = c.id')->get('??product p');
        
        if($getProducts->rowCount() > 0){
            $products = $getProducts->fetchAll();
            $products = $this->buildProducts($products, true);
        }
        usort($products, array('\system\Model', 'cmp'));
        $data['products'] = $products;

        $data['phone1'] = $this->getOption('phone1');
        $data['phone2'] = $this->getOption('phone2');
        $data['mail'] = $this->getOption('contact_mail');
        $data['address'] = $this->getOption('address');

        $map = [];
        $map['lat'] = (float)$this->getOption('map_lat');
        $map['lng'] = (float)$this->getOption('map_lng');
        $map['api_key'] = $this->getOption('google_maps_api_key');
        $data['map'] = $map;

        $submitSuccess = false;
        $errors = [];
        $post = [];
        if($_POST){
            $rules = [ 
                'post' => [
                    'name' => ['isRequired'],
                    //'phone' => ['isRequired'],
                    'email' => ['isRequired', 'isEmail'],
                ]

            ];

            $_POST = $this->cleanForm($_POST);
            $post = $_POST;
            $checkData['post'] = $_POST;

            $valid = $this->validator->validate($rules, $checkData);

            if(!$valid){
                $errors = $this->validator->lastErrors;
            }
            else{
                $message = '';
                $mailer = new MailerModel();
                
                $toEmail = $this->getOption('contact_mail');
                $toName = $this->getOption('contact_name');
                
                $fromEmail = $this->getOption('robot_mail');
                $fromName = $this->getOption('robot_name');

                $subject = 'Сообщение от ' . $_POST['name'] . ' - ' . $_SERVER['SERVER_NAME'];

                $getProjectName = '';
                if($_POST['project_id']){
                    $getProject = $this->qb->select('name')->where('id', '?')->get('??product', [(int)$_POST['project_id']])->fetch();
                    if($getProject){
                        $getProject = $this->langDecode($getProject, ['name'], false);
                        $getProjectName = $getProject['name'][LANG_ID];
                    }
                }

                $message .= '<p><strong>Имя:</strong> ' . $_POST['name'] . '</p>' . PHP_EOL;
                $message .= '<p><strong>E-mail:</strong> ' . $_POST['email'] . '</p>' . PHP_EOL;
                $message .= '<p><strong>Телефон:</strong> ' . $_POST['phone'] . '</p>' . PHP_EOL;
                //if($getProjectName) $message .= '<p><strong>Проект:</strong> ' . $getProjectName . '</p>' . PHP_EOL;
                $message .= '<p><strong>Сообщение:</strong> ' . $_POST['message'] . '</p>' . PHP_EOL;

                $submitSuccess = $mailer->sendMail($fromEmail, $fromName, $toEmail, $toName, $subject, $message);
                if($submitSuccess){
                    $post = [];
                }

                $insert = [
                    'name' => (string)$_POST['name'], 
                    'email' => (string)$_POST['email'], 
                    'phone' => (string)$_POST['phone'], 
                    'message' => ($subject . PHP_EOL . '<br>' . $message),
                    'type' => 1,
                    'date' => time()
                ];
                $this->qb->insert('??contact', $insert);

                setcookie('form-filled', md5(time()), time() + 86400 * 7, '/');
            }

            if(isset($_POST['ajax'])){
                foreach($errors as $key => $value){
                    $errors[$key] = $this->translation($value);
                }
                $response = [
                    'success' => $submitSuccess,
                    'errors' => $errors
                ];
                echo json_encode($response);
                exit;
            }
        }
        $data['submitSuccess'] = $submitSuccess;
        $data['errors'] = $errors;
        $data['post'] = $post;

        $data['contactAction'] = $this->linker->getUrl('contact');

        $this->data = $data;

        return $this;
    }

    public function getAction(){
        
        $data = [];

        $data['contactAction'] = $this->linker->getUrl('contact');

        
        $this->data = $data;

        return $this;
    }

}



