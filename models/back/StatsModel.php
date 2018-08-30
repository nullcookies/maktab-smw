<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class StatsModel extends Model {

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
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');

        $stats = [];
        $stats['contract_completion'] = [
            'name' => $this->getTranslation('contract completion'),
            'url' => $this->linker->getUrl('stats/contract_completion', true)
        ];
        $stats['sales'] = [
            'name' => $this->getTranslation('sales'),
            'url' => $this->linker->getUrl('stats/sales', true)
        ];
        $data['stats'] = $stats;


        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function contract_completion() {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl('stats', true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('contract completion'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');

        $years = [];
        $currentYear = date('Y');
        $minYear = $this->qb->select('contract_year')->order('contract_year')->limit(1)->get('??usercontract')->fetch()['contract_year'];
        if(!$minYear){
            $minYear = $currentYear;
        }
        if( ($currentYear - 30) > $minYear){
            $minYear = $currentYear - 30;
        }
        for($i = $minYear; $i <= $currentYear; $i++){
            $years[] = $i;
        }
        $data['years'] = $years;

        $currentMonth = date('n');
        $currentQuarter = 1;
        switch($currentMonth){
            case 4:
            case 5:
            case 6: $currentQuarter = 2; break;
            case 7:
            case 8:
            case 9: $currentQuarter = 3; break;
            case 10:
            case 11:
            case 12: $currentQuarter = 4;
        }
        $data['currentQuarter'] = $currentQuarter;

        $categories = [];
        $categoryNames = [];
        $getCategories = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??category');
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            foreach($categories as $value){
                $categoryNames[$value['id']] = $value['name'][LANG_ID];
            }
        }
        $data['categories'] = $categories;
        $data['categoryNames'] = $categoryNames;

        $filterYear = (isset($_GET['year'])) ? (int)$_GET['year']: date('Y');
        $data['filterYear'] = $filterYear;

        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $filterYear . '-01-01 00:00:01');
        $filterYearStart = $datetime->getTimestamp();
        $quarter1Start = $filterYearStart;
        $quarter2Start = $datetime->setDate($filterYear, 4, 1)->getTimestamp();
        $quarter3Start = $datetime->setDate($filterYear, 7, 1)->getTimestamp();
        $quarter4Start = $datetime->setDate($filterYear, 10, 1)->getTimestamp();
        $nextYearStart = $datetime->setDate($filterYear + 1, 1, 1)->getTimestamp();

        //получаем массив всех товаров (ключи - id товара)
        $allProducts = [];
        $getAllProducts = $this->qb->select('id, unit_in_dal')->get('??product')->fetchAll();
        foreach($getAllProducts as $value){
            $allProducts[$value['id']] = $value;
        }
        

        //получаем контракты
        $usercontracts = [];
        $getUsercontracts = $this->qb->select('uc.*, u.company_name')->join('??user u', 'uc.user_id = u.id')->where('contract_year', '?')->order('uc.contract_year', true)->order('u.company_name')->get('??usercontract uc', [$filterYear]);

        if($getUsercontracts->rowCount() > 0){
            $usercontracts = $getUsercontracts->fetchAll();
            foreach($usercontracts as $key => $value){
                $usercontracts[$key]['price'] = json_decode($value['price'], true);

                // by fact

                //q1
                $getOrders = $this->qb->prepare('SELECT * FROM ??order WHERE `user_id` = ? AND `date` >= ? AND `date` < ? AND (`status` = 1 OR `status` = 2 OR `status` = 3)');
                $getOrders->execute([$value['user_id'], $quarter1Start, $quarter2Start]);
                $quarter1Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
                $quarter1OrdersItems = [];
                foreach($quarter1Orders as $keyQ => $valueQ){
                    $quarter1Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                    foreach($quarter1Orders[$keyQ]['items'] as $valueQitem){
                        if(!isset($quarter1OrdersItems[$valueQitem['product_id']])){
                            $quarter1OrdersItems[$valueQitem['product_id']] = [
                                'product_id' => $valueQitem['product_id'],
                                'quantity_dal' => 0,
                                'quantity' => 0,
                                'sum' => 0
                            ];
                        }
                        $quarter1OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                        $quarter1OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                        $quarter1OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                    }
                }

                //q2
                $getOrders->execute([$value['user_id'], $quarter2Start, $quarter3Start]);
                $quarter2Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
                $quarter2OrdersItems = [];
                foreach($quarter2Orders as $keyQ => $valueQ){
                    $quarter2Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                    foreach($quarter2Orders[$keyQ]['items'] as $valueQitem){
                        if(!isset($quarter2OrdersItems[$valueQitem['product_id']])){
                            $quarter2OrdersItems[$valueQitem['product_id']] = [
                                'product_id' => $valueQitem['product_id'],
                                'quantity_dal' => 0,
                                'quantity' => 0,
                                'sum' => 0
                            ];
                        }
                        $quarter2OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                        $quarter2OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                        $quarter2OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                    }
                }

                //q3
                $getOrders->execute([$value['user_id'], $quarter3Start, $quarter4Start]);
                $quarter3Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
                $quarter3OrdersItems = [];
                foreach($quarter3Orders as $keyQ => $valueQ){
                    $quarter3Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                    foreach($quarter3Orders[$keyQ]['items'] as $valueQitem){
                        if(!isset($quarter3OrdersItems[$valueQitem['product_id']])){
                            $quarter3OrdersItems[$valueQitem['product_id']] = [
                                'product_id' => $valueQitem['product_id'],
                                'quantity_dal' => 0,
                                'quantity' => 0,
                                'sum' => 0
                            ];
                        }
                        $quarter3OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                        $quarter3OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                        $quarter3OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                    }
                }

                //q4
                $getOrders->execute([$value['user_id'], $quarter4Start, $nextYearStart]);
                $quarter4Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
                $quarter4OrdersItems = [];
                foreach($quarter4Orders as $keyQ => $valueQ){
                    $quarter4Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                    foreach($quarter4Orders[$keyQ]['items'] as $valueQitem){
                        if(!isset($quarter4OrdersItems[$valueQitem['product_id']])){
                            $quarter4OrdersItems[$valueQitem['product_id']] = [
                                'product_id' => $valueQitem['product_id'],
                                'quantity_dal' => 0,
                                'quantity' => 0,
                                'sum' => 0
                            ];
                        }
                        $quarter4OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                        $quarter4OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                        $quarter4OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                    }
                }

                //usort($quarter1OrdersItems, array('\models\back\StatsModel', 'sortDesc'));

                //quantity price
                $usercontracts[$key]['quarter_1_fact'] = [];
                $usercontracts[$key]['quarter_2_fact'] = [];
                $usercontracts[$key]['quarter_3_fact'] = [];
                $usercontracts[$key]['quarter_4_fact'] = [];

                //q1 build fact
                $usercontracts[$key]['quarter_1_all_fact_quantity_dal'] = 0;
                $usercontracts[$key]['quarter_1_all_fact_quantity'] = 0;
                $usercontracts[$key]['quarter_1_all_fact_sum'] = 0;
                foreach($quarter1OrdersItems as $qKey => $qItem){
                    $qItemCatId = $this->qb->select('category_id')->where('id', '?')->get('??product', [$qItem['product_id']])->fetch()['category_id'];
                    
                    if(!isset($usercontracts[$key]['quarter_1_fact'][$qItemCatId])){
                        $usercontracts[$key]['quarter_1_fact'][$qItemCatId] = [];
                    }
                    if(!isset($usercontracts[$key]['quarter_1_fact'][$qItemCatId]['quantity_dal'])){
                        $usercontracts[$key]['quarter_1_fact'][$qItemCatId]['quantity_dal'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_1_fact'][$qItemCatId]['quantity'])){
                        $usercontracts[$key]['quarter_1_fact'][$qItemCatId]['quantity'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_1_fact'][$qItemCatId]['sum'])){
                        $usercontracts[$key]['quarter_1_fact'][$qItemCatId]['sum'] = 0;
                    }
                    $usercontracts[$key]['quarter_1_fact'][$qItemCatId]['quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_1_fact'][$qItemCatId]['quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_1_fact'][$qItemCatId]['sum'] += $qItem['sum'];

                    $usercontracts[$key]['quarter_1_all_fact_quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_1_all_fact_quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_1_all_fact_sum'] += $qItem['sum'];
                }

                //q2 build fact
                $usercontracts[$key]['quarter_2_all_fact_quantity_dal'] = 0;
                $usercontracts[$key]['quarter_2_all_fact_quantity'] = 0;
                $usercontracts[$key]['quarter_2_all_fact_sum'] = 0;
                foreach($quarter2OrdersItems as $qKey => $qItem){
                    $qItemCatId = $this->qb->select('category_id')->where('id', '?')->get('??product', [$qItem['product_id']])->fetch()['category_id'];
                    
                    if(!isset($usercontracts[$key]['quarter_2_fact'][$qItemCatId])){
                        $usercontracts[$key]['quarter_2_fact'][$qItemCatId] = [];
                    }
                    if(!isset($usercontracts[$key]['quarter_2_fact'][$qItemCatId]['quantity_dal'])){
                        $usercontracts[$key]['quarter_2_fact'][$qItemCatId]['quantity_dal'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_2_fact'][$qItemCatId]['quantity'])){
                        $usercontracts[$key]['quarter_2_fact'][$qItemCatId]['quantity'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_2_fact'][$qItemCatId]['sum'])){
                        $usercontracts[$key]['quarter_2_fact'][$qItemCatId]['sum'] = 0;
                    }
                    $usercontracts[$key]['quarter_2_fact'][$qItemCatId]['quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_2_fact'][$qItemCatId]['quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_2_fact'][$qItemCatId]['sum'] += $qItem['sum'];

                    $usercontracts[$key]['quarter_2_all_fact_quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_2_all_fact_quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_2_all_fact_sum'] += $qItem['sum'];
                }
                //q3 build fact
                $usercontracts[$key]['quarter_3_all_fact_quantity_dal'] = 0;
                $usercontracts[$key]['quarter_3_all_fact_quantity'] = 0;
                $usercontracts[$key]['quarter_3_all_fact_sum'] = 0;
                foreach($quarter3OrdersItems as $qKey => $qItem){
                    $qItemCatId = $this->qb->select('category_id')->where('id', '?')->get('??product', [$qItem['product_id']])->fetch()['category_id'];
                    
                    if(!isset($usercontracts[$key]['quarter_3_fact'][$qItemCatId])){
                        $usercontracts[$key]['quarter_3_fact'][$qItemCatId] = [];
                    }
                    if(!isset($usercontracts[$key]['quarter_3_fact'][$qItemCatId]['quantity_dal'])){
                        $usercontracts[$key]['quarter_3_fact'][$qItemCatId]['quantity_dal'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_3_fact'][$qItemCatId]['quantity'])){
                        $usercontracts[$key]['quarter_3_fact'][$qItemCatId]['quantity'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_3_fact'][$qItemCatId]['sum'])){
                        $usercontracts[$key]['quarter_3_fact'][$qItemCatId]['sum'] = 0;
                    }
                    $usercontracts[$key]['quarter_3_fact'][$qItemCatId]['quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_3_fact'][$qItemCatId]['quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_3_fact'][$qItemCatId]['sum'] += $qItem['sum'];

                    $usercontracts[$key]['quarter_3_all_fact_quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_3_all_fact_quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_3_all_fact_sum'] += $qItem['sum'];
                }
                //q4 build fact
                $usercontracts[$key]['quarter_4_all_fact_quantity_dal'] = 0;
                $usercontracts[$key]['quarter_4_all_fact_quantity'] = 0;
                $usercontracts[$key]['quarter_4_all_fact_sum'] = 0;
                foreach($quarter4OrdersItems as $qKey => $qItem){
                    $qItemCatId = $this->qb->select('category_id')->where('id', '?')->get('??product', [$qItem['product_id']])->fetch()['category_id'];
                    
                    if(!isset($usercontracts[$key]['quarter_4_fact'][$qItemCatId])){
                        $usercontracts[$key]['quarter_4_fact'][$qItemCatId] = [];
                    }
                    if(!isset($usercontracts[$key]['quarter_4_fact'][$qItemCatId]['quantity_dal'])){
                        $usercontracts[$key]['quarter_4_fact'][$qItemCatId]['quantity_dal'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_4_fact'][$qItemCatId]['quantity'])){
                        $usercontracts[$key]['quarter_4_fact'][$qItemCatId]['quantity'] = 0;
                    }
                    if(!isset($usercontracts[$key]['quarter_4_fact'][$qItemCatId]['sum'])){
                        $usercontracts[$key]['quarter_4_fact'][$qItemCatId]['sum'] = 0;
                    }
                    $usercontracts[$key]['quarter_4_fact'][$qItemCatId]['quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_4_fact'][$qItemCatId]['quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_4_fact'][$qItemCatId]['sum'] += $qItem['sum'];

                    $usercontracts[$key]['quarter_4_all_fact_quantity_dal'] += $qItem['quantity_dal'];
                    $usercontracts[$key]['quarter_4_all_fact_quantity'] += $qItem['quantity'];
                    $usercontracts[$key]['quarter_4_all_fact_sum'] += $qItem['sum'];
                }

                //year fact
                $usercontracts[$key]['year_total_all_fact_quantity_dal'] = 0;
                $usercontracts[$key]['year_total_all_fact_quantity'] = 0;
                $usercontracts[$key]['year_total_all_fact_sum'] = 0;
                foreach($categoryNames as $catKey => $catValue){
                    
                    if(!isset($usercontracts[$key]['year_total_fact'][$catKey])){
                        $usercontracts[$key]['year_total_fact'][$catKey] = [];
                    }
                    if(!isset($usercontracts[$key]['year_total_fact'][$catKey]['quantity_dal'])){
                        $usercontracts[$key]['year_total_fact'][$catKey]['quantity_dal'] = 0;
                    }
                    if(!isset($usercontracts[$key]['year_total_fact'][$catKey]['quantity'])){
                        $usercontracts[$key]['year_total_fact'][$catKey]['quantity'] = 0;
                    }
                    if(!isset($usercontracts[$key]['year_total_fact'][$qItemCatId]['sum'])){
                        $usercontracts[$key]['year_total_fact'][$catKey]['sum'] = 0;
                    }
                    $usercontracts[$key]['year_total_fact'][$catKey]['quantity_dal'] = $usercontracts[$key]['quarter_1_fact'][$catKey]['quantity_dal'] + $usercontracts[$key]['quarter_2_fact'][$catKey]['quantity_dal'] + $usercontracts[$key]['quarter_3_fact'][$catKey]['quantity_dal'] + $usercontracts[$key]['quarter_4_fact'][$catKey]['quantity_dal'];
                    $usercontracts[$key]['year_total_fact'][$catKey]['quantity'] = $usercontracts[$key]['quarter_1_fact'][$catKey]['quantity'] + $usercontracts[$key]['quarter_2_fact'][$catKey]['quantity'] + $usercontracts[$key]['quarter_3_fact'][$catKey]['quantity'] + $usercontracts[$key]['quarter_4_fact'][$catKey]['quantity'];
                    $usercontracts[$key]['year_total_fact'][$catKey]['sum'] = $usercontracts[$key]['quarter_1_fact'][$catKey]['sum'] + $usercontracts[$key]['quarter_2_fact'][$catKey]['sum'] + $usercontracts[$key]['quarter_3_fact'][$catKey]['sum'] + $usercontracts[$key]['quarter_4_fact'][$catKey]['sum'];
                    $usercontracts[$key]['year_total_all_fact_quantity_dal'] += $usercontracts[$key]['year_total_fact'][$catKey]['quantity_dal'];
                    $usercontracts[$key]['year_total_all_fact_quantity'] += $usercontracts[$key]['year_total_fact'][$catKey]['quantity'];
                    $usercontracts[$key]['year_total_all_fact_sum'] += $usercontracts[$key]['year_total_fact'][$catKey]['sum'];
                }




                //by contract
                $usercontracts[$key]['year_total'] = [];
                $usercontracts[$key]['quarter_1'] = json_decode($value['quarter_1'], true);
                $usercontracts[$key]['quarter_2'] = json_decode($value['quarter_2'], true);
                $usercontracts[$key]['quarter_3'] = json_decode($value['quarter_3'], true);
                $usercontracts[$key]['quarter_4'] = json_decode($value['quarter_4'], true);
                foreach($categories as $key1 => $value1){
                    $usercontracts[$key]['quarter_1'][$value1['id']] = [
                        'quantity_dal' => $usercontracts[$key]['quarter_1'][$value1['id']],
                        'sum' => $usercontracts[$key]['quarter_1'][$value1['id']] * $usercontracts[$key]['price'][$value1['id']]
                    ];
                    $usercontracts[$key]['quarter_2'][$value1['id']] = [
                        'quantity_dal' => $usercontracts[$key]['quarter_2'][$value1['id']],
                        'sum' => $usercontracts[$key]['quarter_2'][$value1['id']] * $usercontracts[$key]['price'][$value1['id']]
                    ];
                    $usercontracts[$key]['quarter_3'][$value1['id']] = [
                        'quantity_dal' => $usercontracts[$key]['quarter_3'][$value1['id']],
                        'sum' => $usercontracts[$key]['quarter_3'][$value1['id']] * $usercontracts[$key]['price'][$value1['id']]
                    ];
                    $usercontracts[$key]['quarter_4'][$value1['id']] = [
                        'quantity_dal' => $usercontracts[$key]['quarter_4'][$value1['id']],
                        'sum' => $usercontracts[$key]['quarter_4'][$value1['id']] * $usercontracts[$key]['price'][$value1['id']]
                    ];

                    if(!isset($usercontracts[$key]['year_total'][$value1['id']])){
                        $usercontracts[$key]['year_total'][$value1['id']] = [
                            'quantity_dal' => 0,
                            'sum' => 0
                        ];
                    }

                    $usercontracts[$key]['year_total'][$value1['id']]['quantity_dal'] = $usercontracts[$key]['quarter_1'][$value1['id']]['quantity_dal'] + $usercontracts[$key]['quarter_2'][$value1['id']]['quantity_dal'] + $usercontracts[$key]['quarter_3'][$value1['id']]['quantity_dal'] + $usercontracts[$key]['quarter_4'][$value1['id']]['quantity_dal'];
                    $usercontracts[$key]['year_total'][$value1['id']]['sum'] = $usercontracts[$key]['quarter_1'][$value1['id']]['sum'] + $usercontracts[$key]['quarter_2'][$value1['id']]['sum'] + $usercontracts[$key]['quarter_3'][$value1['id']]['sum'] + $usercontracts[$key]['quarter_4'][$value1['id']]['sum'];
                }
            }
        }
        $data['usercontracts'] = $usercontracts;


        $controls = [];
        $controls['current'] = $this->linker->getUrl($this->control . '/contract_completion', true);
        $controls['view'] = $this->linker->getUrl($this->control . '/contract_completion/view', true);
        $data['controls'] = $controls;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function contract_completion_view() {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl('stats', true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('contract completion'),
            'url' => $this->linker->getUrl('stats/contract_completion', true)
        ];
        
        $data['allUsercontracts'] = $this->linker->getUrl('stats/contract_completion', true);
        
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');
        
        $years = [];
        $currentYear = date('Y');
        $minYear = $this->qb->select('contract_year')->order('contract_year')->limit(1)->get('??usercontract')->fetch()['contract_year'];
        if(!$minYear){
            $minYear = $currentYear;
        }
        if( ($currentYear - 30) > $minYear){
            $minYear = $currentYear - 30;
        }
        for($i = $minYear; $i <= $currentYear; $i++){
            $years[] = $i;
        }
        $data['years'] = $years;

        $currentMonth = date('n');
        $currentQuarter = 1;
        switch($currentMonth){
            case 4:
            case 5:
            case 6: $currentQuarter = 2; break;
            case 7:
            case 8:
            case 9: $currentQuarter = 3; break;
            case 10:
            case 11:
            case 12: $currentQuarter = 4;
        }
        $data['currentQuarter'] = $currentQuarter;

        $data['quarterActive'] = (int)$_GET['param3'];
        if(!$data['quarterActive']){
            $data['quarterActive'] = $currentQuarter;
        }

        //получаем массив всех товаров (ключи - id товара)
        $allProducts = [];
        $getAllProducts = $this->qb->select('id, unit_in_dal')->get('??product')->fetchAll();
        foreach($getAllProducts as $value){
            $allProducts[$value['id']] = $value;
        }

        //категории
        $categories = [];
        $categoryNames = [];
        $getCategories = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??category');
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            foreach($categories as $value){
                $categoryNames[$value['id']] = $value['name'][LANG_ID];
            }
        }
        $data['categories'] = $categories;
        $data['categoryNames'] = $categoryNames;

        $filterYear = (isset($_GET['year'])) ? (int)$_GET['year']: date('Y');
        $data['filterYear'] = $filterYear;

        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $filterYear . '-01-01 00:00:01');
        $filterYearStart = $datetime->getTimestamp();
        $quarter1Start = $filterYearStart;
        $quarter2Start = $datetime->setDate($filterYear, 4, 1)->getTimestamp();
        $quarter3Start = $datetime->setDate($filterYear, 7, 1)->getTimestamp();
        $quarter4Start = $datetime->setDate($filterYear, 10, 1)->getTimestamp();
        $nextYearStart = $datetime->setDate($filterYear + 1, 1, 1)->getTimestamp();
        
        $contractId = (int)$_GET['param2'];
        
        
        $usercontract = [];
        if($contractId){
            $usercontract = [];
            $getUsercontract = $this->qb->select('uc.*, u.company_name')->join('??user u', 'uc.user_id = u.id')->where('uc.id', '?')->get('??usercontract uc', [$contractId]);
            if($getUsercontract->rowCount() > 0){
                $usercontract = $getUsercontract->fetch();
            }
            

            //user contract modify
            $usercontract['price'] = json_decode($usercontract['price'], true);

            // by fact

            //q1
            $getOrders = $this->qb->prepare('SELECT * FROM ??order WHERE `user_id` = ? AND `date` >= ? AND `date` < ? AND (`status` = 1 OR `status` = 2 OR `status` = 3)');
            $getOrders->execute([$usercontract['user_id'], $quarter1Start, $quarter2Start]);
            $quarter1Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
            $quarter1OrdersItems = [];
            foreach($quarter1Orders as $keyQ => $valueQ){
                $quarter1Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                foreach($quarter1Orders[$keyQ]['items'] as $valueQitem){
                    if(!isset($quarter1OrdersItems[$valueQitem['product_id']])){
                        $quarter1OrdersItems[$valueQitem['product_id']] = [
                            'product_id' => $valueQitem['product_id'],
                            'quantity_dal' => 0,
                            'quantity' => 0,
                            'sum' => 0
                        ];
                    }
                    $quarter1OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                    $quarter1OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                    $quarter1OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                }
            }

            //q2
            $getOrders->execute([$usercontract['user_id'], $quarter2Start, $quarter3Start]);
            $quarter2Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
            $quarter2OrdersItems = [];
            foreach($quarter2Orders as $keyQ => $valueQ){
                $quarter2Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                foreach($quarter2Orders[$keyQ]['items'] as $valueQitem){
                    if(!isset($quarter2OrdersItems[$valueQitem['product_id']])){
                        $quarter2OrdersItems[$valueQitem['product_id']] = [
                            'product_id' => $valueQitem['product_id'],
                            'quantity_dal' => 0,
                            'quantity' => 0,
                            'sum' => 0
                        ];
                    }
                    $quarter2OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                    $quarter2OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                    $quarter2OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                }
            }

            //q3
            $getOrders->execute([$usercontract['user_id'], $quarter3Start, $quarter4Start]);
            $quarter3Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
            $quarter3OrdersItems = [];
            foreach($quarter3Orders as $keyQ => $valueQ){
                $quarter3Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                foreach($quarter3Orders[$keyQ]['items'] as $valueQitem){
                    if(!isset($quarter3OrdersItems[$valueQitem['product_id']])){
                        $quarter3OrdersItems[$valueQitem['product_id']] = [
                            'product_id' => $valueQitem['product_id'],
                            'quantity_dal' => 0,
                            'quantity' => 0,
                            'sum' => 0
                        ];
                    }
                    $quarter3OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                    $quarter3OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                    $quarter3OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                }
            }

            //q4
            $getOrders->execute([$usercontract['user_id'], $quarter4Start, $nextYearStart]);
            $quarter4Orders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
            $quarter4OrdersItems = [];
            foreach($quarter4Orders as $keyQ => $valueQ){
                $quarter4Orders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                foreach($quarter4Orders[$keyQ]['items'] as $valueQitem){
                    if(!isset($quarter4OrdersItems[$valueQitem['product_id']])){
                        $quarter4OrdersItems[$valueQitem['product_id']] = [
                            'product_id' => $valueQitem['product_id'],
                            'quantity_dal' => 0,
                            'quantity' => 0,
                            'sum' => 0
                        ];
                    }
                    $quarter4OrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                    $quarter4OrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                    $quarter4OrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                }
            }

            //year
            $getOrders->execute([$usercontract['user_id'], $quarter1Start, $nextYearStart]);
            $yearOrders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
            $yearOrdersItems = [];
            foreach($yearOrders as $keyQ => $valueQ){
                $yearOrders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                foreach($yearOrders[$keyQ]['items'] as $valueQitem){
                    if(!isset($yearOrdersItems[$valueQitem['product_id']])){
                        $yearOrdersItems[$valueQitem['product_id']] = [
                            'product_id' => $valueQitem['product_id'],
                            'quantity_dal' => 0,
                            'quantity' => 0,
                            'sum' => 0
                        ];
                    }
                    $yearOrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                    $yearOrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                    $yearOrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                }
            }


            //quantity price
            $usercontract['quarter_1_fact'] = [];
            $usercontract['quarter_2_fact'] = [];
            $usercontract['quarter_3_fact'] = [];
            $usercontract['quarter_4_fact'] = [];

            //q1 build fact
            foreach($quarter1OrdersItems as $qKey => $qItem){
                $qItemFull = $this->qb->where('id', '?')->get('??product', [$qItem['product_id']])->fetch();
                
                if(!isset($usercontract['quarter_1_fact'][$qItemFull['category_id']])){
                    $usercontract['quarter_1_fact'][$qItemFull['category_id']] = [];
                }
                if(!isset($usercontract['quarter_1_fact'][$qItemFull['category_id']]['quantity_dal'])){
                    $usercontract['quarter_1_fact'][$qItemFull['category_id']]['quantity_dal'] = 0;
                }
                if(!isset($usercontract['quarter_1_fact'][$qItemFull['category_id']]['quantity'])){
                    $usercontract['quarter_1_fact'][$qItemFull['category_id']]['quantity'] = 0;
                }
                if(!isset($usercontract['quarter_1_fact'][$qItemFull['category_id']]['sum'])){
                    $usercontract['quarter_1_fact'][$qItemFull['category_id']]['sum'] = 0;
                }
                if(!isset($usercontract['quarter_1_fact'][$qItemFull['category_id']]['items'])){
                    $usercontract['quarter_1_fact'][$qItemFull['category_id']]['items'] = [];
                }
                $usercontract['quarter_1_fact'][$qItemFull['category_id']]['quantity_dal'] += $qItem['quantity_dal'];
                $usercontract['quarter_1_fact'][$qItemFull['category_id']]['quantity'] += $qItem['quantity'];
                $usercontract['quarter_1_fact'][$qItemFull['category_id']]['sum'] += $qItem['sum'];
                $qItemFull = $this->langDecode($qItemFull, ['name'], false);
                $qItemFull['url'] = $this->linker->getUrl('product/edit/' . $qItemFull['id'], true);
                $qItemFull['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($qItemFull['images']), 50, 50));
                $qItemFull['sold_quantity_dal'] = $qItem['quantity_dal'];
                $qItemFull['sold_quantity'] = $qItem['quantity'];
                $qItemFull['sold_sum'] = $qItem['sum'];
                $usercontract['quarter_1_fact'][$qItemFull['category_id']]['items'][] = $qItemFull;
                usort($usercontract['quarter_1_fact'][$qItemFull['category_id']]['items'], array('\models\back\StatsModel', 'sortDescSoldQuantity'));
            }
            
            //q2 build fact
            foreach($quarter2OrdersItems as $qKey => $qItem){
                $qItemFull = $this->qb->where('id', '?')->get('??product', [$qItem['product_id']])->fetch();
                
                if(!isset($usercontract['quarter_2_fact'][$qItemFull['category_id']])){
                    $usercontract['quarter_2_fact'][$qItemFull['category_id']] = [];
                }
                if(!isset($usercontract['quarter_2_fact'][$qItemFull['category_id']]['quantity_dal'])){
                    $usercontract['quarter_2_fact'][$qItemFull['category_id']]['quantity_dal'] = 0;
                }
                if(!isset($usercontract['quarter_2_fact'][$qItemFull['category_id']]['quantity'])){
                    $usercontract['quarter_2_fact'][$qItemFull['category_id']]['quantity'] = 0;
                }
                if(!isset($usercontract['quarter_2_fact'][$qItemFull['category_id']]['sum'])){
                    $usercontract['quarter_2_fact'][$qItemFull['category_id']]['sum'] = 0;
                }
                if(!isset($usercontract['quarter_2_fact'][$qItemFull['category_id']]['items'])){
                    $usercontract['quarter_2_fact'][$qItemFull['category_id']]['items'] = [];
                }
                $usercontract['quarter_2_fact'][$qItemFull['category_id']]['quantity_dal'] += $qItem['quantity_dal'];
                $usercontract['quarter_2_fact'][$qItemFull['category_id']]['quantity'] += $qItem['quantity'];
                $usercontract['quarter_2_fact'][$qItemFull['category_id']]['sum'] += $qItem['sum'];
                $qItemFull = $this->langDecode($qItemFull, ['name'], false);
                $qItemFull['url'] = $this->linker->getUrl('product/edit/' . $qItemFull['id'], true);
                $qItemFull['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($qItemFull['images']), 50, 50));
                $qItemFull['sold_quantity_dal'] = $qItem['quantity_dal'];
                $qItemFull['sold_quantity'] = $qItem['quantity'];
                $qItemFull['sold_sum'] = $qItem['sum'];
                $usercontract['quarter_2_fact'][$qItemFull['category_id']]['items'][] = $qItemFull;
                usort($usercontract['quarter_2_fact'][$qItemFull['category_id']]['items'], array('\models\back\StatsModel', 'sortDescSoldQuantity'));
            }
            //q3 build fact
            foreach($quarter3OrdersItems as $qKey => $qItem){
                $qItemFull = $this->qb->where('id', '?')->get('??product', [$qItem['product_id']])->fetch();
                
                if(!isset($usercontract['quarter_3_fact'][$qItemFull['category_id']])){
                    $usercontract['quarter_3_fact'][$qItemFull['category_id']] = [];
                }
                if(!isset($usercontract['quarter_3_fact'][$qItemFull['category_id']]['quantity_dal'])){
                    $usercontract['quarter_3_fact'][$qItemFull['category_id']]['quantity_dal'] = 0;
                }
                if(!isset($usercontract['quarter_3_fact'][$qItemFull['category_id']]['quantity'])){
                    $usercontract['quarter_3_fact'][$qItemFull['category_id']]['quantity'] = 0;
                }
                if(!isset($usercontract['quarter_3_fact'][$qItemFull['category_id']]['sum'])){
                    $usercontract['quarter_3_fact'][$qItemFull['category_id']]['sum'] = 0;
                }
                if(!isset($usercontract['quarter_3_fact'][$qItemFull['category_id']]['items'])){
                    $usercontract['quarter_3_fact'][$qItemFull['category_id']]['items'] = [];
                }
                $usercontract['quarter_3_fact'][$qItemFull['category_id']]['quantity_dal'] += $qItem['quantity_dal'];
                $usercontract['quarter_3_fact'][$qItemFull['category_id']]['quantity'] += $qItem['quantity'];
                $usercontract['quarter_3_fact'][$qItemFull['category_id']]['sum'] += $qItem['sum'];
                $qItemFull = $this->langDecode($qItemFull, ['name'], false);
                $qItemFull['url'] = $this->linker->getUrl('product/edit/' . $qItemFull['id'], true);
                $qItemFull['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($qItemFull['images']), 50, 50));
                $qItemFull['sold_quantity_dal'] = $qItem['quantity_dal'];
                $qItemFull['sold_quantity'] = $qItem['quantity'];
                $qItemFull['sold_sum'] = $qItem['sum'];
                $usercontract['quarter_3_fact'][$qItemFull['category_id']]['items'][] = $qItemFull;
                usort($usercontract['quarter_3_fact'][$qItemFull['category_id']]['items'], array('\models\back\StatsModel', 'sortDescSoldQuantity'));
            }
            //q4 build fact
            foreach($quarter4OrdersItems as $qKey => $qItem){
                $qItemFull = $this->qb->where('id', '?')->get('??product', [$qItem['product_id']])->fetch();
                
                if(!isset($usercontract['quarter_4_fact'][$qItemFull['category_id']])){
                    $usercontract['quarter_4_fact'][$qItemFull['category_id']] = [];
                }
                if(!isset($usercontract['quarter_4_fact'][$qItemFull['category_id']]['quantity'])){
                    $usercontract['quarter_4_fact'][$qItemFull['category_id']]['quantity'] = 0;
                }
                if(!isset($usercontract['quarter_4_fact'][$qItemFull['category_id']]['quantity_dal'])){
                    $usercontract['quarter_4_fact'][$qItemFull['category_id']]['quantity_dal'] = 0;
                }
                if(!isset($usercontract['quarter_4_fact'][$qItemFull['category_id']]['sum'])){
                    $usercontract['quarter_4_fact'][$qItemFull['category_id']]['sum'] = 0;
                }
                if(!isset($usercontract['quarter_4_fact'][$qItemFull['category_id']]['items'])){
                    $usercontract['quarter_4_fact'][$qItemFull['category_id']]['items'] = [];
                }
                $usercontract['quarter_4_fact'][$qItemFull['category_id']]['quantity_dal'] += $qItem['quantity_dal'];
                $usercontract['quarter_4_fact'][$qItemFull['category_id']]['quantity'] += $qItem['quantity'];
                $usercontract['quarter_4_fact'][$qItemFull['category_id']]['sum'] += $qItem['sum'];
                $qItemFull = $this->langDecode($qItemFull, ['name'], false);
                $qItemFull['url'] = $this->linker->getUrl('product/edit/' . $qItemFull['id'], true);
                $qItemFull['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($qItemFull['images']), 50, 50));
                $qItemFull['sold_quantity_dal'] = $qItem['quantity_dal'];
                $qItemFull['sold_quantity'] = $qItem['quantity'];
                $qItemFull['sold_sum'] = $qItem['sum'];
                $usercontract['quarter_4_fact'][$qItemFull['category_id']]['items'][] = $qItemFull;
                usort($usercontract['quarter_4_fact'][$qItemFull['category_id']]['items'], array('\models\back\StatsModel', 'sortDescSoldQuantity'));
            }

            //year total fact
            foreach($categoryNames as $catKey => $catValue){

                if(!isset($usercontract['year_total_fact'][$catKey])){
                    $usercontract['year_total_fact'][$catKey] = [];
                }
                if(!isset($usercontract['year_total_fact'][$catKey]['quantity_dal'])){
                    $usercontract['year_total_fact'][$catKey]['quantity_dal'] = 0;
                }
                if(!isset($usercontract['year_total_fact'][$catKey]['quantity'])){
                    $usercontract['year_total_fact'][$catKey]['quantity'] = 0;
                }
                if(!isset($usercontract['year_total_fact'][$qItemCatId]['sum'])){
                    $usercontract['year_total_fact'][$catKey]['sum'] = 0;
                }
                $usercontract['year_total_fact'][$catKey]['quantity_dal'] = $usercontract['quarter_1_fact'][$catKey]['quantity_dal'] + $usercontract['quarter_2_fact'][$catKey]['quantity_dal'] + $usercontract['quarter_3_fact'][$catKey]['quantity_dal'] + $usercontract['quarter_4_fact'][$catKey]['quantity_dal'];
                $usercontract['year_total_fact'][$catKey]['quantity'] = $usercontract['quarter_1_fact'][$catKey]['quantity'] + $usercontract['quarter_2_fact'][$catKey]['quantity'] + $usercontract['quarter_3_fact'][$catKey]['quantity'] + $usercontract['quarter_4_fact'][$catKey]['quantity'];
                $usercontract['year_total_fact'][$catKey]['sum'] = $usercontract['quarter_1_fact'][$catKey]['sum'] + $usercontract['quarter_2_fact'][$catKey]['sum'] + $usercontract['quarter_3_fact'][$catKey]['sum'] + $usercontract['quarter_4_fact'][$catKey]['sum'];
            }
            foreach($yearOrdersItems as $qKey => $qItem){
                $qItemFull = $this->qb->where('id', '?')->get('??product', [$qItem['product_id']])->fetch();
                
                if(!isset($usercontract['year_total_fact'][$qItemFull['category_id']])){
                    $usercontract['year_total_fact'][$qItemFull['category_id']] = [];
                }
                if(!isset($usercontract['year_total_fact'][$qItemFull['category_id']]['items'])){
                    $usercontract['year_total_fact'][$qItemFull['category_id']]['items'] = [];
                }
                $qItemFull = $this->langDecode($qItemFull, ['name'], false);
                $qItemFull['url'] = $this->linker->getUrl('product/edit/' . $qItemFull['id'], true);
                $qItemFull['icon'] = $this->linker->getIcon($this->media->resize($this->getMainIcon($qItemFull['images']), 50, 50));
                $qItemFull['sold_quantity_dal'] = $qItem['quantity_dal'];
                $qItemFull['sold_quantity'] = $qItem['quantity'];
                $qItemFull['sold_sum'] = $qItem['sum'];
                $usercontract['year_total_fact'][$qItemFull['category_id']]['items'][] = $qItemFull;
                usort($usercontract['year_total_fact'][$qItemFull['category_id']]['items'], array('\models\back\StatsModel', 'sortDescSoldQuantity'));
            }



            //by contract
            $usercontract['year_total'] = [];
            $usercontract['quarter_1'] = json_decode($usercontract['quarter_1'], true);
            $usercontract['quarter_2'] = json_decode($usercontract['quarter_2'], true);
            $usercontract['quarter_3'] = json_decode($usercontract['quarter_3'], true);
            $usercontract['quarter_4'] = json_decode($usercontract['quarter_4'], true);
            foreach($categories as $key1 => $value1){
                $usercontract['quarter_1'][$value1['id']] = [
                    'quantity_dal' => $usercontract['quarter_1'][$value1['id']],
                    'sum' => $usercontract['quarter_1'][$value1['id']] * $usercontract['price'][$value1['id']]
                ];
                $usercontract['quarter_2'][$value1['id']] = [
                    'quantity_dal' => $usercontract['quarter_2'][$value1['id']],
                    'sum' => $usercontract['quarter_2'][$value1['id']] * $usercontract['price'][$value1['id']]
                ];
                $usercontract['quarter_3'][$value1['id']] = [
                    'quantity_dal' => $usercontract['quarter_3'][$value1['id']],
                    'sum' => $usercontract['quarter_3'][$value1['id']] * $usercontract['price'][$value1['id']]
                ];
                $usercontract['quarter_4'][$value1['id']] = [
                    'quantity_dal' => $usercontract['quarter_4'][$value1['id']],
                    'sum' => $usercontract['quarter_4'][$value1['id']] * $usercontract['price'][$value1['id']]
                ];

                if(!isset($usercontract['year_total'][$value1['id']])){
                    $usercontract['year_total'][$value1['id']] = [
                        'quantity_dal' => 0,
                        'sum' => 0
                    ];
                }

                $usercontract['year_total'][$value1['id']]['quantity_dal'] = $usercontract['quarter_1'][$value1['id']]['quantity_dal'] + $usercontract['quarter_2'][$value1['id']]['quantity_dal'] + $usercontract['quarter_3'][$value1['id']]['quantity_dal'] + $usercontract['quarter_4'][$value1['id']]['quantity_dal'];
                $usercontract['year_total'][$value1['id']]['sum'] = $usercontract['quarter_1'][$value1['id']]['sum'] + $usercontract['quarter_2'][$value1['id']]['sum'] + $usercontract['quarter_3'][$value1['id']]['sum'] + $usercontract['quarter_4'][$value1['id']]['sum'];
            }

            //user contract modify end
            
        }
        $data['usercontract'] = $usercontract;

        $breadcrumbs[] = [
            'name' => $usercontract['company_name'],
            'url' => 'active'
        ];
        $data['breadcrumbs'] = $breadcrumbs;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function sales() {

        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl('stats', true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('sales'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/ru.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');

        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');

        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 00:00:01');
        
        $periodStart = time() - 86400 * 30;
        $periodEnd = time();

        if(isset($_POST['filter_period'])){
            $getPeriod = explode(' - ', $_POST['filter_period']);

            if($getPeriod[0] && $getPeriod[1]){
                $datetimeStart = \DateTime::createFromFormat('d-m-Y', trim($getPeriod[0], '/'));
                $datetimeEnd = \DateTime::createFromFormat('d-m-Y', trim($getPeriod[1], '/'));
                if($datetimeStart && $datetimeEnd){
                    $periodStart = $datetimeStart->getTimestamp();
                    $periodEnd = $datetimeEnd->getTimestamp();
                    if($periodEnd <= $periodStart){
                        $periodEnd = $periodStart + 86400;
                    }
                }
            }
        }

        $data['periodStart'] = $periodStart;
        $data['periodEnd'] = $periodEnd;
        

        $ru_months = array( 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' );
        // English Months
        $en_months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );

        $datetime->setTimestamp($periodStart);
        $data['periodStartName'] = str_ireplace($en_months, $ru_months, $datetime->format('F d, Y'));
        $data['periodStartDate'] = $datetime->format('d-m-Y');
        $datetime->setTimestamp($periodEnd);
        $data['periodEndName'] = str_ireplace($en_months, $ru_months, $datetime->format('F d, Y'));
        $data['periodEndDate'] = $datetime->format('d-m-Y');

        //получаем массив всех товаров (ключи - id товара)
        $allProducts = [];
        $getAllProducts = $this->qb->select('id, unit_in_dal')->get('??product')->fetchAll();
        foreach($getAllProducts as $value){
            $allProducts[$value['id']] = $value;
        }

        //категории
        $categories = [];
        $categoryNames = [];
        $getCategories = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??category');
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            foreach($categories as $value){
                $categoryNames[$value['id']] = $value['name'][LANG_ID];
            }
        }
        $data['categories'] = $categories;
        $data['categoryNames'] = $categoryNames;


        $users = [];
        $getUsers = $this->qb->where('usergroup', '?')->get('??user', [6]);

        if($getUsers->rowCount() > 0){
            $users = $getUsers->fetchAll();
            foreach($users as $key => $value){

                // by fact
                $getOrders = $this->qb->prepare('SELECT * FROM ??order WHERE `user_id` = ? AND `date` >= ? AND `date` < ? AND (`status` = 1 OR `status` = 2 OR `status` = 3)');
                $getOrders->execute([$value['id'], $periodStart, $periodEnd]);
                $periodOrders = $getOrders->fetchAll(\PDO::FETCH_ASSOC);
                $periodOrdersItems = [];
                foreach($periodOrders as $keyQ => $valueQ){
                    $periodOrders[$keyQ]['items'] = json_decode($valueQ['items'], true);
                    foreach($periodOrders[$keyQ]['items'] as $valueQitem){
                        if(!isset($periodOrdersItems[$valueQitem['product_id']])){
                            $periodOrdersItems[$valueQitem['product_id']] = [
                                'product_id' => $valueQitem['product_id'],
                                'quantity_dal' => 0,
                                'quantity' => 0,
                                'sum' => 0
                            ];
                        }
                        $periodOrdersItems[$valueQitem['product_id']]['quantity_dal'] += $valueQitem['quantity'] / $allProducts[$valueQitem['product_id']]['unit_in_dal'];
                        $periodOrdersItems[$valueQitem['product_id']]['quantity'] += $valueQitem['quantity'];
                        $periodOrdersItems[$valueQitem['product_id']]['sum'] += $valueQitem['price'] * $valueQitem['quantity'];
                    }
                }

                //usort($periodOrdersItems, array('\models\back\StatsModel', 'sortDesc'));

                //period build fact
                $users[$key]['period_all_fact_quantity_dal'] = 0;
                $users[$key]['period_all_fact_quantity'] = 0;
                $users[$key]['period_all_fact_sum'] = 0;
                foreach($periodOrdersItems as $qKey => $qItem){
                    $qItemCatId = $this->qb->select('category_id')->where('id', '?')->get('??product', [$qItem['product_id']])->fetch()['category_id'];
                    
                    if(!isset($users[$key]['period_fact'][$qItemCatId])){
                        $users[$key]['period_fact'][$qItemCatId] = [];
                    }
                    if(!isset($users[$key]['period_fact'][$qItemCatId]['quantity_dal'])){
                        $users[$key]['period_fact'][$qItemCatId]['quantity_dal'] = 0;
                    }
                    if(!isset($users[$key]['period_fact'][$qItemCatId]['quantity'])){
                        $users[$key]['period_fact'][$qItemCatId]['quantity'] = 0;
                    }
                    if(!isset($users[$key]['period_fact'][$qItemCatId]['sum'])){
                        $users[$key]['period_fact'][$qItemCatId]['sum'] = 0;
                    }
                    $users[$key]['period_fact'][$qItemCatId]['quantity_dal'] += $qItem['quantity_dal'];
                    $users[$key]['period_fact'][$qItemCatId]['quantity'] += $qItem['quantity'];
                    $users[$key]['period_fact'][$qItemCatId]['sum'] += $qItem['sum'];

                    $users[$key]['period_all_fact_quantity_dal'] += $qItem['quantity_dal'];
                    $users[$key]['period_all_fact_quantity'] += $qItem['quantity'];
                    $users[$key]['period_all_fact_sum'] += $qItem['sum'];
                }

            }
        }
        $data['users'] = $users;
        //$this->ppp($users);


        $controls = [];
        $controls['current'] = $this->linker->getUrl($this->control . '/sales', true);
        $controls['view'] = $this->linker->getUrl($this->control . '/sales/view', true);
        $data['controls'] = $controls;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public static function sortDesc($a, $b) {
        if ($a['quantity'] == $b['quantity']) {
            return 0;
        }
        return ($a['quantity'] < $b['quantity']) ? +1 : -1;
    }

    public static function sortDescSoldQuantity($a, $b) {
        if ($a['sold_quantity'] == $b['sold_quantity']) {
            return 0;
        }
        return ($a['sold_quantity'] < $b['sold_quantity']) ? +1 : -1;
    }
    
}

