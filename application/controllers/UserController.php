<?php
namespace application\controllers;

class UserController extends Controller {
    public function signup() {
        $json = getJson();  //배열로 넘어옴
        $rs = $this->model->signUp($json);
        if($rs) {
            $this->flash(_LOGINUSER, $rs);
            return [_RESULT => 1];
        }
        return [_RESULT => 0];
    }
}