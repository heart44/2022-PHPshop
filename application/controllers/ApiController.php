<?php
namespace application\controllers;
use Exception;

class ApiController extends Controller {
    public function categoryList() {
        return $this->model->getCategoryList();
    }

    public function productInsert() {
        $json = getJson();        
        return [_RESULT => $this->model->productInsert($json)];
    }

    public function productList() {
        $param = [];

        if(isset($_GET["cate3"])) {
            $cate3 = intval($_GET["cate3"]);
            if($cate3 > 0) {
                $param["cate3"] = $cate3;
            }
        } else {
            if(isset($_GET["cate1"])) {
                $param["cate1"] = $_GET["cate1"];
            }
            if(isset($_GET["cate2"])) {
                $param["cate2"] = $_GET["cate2"];
            }
        }        

        return $this->model->productList($param);         
    }

    public function productList2() {
        return $this->model->productList2();
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

    public function productImageDelete() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 6) {
            exit();
        }

        $rs = 0;
        switch(getMethod()) {
            case _DELETE:
                // $aa = $this->model->productImageSelect($param);
                // $path = _IMG_PATH . "/" . $aa->product_id . "/" . $aa->type . "/" . $aa->path;
                $deletePath = _IMG_PATH . "/" . intval($urlPaths[3]) . "/" . intval($urlPaths[4]) . "/" . $urlPaths[5];
                if(unlink($deletePath)) {
                    $param = [ "product_img_id" => intval($urlPaths[2]) ];
                    $rs = $this->model->productImageDelete($param);
                }
                break;
        }
        return [_RESULT => $rs];
    }

    public function productDelete() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $deletePath = _IMG_PATH . "/" . $productId;
        
        try {
            $param = [ "product_id" => $productId ];
            $this->model->beginTransaction();
            $this->model->productImageDelete($param);
            $rs = $this->model->productDelete($param);
            if($rs === 1) {
                rmdir_all($deletePath);
                $this->model->commit();
            } else {
                $this->model->rollback();
            }
        } catch (Exception $e) {
            print "에러발생!!<br>";
            print $e . "<br>";
            $this->model->rollback();
        }

        return [_RESULT => $rs];
    }

    public function cate1List() {
        return $this->model->cate1List();
    }

    public function cate2List() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }        
        $param = [ "cate1" => $urlPaths[2] ];

        return $this->model->cate2List($param);
    }

    public function cate3List() {
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 4) {
            exit();
        }        
        $param = [ 
            "cate1" => $urlPaths[2], 
            "cate2" => $urlPaths[3]
        ];

        return $this->model->cate3List($param);
    }
} 