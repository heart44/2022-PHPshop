<?php
namespace application\controllers;

class ApiController extends Controller {
    public function categoryList() {
        return $this->model->getCategoryList();
    }

    public function productInsert() {
        $json = getJson();        
        return [_RESULT => $this->model->productInsert($json)];
    }

    public function productList2() {
        $rs = $this->model->productList2();
        return $rs === false ? [] : $rs;
    }

    // public function productDetail() {
    //     $urlPaths = getUrlPaths();
    //     if(!isset($urlPaths[2])) {
    //         exit();
    //     }
    //     $param = [ "productId" => intval($urlPaths[2]) ];
    //     return $this->model->productDetail($param);
    // }
} 