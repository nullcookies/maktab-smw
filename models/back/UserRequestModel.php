<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\User;
use \models\objects\UserRequest;
use \models\back\GroupModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserRequestModel extends Model
{

    public function index()
    {

        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->t('main page', 'back'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->t($this->control . ' page', 'back'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->t('control panel', 'back') . ' - ' . $this->t($this->control . ' page', 'back');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/mixitup-3/dist/mixitup.min.js');
        
        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['toggle'] = $this->linker->getUrl($this->control . '/toggle', true);
        $data['controls'] = $controls;

        $dataTableAjaxParams = [];
        $dataTableAjaxParams['page-start'] = (!empty($_GET['page_start'])) ? $_GET['page_start'] : '';
        $dataTableAjaxParams['page-length'] = (!empty($_GET['page_length'])) ? $_GET['page_length'] : '';
        $dataTableAjaxParams['page-order-column'] = (!empty($_GET['page_order_column'])) ? $_GET['page_order_column'] : '';
        $dataTableAjaxParams['page-order-dir'] = (!empty($_GET['page_order_dir'])) ? $_GET['page_order_dir'] : '';
        $data['dataTableAjaxParams'] = $dataTableAjaxParams;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }

    public function list_ajax() {
        
        $data = [];

        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['toggle'] = $this->linker->getUrl($this->control . '/toggle', true);
        $data['controls'] = $controls;

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];

        $totalRows = $this->qb->select('id')->count('??user_request');
        $data['recordsTotal'] = $totalRows;

        $offset = (int)$_POST['start'];
        // if(isset($_POST['page_start'])){
        //     $offset = (int)$_POST['page_start'];
        // }

        $limit = (int)$_POST['length'];
        // if(isset($_POST['page_length'])){
        //     $limit = (int)$_POST['page_length'];
        // }
        if($limit < 1){
            $limit = 10;
        }

        $getOrder = (int)$_POST['order'][0]['column'];
        // if(isset($_POST['page_order_column'])){
        //     $getOrder = (int)$_POST['page_order_column'];
        // }
        switch ($getOrder) {
            case 0:
                $order = 'ur.id';
                break;
            
            case 1:
                $order = 'ur.user_id';
                break;
            
            case 2:
                $order = 'ur.type';
                break;
            
            case 3:
                $order = 'ur.target_id';
                break;
            
            case 4:
                $order = 'ur.date';
                break;
            
            case 5:
                $order = 'ur.status';
                break;

            default:
                $order = 'ur.id';
                break;
        }

        $getOrderDir = $_POST['order'][0]['dir'];
        // if(isset($_POST['page_order_dir'])){
        //     $getOrderDir = $_POST['page_order_dir'];
        // }
        $orderDir = ($getOrderDir == 'desc') ? 'DESC' : 'ASC';

        $recordsFiltered = $totalRows;

        $search_where = '';
        $where_params = null;

        $search = $_POST['search']['value'];
        $searchText = substr($search, 0, 65536);

        if($searchText){
            $where_params = [];
            $search_where = " (ur.type LIKE ?) ";
            $where_params[] = '%' . $searchText . '%';
            $querySearch = 'SELECT ur.id FROM ??user_request ur WHERE ' . $search_where . ' GROUP BY ur.id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;

        $query = 'SELECT ur.*, u1.username u1_username, u1.firstname u1_firstname, u1.lastname u1_lastname, u2.username u2_username, u2.firstname u2_firstname, u2.lastname u2_lastname, g.name g_name, g.start_year g_start_year, g.end_year g_end_year FROM `??user_request` ur LEFT JOIN ??user u1 ON u1.id = ur.user_id LEFT JOIN ??user u2 ON u2.id = ur.target_id LEFT JOIN ??student_to_group s2g ON s2g.student_id = ur.target_id LEFT JOIN ??group g ON g.id = s2g.group_id';
        if($searchText){
            $query .= ' WHERE ' . $search_where;
        }

        $query .= ' GROUP BY ur.id ';
        $query .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ';
        $query .= ' LIMIT ' . $offset . ', ' . $limit . ' ';

        $getItems = $this->qb->prepare($query);
        $getItems->execute($where_params);


        $items = [];
        if($getItems->rowCount() > 0){
            $items = $getItems->fetchAll();
        }

        $groupModel = new GroupModel();

        $itemsData = [];

        foreach($items as $value){
            $currentTargetIdGrade = $groupModel->getGrade($value['g_start_year'], $value['g_end_year']);
            $itemsDataRow = [];

            $itemsDataRow[0] = $value['id'];
            $itemsDataRow[1] = $value['u1_lastname'] . "\n<br>" . $value['u1_firstname'] . "\n<br>(" . $value['u1_username'] . ")";
            $itemsDataRow[2] = $this->t('user_request_type ' . $value['type'], 'back');
            $itemsDataRow[3] = $value['u2_lastname'] . "\n<br>" . $value['u2_firstname'] . "\n<br>(" . $currentTargetIdGrade . ' - ' . $value['g_name'] . ")" . "\n<br>(" . $value['u2_username'] . ")";
            $itemsDataRow[4] = date('d-m-Y H:i', $value['date']);
            $itemsDataRow[5] = '<span id="request_target_' . $value['id'] . '">' . $this->t('user_request_status_result ' . $value['status'], 'back') . '</span>';
            
            $itemsDataRow[6] =   '<div class="btn-group">' . 
                                    '<button class="request-send-btn btn btn-success ' . ( ($value['status'] == UserRequest::STATUS_ACCEPTED) ? 'active disabled' : '') . '" data-target="' . $controls['toggle'] . '?id=' . $value['id'] . '&status=STATUS_ACCEPTED" data-id="' . $value['id'] . '">' . $this->t('user_request_status ' . UserRequest::STATUS_ACCEPTED, 'back') . ( ($value['status'] == UserRequest::STATUS_ACCEPTED) ? '<i style="margin-left: 10px;" class="fa fa-check"></i>' : '') . '</button>' .
                                    '<button class="request-send-btn btn btn-danger ' . ( ($value['status'] == UserRequest::STATUS_REJECTED) ? 'active disabled' : '') . '" data-target="' . $controls['toggle'] . '?id=' . $value['id'] . '&status=STATUS_REJECTED" data-id="' . $value['id'] . '">' . $this->t('user_request_status ' . UserRequest::STATUS_REJECTED, 'back')  .  ( ($value['status'] == UserRequest::STATUS_REJECTED) ? '<i style="margin-left: 10px;" class="fa fa-check"></i>' : '') . '</button>' .
                                    '</div>';
            $itemsData[] = $itemsDataRow;
        }

        $data['data'] = $itemsData;

        $this->data = $data;

        return $this;
    }

    public function toggle()
    {
        $data = [];
        $data['success'] = false;
        $id = (int)$_GET['id'];
        $rawStatus = $_GET['status'];
        $class = new \ReflectionClass('\models\objects\UserRequest');
        $status = $class->getConstant($rawStatus);

        $data['id'] = $id;
        $data['status'] = $status;

        if($status !== false){
            $userRequest = new UserRequest();
            if($id && $userRequest->find($id)){
                if($userRequest->type == UserRequest::TYPE_ADD_USER_STUDENT){
                    $checkAddedBefore = $this->qb->where([['user_id', '?'], ['student_id', '?']])->get('??student_to_user', [$userRequest->user_id, $userRequest->target_id]);
                    $userRequest->status = $status;
                    $userRequest->save();
                    if($userRequest->savedSuccess){
                        if($checkAddedBefore->rowCount() == 0 && $status == UserRequest::STATUS_ACCEPTED){
                            $insertResult = $this->qb->insert('??student_to_user', ['user_id' => $userRequest->user_id, 'student_id' => $userRequest->target_id]);
                            if($insertResult){
                                $data['success'] = true;
                            }  
                        }
                        if($checkAddedBefore->rowCount() > 0 && $status == UserRequest::STATUS_REJECTED){
                            $deleteResult = $this->qb->where([['user_id', $userRequest->user_id], ['student_id', $userRequest->target_id]])->delete('??student_to_user');
                            if($deleteResult){
                                $data['success'] = true;
                            }  
                        }
                    }
                        
                }     
            }

            if($data['success']){
                $data['text'] = $this->t('user_request_status_result ' . $status, 'back');
            }
        }
            

        $this->data = $data;

        return $this;
    }

}
