<?php

namespace controllers\front;

use \system\Controller;
use \models\front\CartModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends Controller {

    public function index() {
        $this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
        ];
        $model = new CartModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('cart');
    }

    public function checkout() {
        $this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
        ];
        $model = new CartModel;
        if($model){
            $model->checkout();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('cart-checkout');
    }

    public function request() {
        $model = new CartModel;
        if($model){
            $model->request();
            $this->data = $model->data;
        }
        $this->json($this->data);
    }

    public function add() {
        $model = new CartModel;
        if($model){
            $model->add();
            $this->data = $model->data;
        }
        $this->json($this->data);
    }

    public function change() {
        $response = [];
        $model = new CartModel;
        if($model){
            $model->change();
            $response = [];
            $response['info'] = $model->data;

            $model->index();
            $this->data = $model->data;
            $response['cart'] = $this->render('cart');
        }
        $this->json($response);
    }

    public function delete() {
        $response = [];
        $model = new CartModel;
        if($model){
            $model->delete();
            $response = [];
            $response['info'] = $model->data;

            $model->index();
            $this->data = $model->data;
            $response['cart'] = $this->render('cart');
        }
        $this->json($response);
    }

    public function applyCoupon() {
        $response = [];
        $model = new CartModel;
        if($model){
            $model->applyCoupon();
            $response = [];
            $response['info'] = $model->data;

            $model->index();
            $this->data = $model->data;
            $response['cart'] = $this->render('cart');
        }
        $this->json($response);
    }


}


