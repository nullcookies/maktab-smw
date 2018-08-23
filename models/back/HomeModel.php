<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class HomeModel extends Model {
    
    public function index(){
        
        $data = [];
        
		$this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('main page');

		$this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/flat/blue.css');
		$this->document->addStyle(THEMEURL_ADMIN . '/plugins/morris/morris.css');
		$this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
		$this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
		//$this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
		
		$this->document->addScript(THEMEURL_ADMIN . '/plugins/raphael.min.js');
		$this->document->addScript(THEMEURL_ADMIN . '/plugins/morris/morris.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/ru.js');
		$this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
		$this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
		$this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
		//$this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');

		$newOrders = $this->qb->where('new', '1')->count('??order');
		$data['newOrders'] = $newOrders;
		$data['newOrdersUrl'] = $this->linker->getUrl('order', true);

		$bases = $this->qb->where('usergroup', '6')->count('??user');
		$data['bases'] = $bases;
		$data['basesUrl'] = $this->linker->getUrl('user', true);

		$products = $this->qb->count('??product');
		$data['products'] = $products;
		$data['productsUrl'] = $this->linker->getUrl('product', true);

		//last 30 day orders
		$last30days = time() - 30 * 86400;
		$allOrders = [];
		$orders = [];
		$getOrders = $this->qb->select('items')->where('date >', '?')->get('??order', [$last30days]);
		//$getOrders = $this->qb->select('items')->get('??order', [$last30days]);
		if($getOrders->rowCount() > 0){
			$orders = $getOrders->fetchAll();
			foreach($orders as $value){
				$items = json_decode($value['items'], true);
				if(is_array($items)){
					foreach($items as $v){
						if(!isset($allOrders[$v['product_id']]['product_id'])){
							$allOrders[$v['product_id']]['product_id'] = $v['product_id'];
						}
						if(!isset($allOrders[$v['product_id']]['quantity'])){
							$allOrders[$v['product_id']]['quantity'] = 0;
						}
						if(!isset($allOrders[$v['product_id']]['sum'])){
							$allOrders[$v['product_id']]['sum'] = 0;
						}

						$allOrders[$v['product_id']]['quantity'] += $v['quantity'];
						$allOrders[$v['product_id']]['sum'] += $v['quantity'] * $v['price'];
					}
				}
			}
		}

		//last 30 day orders sum
		$last30daysOrdersSum = 0;
		foreach($allOrders as $value){
			$last30daysOrdersSum += $value['sum'];
		}

		//last 30 day orders categories
		$allOrdersCopy = $allOrders;
		$allOrdersProductIds = [];
		$allOrdersCategories = [];
		foreach($allOrdersCopy as $value){
			$allOrdersProductIds[] = $value['product_id'];
		}

		$salesCategories = $this->qb->select('p.id, p.category_id, c.name')->where('p.id IN', $allOrdersProductIds)->join('??category c', 'p.category_id = c.id')->get('??product p')->fetchAll();
		$salesCategories = $this->langDecode($salesCategories, ['name']);
		
		if($salesCategories){
			foreach($salesCategories as $value1){
				//$this->ppp($value1);
				if(!isset($allOrdersCategories[$value1['category_id']])){
					$allOrdersCategories[$value1['category_id']] = [
						'name' => $value1['name'][LANG_ID],
						'quantity' => 0,
						'sum' => 0
					];
				}
				foreach($allOrdersCopy as $value2){
					if($value1['id'] == $value2['product_id']){
						$allOrdersCategories[$value1['category_id']]['quantity'] += $value2['quantity'];
						$allOrdersCategories[$value1['category_id']]['sum'] += $value2['sum'];
						break 1;
					}
				}
			}
		}
		foreach($allOrdersCategories as $key => $value){
			$allOrdersCategories[$key]['percent'] = 0;
			if($last30daysOrdersSum != 0){
				$allOrdersCategories[$key]['percent'] = round($value['sum'] / $last30daysOrdersSum * 100, 1);
			}
		}

		$data['allOrdersCategories'] = $allOrdersCategories;


		//sort by sum desc
		usort($allOrders, function($a, $b) {
		    return $b['sum'] - $a['sum'];
		});
		//$this->ppp($allOrders);
		$categoryProducts = [];

		//leader product
		$leader = [];
		// $leader = array_shift($allOrders);
		// $leaderProduct = [];
		// $getLeaderProduct = $this->qb->select('id, category_id, name, alias')->where('id', '?')->get('??product', [$leader['product_id']]);
		// if($getLeaderProduct->rowCount() > 0){
		// 	$leaderProduct = $getLeaderProduct->fetch();
		// 	$leaderProduct = $this->langDecode($leaderProduct, ['name'], false);
		// }
		// $leader['name'] = $leaderProduct['name'][LANG_ID];
		// $leader['url'] = $this->linker->getUrl('product/edit/' . $leaderProduct['id'], true);

		$months = [];
		for($i = 5; $i >= 0; $i--){
			$y = ($i >= date('n')) ? (int)date('Y') - 1 : (int)date('Y');
			$m = ($i >= date('n')) ? (int)date('n') - $i + 12 : (int)date('n') - $i;
			$months[] = [
				'm' => $m,
				'y' => $y
			];
		}
		
		$salesInterval = [];
		$datetime = new \DateTime();
		foreach($months as $value){
			$datetime->setDate($value['y'], $value['m'], 1);
			$salesInterval[] = $datetime->getTimestamp();
		}
		$salesInterval[] = time();
		
		$salesSort = [];
		$getSales = $this->qb->select('items, date')->order('date')->where('date >', '?')->get('??order', [$salesInterval[0]]);
		
		if($getSales->rowCount() > 0){
			$sales = $getSales->fetchAll();
			foreach ($salesInterval as $key => $value) {
				
				if($key == 6) {
					break;
				}
				$salesSort[$key] = [
					'y' => date('Y-m', $value),
					'quantity' => 0,
					'sum' => 0
				];
				foreach($sales as $k => $v){
					
					if($v['date'] > $salesInterval[$key + 1]){
						break;
					}
					else{
						$items = json_decode($v['items'], true);
						if(is_array($items)){
							foreach($items as $item){
								$salesSort[$key]['quantity'] += $item['quantity'];
								$salesSort[$key]['sum'] += $item['quantity'] * $item['price'];
							}
						}
						unset($sales[$k]);
					}
				}
			}
				
		}
		$data['salesSort'] = $salesSort;




		$data['leader'] = $leader;

        $this->data = $data;

        return $this;
    }
}



