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

    public function upload() {
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2]) || !isset($urlPaths[3])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $type = intval($urlPaths[3]);

        $json = getJson();

        $image_parts = explode(";base64,", $json["image"]);
        $image_type_aux = explode("image/", $image_parts[0]);      
        $image_type = $image_type_aux[1];      
        $image_base64 = base64_decode($image_parts[1]);
        $dirPath = _IMG_PATH . "/" . $productId . "/" . $type;
        $uniqidPath = uniqid() . "." . $image_type;
        $filePath = $dirPath . "/" . $uniqidPath;

        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $rs = file_put_contents($filePath, $image_base64); 

        if($rs) {
            $param = [ 
                "product_id" => $productId,
                "type" => $type,
                "path" => $uniqidPath,
                // "path" => end(explode("/", $filePath))
            ];
            $this->model->productImageInsert($param);
        }

        return [_RESULT => $rs ? 1 : 0];
    }

    public function productImageList() {
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $param = [ "product_id" => $productId ];

        return $this->model->productImageList($param);
    }
} 