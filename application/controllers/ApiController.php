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
} 