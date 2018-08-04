<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\back\SSPModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class ProductModel extends Model {

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
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/mixitup-3/dist/mixitup.min.js');

        $controls = [];

        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $dataTableAjaxParams = [];
        $dataTableAjaxParams['page-start'] = ($_GET['page_start']) ? $_GET['page_start'] : '';
        $dataTableAjaxParams['page-length'] = ($_GET['page_length']) ? $_GET['page_length'] : '';
        $dataTableAjaxParams['page-order-column'] = ($_GET['page_order_column']) ? $_GET['page_order_column'] : '';
        $dataTableAjaxParams['page-order-dir'] = ($_GET['page_order_dir']) ? $_GET['page_order_dir'] : '';
        $data['dataTableAjaxParams'] = $dataTableAjaxParams;
        

        // $products = [];
        // $getProducts = $this->qb->select('id, sort_number, name, category_id, price, stock_1, stock_2, stock_3, status, date_modify')->order('sort_number')->get('??product');
        // if($getProducts->rowCount() > 0){
        //     $products = $getProducts->fetchAll();
        //     $products = $this->langDecode($products, ['name']);
        // }

        // //категории
        // $categoryNames = [];
        // $getCategories = $this->qb->select('id, name')->get('??category');
        // if($getCategories->rowCount() > 0){
        //     $categories = $getCategories->fetchAll();
        //     foreach($categories as $key => $value){
        //         $categoryNames[$value['id']] = json_decode($value['name'], true);
        //     }
        // }
        
        // $data['categoryNames'] = $categoryNames;
        // $data['products'] = $products;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    public function list_ajax() {
        
        $data = [];

        //все категории
        $categories = $this->getCategoryNames();

        $controls = [];

        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $_POST = $this->cleanForm($_POST);
        //file_put_contents('ppp.txt', print_r($_POST, true));

        //ssp
        // $sql_details = array(
        //     'user' => $this->config['db']['username'],
        //     'pass' => $this->config['db']['password'],
        //     'db'   => $this->config['db']['dbname'],
        //     'host' => $this->config['db']['host']
        // );
        // $table = $this->config['db']['prefix'] . 'product';
        // $primaryKey = 'id';
        // $columns = [
        //     [ 
        //         'db' => 'first_name', 
        //         'dt' => 0,
        //         'formatter' => function( $d, $row ) {
        //             return date( 'jS M y', strtotime($d));
        //         }
        //     ],
            
        // ];

        // $getData = SSPModel::simple( $_POST, $sql_details, $table, $primaryKey, $columns );

        $data['draw'] = (int)$_POST['draw'];

        $totalProducts = $this->qb->select('id')->count('??product');
        $data['recordsTotal'] = $totalProducts;

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
                $order = 'sort_number';
                break;
            
            case 1:
                $order = 'p_name';
                break;
            
            case 2:
                $order = 'c_name';
                break;
            
            case 3:
                $order = 'price';
                break;
            
            case 4:
                $order = 'stock_1';
                break;
            
            case 5:
                $order = 'date_modify';
                break;
            
            case 6:
                $order = 'status';
                break;
            
            default:
                $order = 'p_name';
                break;
        }

        $getOrderDir = $_POST['order'][0]['dir'];
        // if(isset($_POST['page_order_dir'])){
        //     $getOrderDir = $_POST['page_order_dir'];
        // }
        $orderDir = ($getOrderDir == 'desc') ? 'DESC' : 'ASC';


        $recordsFiltered = $totalProducts;

        $search_where = '';
        $where_params = null;

        $search = $_POST['search']['value'];
        $searchText = substr($search, 0, 65536);

        if($searchText){
            $where_params = [];
            $search_where = " (ps.search_text LIKE ? OR cs.search_text LIKE ?) ";
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $querySearch = 'SELECT p.id FROM ??product p LEFT JOIN ??product_search ps ON p.id = ps.product_id LEFT JOIN ??category_search cs ON p.category_id = cs.category_id WHERE ' . $search_where . ' GROUP BY p.id';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $queryProducts = 'SELECT p.id, p.sort_number, pn.name p_name, cn.name c_name, p.category_id, p.price, p.stock_1, p.stock_2, p.stock_3, p.status, p.date_modify FROM ??product p LEFT JOIN ??product_name pn ON p.id = pn.product_id LEFT JOIN ??category_name cn ON p.category_id = cn.category_id ';
        
        if($searchText){
            $queryProducts .= ' LEFT JOIN ??product_search ps ON p.id = ps.product_id LEFT JOIN ??category_search cs ON p.category_id = cs.category_id ';
        }

        $queryProducts .= ' WHERE pn.lang_id = ' . LANG_ID . ' AND (cn.lang_id = ' . LANG_ID . ' OR cn.lang_id = NULL) ';
        if($searchText){
            $queryProducts .= ' AND ' . $search_where;
        }
        $queryProducts .= ' GROUP BY p.id';
        $queryProducts .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ';
        $queryProducts .= ' LIMIT ' . $offset . ', ' . $limit . ' ';

        $getProducts = $this->qb->prepare($queryProducts);
        $getProducts->execute($where_params);

        $products = [];
        if($getProducts->rowCount() > 0){
            $products = $getProducts->fetchAll();
        }

        $productsData = [];
        foreach($products as $value){
            $productsDataRow = [];

            $productsDataRow[0] = $value['sort_number'];
            $productsDataRow[1] = $value['p_name'];
            $productsDataRow[2] = $categories[$value['category_id']]['name'];
            $productsDataRow[3] = $value['price'];
            $productsDataRow[4] = '<i>' . $this->getTranslation('stock 1') . ':&nbsp;</i>' . $value['stock_1'] . '<br>';
            //$productsDataRow[4] .= '<i>' . $this->getTranslation('stock 2') . ':&nbsp;</i>' . $value['stock_2'] . '<br>';
            //$productsDataRow[4] .= '<i>' . $this->getTranslation('stock 3') . ':&nbsp;</i>' . $value['stock_3'] . '<br>';

            $productsDataRow[5] =   '<strong>' . date('d-m-Y', $value['date_modify']) . '</strong><br>' . 
                                    '<span>' . date('H:i', $value['date_modify']) . '</span>';
            $productsDataRow[6] =   '<div class="status-change">' . 
                                    '<input data-toggle="toggle" data-on="' . $this->getTranslation('toggle on') . '" data-off="' . $this->getTranslation('toggle off') . '" data-onstyle="warning" type="checkbox" name="status" data-controller="product" data-table="product" data-id="' . $value['id'] . '" class="status-toggle" ' . (($value['status']) ? 'checked' : '') . '>' .
                                    '</div>';
            $productsDataRow[7] =   '<a class="btn btn-info entry-edit-btn" title="' . $this->getTranslation('btn edit') . '" href="' . $controls['edit'] . $value['id'] . '">' .
                                        '<i class="fa fa-edit"></i>' .
                                    '</a> ' . 
                                    '<a class="btn btn-danger entry-delete-btn" href="' . $controls['delete'] . $value['id'] . '" data-toggle="confirmation" data-btn-ok-label="' . $this->getTranslation('confirm yes') . '" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label=" ' . $this->getTranslation('confirm no') . '" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-danger btn-xs" data-title="' . $this->getTranslation('are you sure') . '" >' . 
                                        '<i title="' . $this->getTranslation('btn delete') . '" class="fa fa-trash-o"></i>' . 
                                    '</a>';
            $productsData[] = $productsDataRow;
        }



        $data['data'] = $productsData;

        $this->data = $data;

        return $this;
    }

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
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/mixitup-3/dist/mixitup.min.js');
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['getFilter'] = $this->linker->getUrl('filter/getFilter', true);
        $controls['getTags'] = $this->linker->getUrl($this->control . '/getTags', true);

        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $loadedVideos = [];
        $initialPreviewVideo = [];
        $initialPreviewConfigVideo = [];

        $filterIds = [];
        $filterValueIds = [];
        

        $current = [];
        if($_POST){
            if($_POST['images']){
                $getLoadedImages = $this->loadedImages($_POST['images']);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
            }
            if($_POST['videos']){
                $getLoadedVideos = $this->loadedVideos($_POST['videos']);
                $loadedVideos = $getLoadedVideos['loadedVideos'];
                $initialPreviewVideo = $getLoadedVideos['initialPreviewVideo'];
                $initialPreviewConfigVideo = $getLoadedVideos['initialPreviewConfigVideo'];
            }

            $filterIds = [];
            $filterValueIds = [];
            if(is_array($_POST['filter_values'])){
                foreach($_POST['filter_values'] as $key => $value){
                    $filterIds[] = $key;
                    if(is_array($value)){
                        foreach($value as $value1){
                            $filterValueIds[] = $value1;
                        }
                    }
                }
            }

            $current = $_POST;

            //опции товара
            $productOptions = [];
            if(is_array($_POST['option'])){

                foreach($_POST['option'] as $key => $value){
                    if($key !== '???'){
                        $productOptions[$key] = $value;
                    }
                }
            }
            $current['options'] = $productOptions;
            
        }

        //картинки из галереи
        if(!isset($current['images_gallery'])){
            $current['images_gallery'] = [];
        }
        if(!is_array($current['images_gallery'])){
            $current['images_gallery'] = json_decode($current['images_gallery']);
        }
        
        $data[$this->control] = $current;

        $data['recommendedSize1'] = $this->getOption('icon_product_large_w') . 'x' . $this->getOption('icon_product_large_h');

        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $data['loadedVideos'] = $loadedVideos;
        $data['initialPreviewVideo'] = $initialPreviewVideo;
        $data['initialPreviewConfigVideo'] = $initialPreviewConfigVideo;

        $data['filterIds'] = $filterIds;
        $data['filterValueIds'] = json_encode($filterValueIds);
        
        //все категории
        $categories = $this->getCategoryNames();
        $data['categories'] = $categories;

        //все товары
        $products = $this->getProductNames();
        $data['products'] = $products;

        //все бренды
        $brands = [];
        $getBrands = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??brand');
        if($getBrands->rowCount() > 0){
            $brands = $getBrands->fetchAll();
            $brands = $this->langDecode($brands, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['brands'] = $brands;

        //все фильтры
        $filters = [];
        $getFilters = $this->qb->select('id, name')->get('??filter')->fetchAll();
        if($getFilters){
            $getFilters = $this->langDecode($getFilters, ['name']);
            foreach($getFilters as $value){
                $filters[$value['id']] = $value['name'][LANG_ID];
            }
            natsort($filters);
        }
        $data['filters'] = $filters;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    
    public function edit($productId = false) {

        if($productId){
            $id = $productId;
        }
        else{
            $id = (int)$_GET['param1'];
            if(!$id){
                $id = (int)$_POST['id'];
            }
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
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/mixitup-3/dist/mixitup.min.js');
        
        $controls = [];
        $controls['back'] = $this->linker->getUrl($this->control, true) . '?page_control=1';
        // if(isset($_GET['page_start'])){
        //     $controls['back'] .= '&page_start=' . $_GET['page_start'];
        // }
        // if(isset($_GET['page_length'])){
        //     $controls['back'] .= '&page_length=' . $_GET['page_length'];
        // }
        // if(isset($_GET['page_order_column'])){
        //     $controls['back'] .= '&page_order_column=' . $_GET['page_order_column'];
        // }
        // if(isset($_GET['page_order_dir'])){
        //     $controls['back'] .= '&page_order_dir=' . $_GET['page_order_dir'];
        // }
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);
        $controls['getFilter'] = $this->linker->getUrl('filter/getFilter', true);
        $controls['getTags'] = $this->linker->getUrl($this->control . '/getTags', true);
        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $loadedVideos = [];
        $initialPreviewVideo = [];
        $initialPreviewConfigVideo = [];

        $filterIds = [];
        $filterValueIds = [];

        $current = [];
        if($id){
            $getProduct = $this->qb->where('id', '?')->get('??product', [$id]);
            if($getProduct->rowCount() > 0){
                $product = $getProduct->fetchAll();
                $product = $this->langDecode($product, ['name', 'descr', 'descr_full', 'specifications', 'meta_t', 'meta_d', 'meta_k']);
                $current = $product[0];

                $current['options'] = json_decode($current['options'], true);
                $current['up_sells'] = json_decode($current['up_sells'], true);
                $current['cross_sells'] = json_decode($current['cross_sells'], true);

                //product images
                $existImages = json_decode($current['images'], true);
                $getLoadedImages = $this->loadedImages($existImages);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];

                //product videos
                $existVideos = json_decode($current['videos'], true);
                $getLoadedVideos = $this->loadedVideos($existVideos);
                $loadedVideos = $getLoadedVideos['loadedVideos'];
                $initialPreviewVideo = $getLoadedVideos['initialPreviewVideo'];
                $initialPreviewConfigVideo = $getLoadedVideos['initialPreviewConfigVideo'];

                //url
                $getAlias = $this->qb->select('id')->where('route', '?')->get('??url', [$this->control . '/view/' . $id]);
                if($getAlias->rowCount() > 0){
                    $aliasId = $getAlias->fetch()['id'];
                }
                else{
                    $aliasId = 0;
                }
                $current['alias_id'] = $aliasId;

                //теги товара
                $getTags = $this->qb->select('t.*')->join('??tag t', 't.id = t2p.tag_id')->where('t2p.product_id', '?')->get('??tag_to_product t2p', [$current['id']])->fetchAll();
                if($getTags){
                    $current['tags'] = [];
                    foreach($this->lang() as $l_key => $l_value){
                        $current['tags'][$l_key] = [];
                    }
                    foreach($getTags as $value){
                        $current['tags'][$value['lang_id']][] = $value['name'];
                    }
                    foreach($current['tags'] as $key => $value){
                        $current['tags'][$key] = implode(',', $value);
                    }
                }

                //фильтры товара
                $getCurrentFilters = $this->qb->select('f.*, fv.id fv_id, fv.name fv_name')->join('??filter_value fv', 'fv.id = f2p.filter_value_id')->join('??filter f', 'f.id = fv.filter_id')->where('f2p.product_id', '?')->get('??filter_to_product f2p', [$current['id']])->fetchAll();
                if($getCurrentFilters){
                    foreach($getCurrentFilters as $value){
                        if(!in_array($value['id'], $filterIds)){
                            $filterIds[] = $value['id'];
                        }
                        $filterValueIds[] = $value['fv_id'];
                    }
                }
                
            }
        }

        if($_POST){
            if($_POST['images']){
                $getLoadedImages = $this->loadedImages($_POST['images']);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
            }
            if($_POST['videos']){
                $getLoadedVideos = $this->loadedVideos($_POST['videos']);
                $loadedVideos = $getLoadedVideos['loadedVideos'];
                $initialPreviewVideo = $getLoadedVideos['initialPreviewVideo'];
                $initialPreviewConfigVideo = $getLoadedVideos['initialPreviewConfigVideo'];
            }
            
            $filterIds = [];
            $filterValueIds = [];
            if(is_array($_POST['filter_values'])){
                foreach($_POST['filter_values'] as $key => $value){
                    $filterIds[] = $key;
                    if(is_array($value)){
                        foreach($value as $value1){
                            $filterValueIds[] = $value1;
                        }
                    }
                }
            }

            $current = $_POST;

            //опции товара
            $productOptions = [];
            if(is_array($_POST['option'])){
                foreach($_POST['option'] as $key => $value){
                    if($key != '???'){
                        $productOptions[$key] = $value;
                    }
                }
            }
            $current['options'] = $productOptions;
        }

        //картинки из галереи
        if(!isset($current['images_gallery'])){
            $current['images_gallery'] = [];
        }
        if(!is_array($current['images_gallery'])){
            $current['images_gallery'] = json_decode($current['images_gallery']);
        }
        
        $data[$this->control] = $current;

        $data['recommendedSize1'] = $this->getOption('icon_product_large_w') . 'x' . $this->getOption('icon_product_large_h');
        
        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $data['loadedVideos'] = $loadedVideos;
        $data['initialPreviewVideo'] = $initialPreviewVideo;
        $data['initialPreviewConfigVideo'] = $initialPreviewConfigVideo;

        $data['filterIds'] = $filterIds;
        $data['filterValueIds'] = json_encode($filterValueIds);

        //все категории
        $categories = $this->getCategoryNames();
        $data['categories'] = $categories;

        //все товары
        $products = $this->getProductNames();
        $data['products'] = $products;

        //все бренды
        $brands = [];
        $getBrands = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??brand');
        if($getBrands->rowCount() > 0){
            $brands = $getBrands->fetchAll();
            $brands = $this->langDecode($brands, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['brands'] = $brands;

        //все фильтры
        $filters = [];
        $getFilters = $this->qb->select('id, name')->get('??filter')->fetchAll();
        if($getFilters){
            $getFilters = $this->langDecode($getFilters, ['name']);
            foreach($getFilters as $value){
                $filters[$value['id']] = $value['name'][LANG_ID];
            }
            natsort($filters);
        }
        $data['filters'] = $filters;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false, $import = []){
        $isUniqueParamsSku = [
            'table' => '??product',
            'column' => 'sku'
        ];
        $isUniqueParamsAlias = [
            'table' => '??url',
            'column' => 'alias'
        ];
        if(!$new) {
            $id = (int)$_POST['id'];
            $alias_id = (int)$_POST['alias_id'];
            $isUniqueParamsSku['id'] = $id;
            $isUniqueParamsAlias['id'] = $alias_id;
        }

        

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
                'category_id' => ['isRequired', 'isNaturalNumber'],
                'sku' => ['isRequired', ['isUnique', $isUniqueParamsSku]],
                'alias' => ['isRequired', 'isAlias', ['isUnique', $isUniqueParamsAlias]],
                //'unit_in_block' => ['isRequired', 'isInt'],
                //'unit_in_dal' => ['isRequired', 'isInt'],
                'price' => ['isRequired'],
                //'price_orig' => ['isRequired'],
            ]

        ];

        $_POST = $this->cleanForm($_POST);
        //$_POST['excise'] = (float)str_replace(',', '.', $_POST['excise']);
        $_POST['alias'] = strtolower($_POST['alias']);
        $_POST['category_id'] = (int)$_POST['category_id'];
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

                $productOptions = [];
                //опции товара
                if(is_array($_POST['option'])){
                    foreach($_POST['option'] as $key => $value){
                        if($key !== '???'){
                            $productOptions[$key] = $value;
                        }
                    }
                }
                $update['options'] = json_encode($productOptions, JSON_UNESCAPED_UNICODE);

                $update['up_sells'] = json_encode($_POST['up_sells'], JSON_UNESCAPED_UNICODE);
                $update['cross_sells'] = json_encode($_POST['cross_sells'], JSON_UNESCAPED_UNICODE);

                $update['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);
                $update['images_gallery'] = '';
                if(isset($_POST['images_gallery']) && is_array($_POST['images_gallery'])){
                    $update['images_gallery'] = json_encode($_POST['images_gallery'], JSON_UNESCAPED_UNICODE);
                }

                $update['videos'] = json_encode($_POST['videos'], JSON_UNESCAPED_UNICODE);

                $update['alias'] = $_POST['alias'];
                
                $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $update['sku'] = $_POST['sku'];
                $update['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
                $update['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);

                $update['specifications'] = json_encode($_POST['specifications'], JSON_UNESCAPED_UNICODE);
                
                $update['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
                $update['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
                $update['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);
                
                $update['category_id'] = (int)$_POST['category_id'];
                $update['brand_id'] = (int)$_POST['brand_id'];

                $update["status"] = ($_POST["status"]) ? 1 : 0;
                $update["request_product"] = ($_POST["request_product"]) ? 1 : 0;
                $update["recommended"] = ($_POST["recommended"]) ? 1 : 0;
                $update["sort_number"] = (int)$_POST["sort_number"];

                $update["video_code"] = $_POST["video_code"];

                //$update["excise"] = (float)$_POST["excise"];
                //$update["nds"] = (int)$_POST["nds"];

                //$update["price_orig"] = (float)$_POST["price_orig"];
                $update["price"] = (float)$_POST["price"];
                $update["discount"] = (int)$_POST["discount"];

                //$update["unit_in_block"] = (int)$_POST["unit_in_block"];
                //$update["unit_in_dal"] = (int)$_POST["unit_in_dal"];

                $update["stock_1"] = (int)$_POST["stock_1"];
                //$update["stock_2"] = (int)$_POST["stock_2"];
                //$update["stock_3"] = (int)$_POST["stock_3"];

                //$update["unit"] = htmlspecialchars($_POST["unit"]);
                
                $update["date_modify"] = time();

                $updateResult = $this->qb->where('id', '?')->update('??product', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    //обновление url товара
                    $urlInsertUpdate = [
                        'alias' => $_POST['alias'],
                        'route' => $this->control . '/view/' . $id
                    ];
                    $this->qb->insertUpdate('??url', $urlInsertUpdate);

                    //обновление поисковой и сортировочной информации товара
                    $searchInsertUpdate = [
                        'product_id' => $id,
                        //'search_text' => implode(' ', $_POST['name']) . ' ' . implode(' ', $_POST['descr'])
                        'search_text' => implode(' ', $_POST['name'])
                    ];
                    $this->qb->insertUpdate('??product_search', $searchInsertUpdate);
                    foreach($_POST['name'] as $key => $value){
                        $nameInsertUpdate = [
                            'product_id' => $id,
                            'lang_id' => $key,
                            'name' => $value
                        ];
                        $this->qb->insertUpdate('??product_name', $nameInsertUpdate);
                    }

                    //обновление тегов товара
                    if(is_array($_POST['tags'])){
                        $tagsSth = $this->qb->prepare('SELECT * FROM ??tag WHERE name = ? AND lang_id = ?');
                        $tagsInsertSth = $this->qb->prepare('INSERT INTO ??tag (id, name, lang_id) VALUES (NULL, ?, ?)');
                        $tagIds = [];
                        foreach($_POST['tags'] as $key => $value){
                            $values = explode(',', $value);
                            foreach($values as $value1){
                                $tagsSth->execute([$value1, $key]);
                                if($tagsSth->rowCount() > 0){
                                    $tagId = $tagsSth->fetch()['id'];
                                }
                                else{
                                    $tagsInsertSth->execute([$value1, $key]);
                                    $tagId = $this->qb->lastInsertId();
                                }
                                $tagIds[] = $tagId;
                            }
                        }
                        $this->qb->query('DELETE FROM ??tag_to_product WHERE product_id = ' . $id);
                        if($tagIds){
                            $tag2productSth = $this->qb->prepare('INSERT INTO ??tag_to_product (product_id, tag_id) VALUES (?, ?)');
                            foreach($tagIds as $value){
                                $tag2productSth->execute([$id, $value]);
                            }
                        }
                    }

                    //обновление фильтров
                    $filterValueIds = [];
                    if(is_array($_POST['filter_values'])){
                        foreach($_POST['filter_values'] as $value){
                            if(is_array($value)){
                                foreach($value as $value1){
                                    $filterValueIds[] = $value1;
                                }
                            }
                        }
                    }
                    $this->qb->query('DELETE FROM ??filter_to_product WHERE product_id = ' . $id);
                    $filter2productSth = $this->qb->prepare('INSERT INTO ??filter_to_product (product_id, filter_value_id) VALUES (?, ?)');
                    foreach($filterValueIds as $value){
                        $filter2productSth->execute([$id, $value]);
                    }
                    
                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
                
            }
            else{
                $insert = [];

                $productOptions = [];
                //опции товара
                if(is_array($_POST['option'])){
                    foreach($_POST['option'] as $key => $value){
                        if($key !== '???'){
                            $productOptions[$key] = $value;
                        }
                    }
                }
                $insert['options'] = json_encode($productOptions, JSON_UNESCAPED_UNICODE);

                $insert['up_sells'] = json_encode($_POST['up_sells'], JSON_UNESCAPED_UNICODE);
                $insert['cross_sells'] = json_encode($_POST['cross_sells'], JSON_UNESCAPED_UNICODE);

                $insert['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);
                $insert['images_gallery'] = '';
                if(isset($_POST['images_gallery']) && is_array($_POST['images_gallery'])){
                    $insert['images_gallery'] = json_encode($_POST['images_gallery'], JSON_UNESCAPED_UNICODE);
                }

                $insert['videos'] = json_encode($_POST['videos'], JSON_UNESCAPED_UNICODE);
                
                $insert['alias'] = $_POST['alias'];

                $insert['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $insert['sku'] = $_POST['sku'];
                $insert['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
                $insert['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);
                
                $insert['specifications'] = json_encode($_POST['specifications'], JSON_UNESCAPED_UNICODE);

                $insert['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
                $insert['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
                $insert['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);

                $insert['category_id'] = (int)$_POST['category_id'];
                $insert['brand_id'] = (int)$_POST['brand_id'];

                $insert["status"] = ($_POST["status"]) ? 1 : 0;
                $insert["request_product"] = ($_POST["request_product"]) ? 1 : 0;
                $insert["recommended"] = ($_POST["recommended"]) ? 1 : 0;
                $insert["sort_number"] = (int)$_POST["sort_number"];

                $insert["video_code"] = $_POST["video_code"];
                
                //$insert["excise"] = (float)$_POST["excise"];
                //$insert["nds"] = (int)$_POST["nds"];

                //$insert["price_orig"] = (float)$_POST["price_orig"];
                $insert["price"] = (float)$_POST["price"];
                $insert["discount"] = (int)$_POST["discount"];
                
                //$insert["unit_in_block"] = (int)$_POST["unit_in_block"];
                //$insert["unit_in_dal"] = (int)$_POST["unit_in_dal"];
                
                $insert["stock_1"] = (int)$_POST["stock_1"];
                //$insert["stock_2"] = (int)$_POST["stock_2"];
                //$insert["stock_3"] = (int)$_POST["stock_3"];

                //$insert["unit"] = htmlspecialchars($_POST["unit"]);

                $insert["date_add"] = time();
                $insert["date_modify"] = time();

                $insertResult = $this->qb->insert('??product', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();
                    $this->productId = $id;
                    
                    //обновление url товара
                    $urlInsert = [
                        'alias' => $_POST['alias'],
                        'route' => $this->control . '/view/' . $id
                    ];
                    $this->qb->insert('??url', $urlInsert);

                    //обновление поисковой и сортировочной информации товара
                    $searchInsert = [
                        'product_id' => $id,
                        //'search_text' => implode(' ', $_POST['name']) . ' ' . implode(' ', $_POST['descr'])
                        'search_text' => implode(' ', $_POST['name'])
                    ];
                    $this->qb->insert('??product_search', $searchInsert);
                    foreach($_POST['name'] as $key => $value){
                        $nameInsertUpdate = [
                            'product_id' => $id,
                            'lang_id' => $key,
                            'name' => $value
                        ];
                        $this->qb->insertUpdate('??product_name', $nameInsertUpdate);
                    }

                    //обновление тегов товара
                    if(is_array($_POST['tags'])){
                        $tagsSth = $this->qb->prepare('SELECT * FROM ??tag WHERE name = ? AND lang_id = ?');
                        $tagsInsertSth = $this->qb->prepare('INSERT INTO ??tag (id, name, lang_id) VALUES (NULL, ?, ?)');
                        $tagIds = [];
                        foreach($_POST['tags'] as $key => $value){
                            $values = explode(',', $value);
                            foreach($values as $value1){
                                $tagsSth->execute([$value1, $key]);
                                if($tagsSth->rowCount() > 0){
                                    $tagId = $tagsSth->fetch()['id'];
                                }
                                else{
                                    $tagsInsertSth->execute([$value1, $key]);
                                    $tagId = $this->qb->lastInsertId();
                                }
                                $tagIds[] = $tagId;
                            }
                        }
                        $this->qb->query('DELETE FROM ??tag_to_product WHERE product_id = ' . $id);
                        if($tagIds){
                            $tag2productSth = $this->qb->prepare('INSERT INTO ??tag_to_product (product_id, tag_id) VALUES (?, ?)');
                            foreach($tagIds as $value){
                                $tag2productSth->execute([$id, $value]);
                            }
                        }
                    }

                    //обновление фильтров
                    $filterValueIds = [];
                    if(is_array($_POST['filter_values'])){
                        foreach($_POST['filter_values'] as $value){
                            if(is_array($value)){
                                foreach($value as $value1){
                                    $filterValueIds[] = $value1;
                                }
                            }
                        }
                    }
                    $this->qb->query('DELETE FROM ??filter_to_product WHERE product_id = ' . $id);
                    $filter2productSth = $this->qb->prepare('INSERT INTO ??filter_to_product (product_id, filter_value_id) VALUES (?, ?)');
                    foreach($filterValueIds as $value){
                        $filter2productSth->execute([$id, $value]);
                    }

                    $this->successText = $this->getTranslation('success add ' . $this->control);
                    return true;
                }
            }
        }
    }

    public function toggle() {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];
        $return = '';
        if($id){
            $result = $this->qb->where('id', '?')->update('??product', ['status' => $status], [$id]);
            if($result){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete($force_id = NULL){

        $id = (int)$_GET['param1'];
        
        if($force_id){
            $id = $force_id;
        }

        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }


        $getProduct = $this->qb->where('id', '?')->get('??product', [$id]);
        if($getProduct->rowCount() > 0){
            $product = $getProduct->fetch();
        }
        
        //удаляем картинки
        if($product['image']){
            $this->media->delete($product['image']);
        }
        if($product['images']){
            $images = json_decode($product['images'], true);
            if(is_array($images)){
                foreach($images as $key => $value){
                    $images[$key] = (int)$value;
                }
                if($images){
                    $files = $this->qb->where('id IN', $images)->get('??file')->fetchAll();
                    if($files){
                        $imageDeleteSth = $this->qb->prepare('DELETE FROM ??file WHERE id = ?');
                        foreach($files as $value){
                            $file = BASEPATH . '/uploads/' . $value['path'];
                            if(file_exists($file)){
                                unlink($file);
                            }
                            $imageDeleteSth->execute([$value['id']]);
                        }
                    }
                }
            } 
        }
		
        //удаляем url
        $this->qb->where('route', '?')->delete('??url', ['product/view/' . $id]);

        //удаляем search
        $this->qb->where('product_id', '?')->delete('??product_search', [$id]);

        //удаляем name
        $this->qb->where('product_id', '?')->delete('??product_name', [$id]);
        
        //удаляем фильтры
        $this->qb->where('product_id', '?')->delete('??filter_to_product', [$id]);
        
        //удаляем теги
		$this->qb->where('product_id', '?')->delete('??tag_to_product', [$id]);

        //удаляем товар
        $resultDelete = $this->qb->where('id', '?')->delete('??product', [$id]);
        
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

    public function getTags() {   
        $tags = [];

        $getTags = $this->qb->select('name')->group('name')->get('??tag')->fetchAll();
        foreach($getTags as $value){
            $tags[] = $value['name'];
        }

        return $tags;
    }

    public function getProductNames(){
        $products = [];
        $getProducts = $this->qb->select('p.id, pn.name')->join('??product_name pn', 'p.id = pn.product_id')->where('pn.lang_id', LANG_ID)->order('pn.name')->get('??product p');
        if($getProducts->rowCount() > 0){
            $products = $getProducts->fetchAll();
        }
        return $products;
    }

    public function getCategoryNames(){
        $categories = [];
        $rawCategories = [];
        $getCategories = $this->qb->select('c.id, c.parent_category_id, cn.name')->join('??category_name cn', 'c.id = cn.category_id')->where([['cn.lang_id', LANG_ID]])->order('cn.name')->get('??category c');
        if($getCategories->rowCount() > 0){
            $getCategories = $getCategories->fetchAll();
            foreach($getCategories as $value){
                $rawCategories[$value['id']] = [
                    'id' => $value['id'],
                    'parent_category_id' => $value['parent_category_id'],
                    'name' => $value['name']
                ];
            }
            foreach ($rawCategories as $key => $value) {
                $catParentNames = $this->getParentCategories($key, $rawCategories);
                if(count($catParentNames) > 0){
                    if(count($catParentNames) > 1){
                        $catParentNames = array_reverse($catParentNames);
                    }
                }
                $catParentNames[] = $value['name'];
                $categories[$key] = [
                    'name' => implode(' >> ', $catParentNames),
                    'id' => $value['id'],
                    'parent_category_id' => $value['parent_category_id'],
                ];
            }
        }
        uasort($categories, array('\system\Model', 'sortByName'));
        return $categories;
    }

    public function getParentCategories($categoryID, $categories, $parentNames = []){
        if($categories[$categoryID]['parent_category_id'] > 0){
            $parentNames[] = $categories[$categories[$categoryID]['parent_category_id']]['name'];
            if($categories[$categories[$categoryID]['parent_category_id']]['parent_category_id'] > 0){
                $parentNames = $this->getParentCategories($categories[$categoryID]['parent_category_id'], $categories, $parentNames);
            }
        }
        return $parentNames;
    }
    
}

