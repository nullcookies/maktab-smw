<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class SubscribeModel extends Model {

    public function index() {	
        
        $data = [];
        $data['success'] = false;
        $data['error'] = '';

        if(isset($_POST['e_mail'])){
            $email = $_POST['e_mail'];
            $valid = $this->validator->isEmail($email);
            if($valid){

                $insertSubscriber = [];
                $insertSubscriber['email'] = $email;
                $insertSubscriber['token'] = md5(mt_rand());
                $insertSubscriber['subscribe'] = 1;
                $insertSubscriber['type'] = 1;
                $insertSubscriber['date_modify'] = time();

                $check = $this->qb->where('email', '?')->get('??subscribe', [$email]);

                if($check->rowCount() > 0){
                    $result = $this->qb->where('email', '?')->update('??subscribe', $insertSubscriber, [$email]);
                }
                else{
                    $insertSubscriber['date_add'] = time();
                    $result = $this->qb->insert('??subscribe', $insertSubscriber);
                }

                if($result->rowCount() == 0){
                    $data['success'] = false;
                    $data['error'] = $this->translation('unknown error');
                }
                else{
                    $data['success'] = true;
                    $data['message'] = $this->translation('you have been subscribed');
                }
            }
            else{
                $data['success'] = false;
                $data['error'] = $this->translation($this->validator->lastError);
            }
        }
        

        $this->data = $data;
        return $this;
    }

}


